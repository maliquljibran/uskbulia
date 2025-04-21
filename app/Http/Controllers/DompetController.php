<?php

namespace App\Http\Controllers;

use App\Models\Dompet;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class DompetController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,bank')->only('allMutasi');
    }

    public function topup(Request $request)
    {   
        $request->validate([
            'credit' => 'required|numeric|min:10000'
        ]);

        Dompet::create([
            'user_id' => Auth::id(),
            'debit' => 0,
            'credit' => $request->credit,
            'description' => 'Top-up',
            'status' => 'process'
        ]);

        return redirect()->back()->with('status', 'Permintaan Top-Up anda sedang diproses');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'credit' => 'required|numeric|min:10000'
        ]);

        $user = Auth::user();
        $totalSaldo = Dompet::where('user_id', $user->id)
            ->where('status', 'done')
            ->sum(DB::raw('credit - debit'));

        // Check if balance is zero
        if ($totalSaldo == 0) {
            return redirect()->back()->with('error', 'Saldo Anda nol, tidak dapat melakukan Tarik Tunai.');
        }

        // Check if balance is sufficient
        if ($totalSaldo < $request->credit) {
            return redirect()->back()->with('error', 'Saldo anda tidak mencukupi.');
        }

        Dompet::create([
            'user_id' => $user->id,
            'debit' => $request->credit,
            'credit' => 0,
            'description' => 'Tarik Tunai',
            'status' => 'process',
        ]);

        return redirect()->back()->with('status', 'Tarik Tunai sedang diproses');
    }

    public function bankTopupToSiswa(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:10000',
        ]);

        Dompet::create([
            'user_id' => $request->siswa_id,
            'credit' => $request->amount,
            'debit' => 0,
            'description' => 'Top-up oleh Bank',
            'status' => 'done'
        ]);

        return redirect()->back()->with('success', 'Top-up berhasil dilakukan ke siswa.');
    }

    public function bankWithdrawFromSiswa(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:10000',
        ]);

        $totalSaldo = Dompet::where('user_id', $request->siswa_id)
            ->where('status', 'done')
            ->sum(DB::raw('credit - debit'));

        // Check if balance is zero
        if ($totalSaldo == 0) {
            return redirect()->back()->with('error', 'Saldo siswa nol, tidak dapat melakukan Tarik Tunai.');
        }

        // Check if balance is sufficient (allow balance to become zero)
        if ($totalSaldo < $request->amount) {
            return redirect()->back()->with('error', 'Saldo siswa tidak mencukupi.');
        }

        Dompet::create([
            'user_id' => $request->siswa_id,
            'credit' => 0,
            'debit' => $request->amount,
            'description' => 'Withdraw oleh Bank',
            'status' => 'done'
        ]);

        return redirect()->back()->with('success', 'Tarik Tunai berhasil dilakukan untuk siswa.');
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'recepient_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $sender = Auth::user();
        $recepient = User::find($request->recepient_id);

        // Prevent transfer to self
        if ($sender->id == $request->recepient_id) {
            return redirect()->back()->with('error', 'Anda tidak dapat mentransfer ke akun sendiri.');
        }

        $saldo = Dompet::where('user_id', $sender->id)
            ->where('status', 'done')
            ->sum(DB::raw('credit - debit'));

        // Check if balance is zero
        if ($saldo == 0) {
            return redirect()->back()->with('error', 'Saldo Anda nol, tidak dapat melakukan transfer.');
        }

        // Check if balance is sufficient
        if ($saldo < $request->amount) {
            return redirect()->back()->with('error', 'Saldo pengirim tidak mencukupi.');
        }

        Dompet::create([
            'user_id' => $sender->id,
            'credit' => 0,
            'debit' => $request->amount,
            'description' => 'Transfer ke ' . $recepient->name,
            'status' => 'done',
        ]);

        Dompet::create([
            'user_id' => $recepient->id,
            'credit' => $request->amount,
            'debit' => 0,
            'description' => 'Transfer dari ' . $sender->name,
            'status' => 'done',
        ]);

        return redirect()->back()->with('success', 'Transfer berhasil.');
    }

    public function acceptRequest(Request $request, $dompetId)
    {
        $dompet = Dompet::findOrFail($dompetId);

        // Only process withdrawals (Top-up requests don't need balance checks)
        if ($dompet->description === 'Withdraw Saldo') {
            $totalSaldo = Dompet::where('user_id', $dompet->user_id)
                ->where('status', 'done')
                ->sum(DB::raw('credit - debit'));

            // Check if balance is zero
            if ($totalSaldo == 0) {
                $dompet->update(['status' => 'rejected']);
                return redirect()->back()->with('error', 'Permintaan ditolak karena saldo siswa 0.');
            }

            // Check if balance is sufficient (allow balance to become zero)
            if ($totalSaldo < $dompet->debit) {
                $dompet->update(['status' => 'rejected']);
                return redirect()->back()->with('error', 'Permintaan ditolak karena saldo siswa tidak mencukupi.');
            }
        }

        $dompet->update(['status' => 'done']);

        return redirect()->back()->with('status', 'Permintaan Berhasil disetujui');
    }

    public function rejectRequest(Request $request, $dompetId)
    {
        $dompet = Dompet::findOrFail($dompetId);
        $dompet->status = 'rejected';
        $dompet->save();

        return redirect()->back()->with('status', 'Permintaan Ditolak');
    }

    public function allMutasi()
    {
        $mutasi = Dompet::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('wallet.all', compact('mutasi'));
    }

    public function mutasi(Request $request)
{
    $user = Auth::user();
    $filter = $request->input('filter');
    $search = $request->input('search');
    $sort = $request->input('sort', 'newest'); // Default to newest if not specified

    $query = Dompet::where('user_id', $user->id);

    // Apply type filter
    if ($filter === 'topup') {
        $query->where(function($q) {
            $q->where('description', 'Top-up')
              ->orWhere('description', 'LIKE', '%Top-up%');
        });
    } elseif ($filter === 'withdraw') {
        $query->where(function($q) {
            $q->where('description', 'Tarik Tunai')
              ->orWhere('description', 'LIKE', '%Withdraw%')
              ->orWhere('description', 'LIKE', '%Tarik%');
        });
    } elseif ($filter === 'transfer') {
        $query->where('description', 'LIKE', '%Transfer%');
    } elseif ($filter === 'rejected') {
        $query->where('status', 'rejected');
    }

    // Apply search if provided
    if ($search) {
        $query->where(function($q) use ($search) {
            // Search in description
            $q->where('description', 'LIKE', '%' . $search . '%');
            // No need to search by user name since we already filter by user_id
        });
    }

    // Apply sorting
    if ($sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } else {
        // Default to newest
        $query->orderBy('created_at', 'desc');
    }

    $mutasi = $query->paginate(10);
    
    // Make sure pagination keeps the current query parameters
    $mutasi->appends($request->all());

    return view('siswa.mutasi', compact('mutasi'));
}

    public function all(Request $request)
{
    $filter = $request->input('filter');
    $search = $request->input('search');
    $sort = $request->input('sort', 'newest'); // Default to newest if not specified

    $query = Dompet::with('user');

    // Apply type filter
    if ($filter === 'topup') {
        $query->where(function($q) {
            $q->where('description', 'Top-up')
              ->orWhere('description', 'LIKE', '%Top-up%');
        });
    } elseif ($filter === 'withdraw') {
        $query->where(function($q) {
            $q->where('description', 'Tarik Tunai')
              ->orWhere('description', 'LIKE', '%Withdraw%')
              ->orWhere('description', 'LIKE', '%Tarik%');
        });
    } elseif ($filter === 'transfer') {
        $query->where('description', 'LIKE', '%Transfer%');
    } elseif ($filter === 'rejected') {
        $query->where('status', 'rejected');
    }

    // Apply search if provided
    if ($search) {
        $query->where(function($q) use ($search) {
            // Search in description
            $q->where('description', 'LIKE', '%' . $search . '%')
              // Search by user name (using relationship)
              ->orWhereHas('user', function($query) use ($search) {
                  $query->where('name', 'LIKE', '%' . $search . '%');
              });
        });
    }

    // Apply sorting
    if ($sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } else {
        // Default to newest
        $query->orderBy('created_at', 'desc');
    }

    $mutasi = $query->paginate(10);
    
    // Make sure pagination keeps the current query parameters
    $mutasi->appends($request->all());

    return view('wallet.all', compact('mutasi'));
}


public function exportPDF(Request $request)
{
    $filter = $request->input('filter');
    $search = $request->input('search');
    $sort = $request->input('sort', 'newest'); // Default to newest if not specified
    $user = Auth::user();
    
    $query = Dompet::with('user');
    
    // If the user is a student, only show their transactions
    if ($user->role === 'siswa') {
        $query->where('user_id', $user->id);
    }
    
    // Apply the same filters as in the all() method
    if ($filter === 'topup') {
        $query->where(function($q) {
            $q->where('description', 'Top-up')
              ->orWhere('description', 'LIKE', '%Top-up%');
        });
    } elseif ($filter === 'withdraw') {
        $query->where(function($q) {
            $q->where('description', 'Tarik Tunai')
              ->orWhere('description', 'LIKE', '%Withdraw%')
              ->orWhere('description', 'LIKE', '%Tarik%');
        });
    } elseif ($filter === 'transfer') {
        $query->where('description', 'LIKE', '%Transfer%');
    } elseif ($filter === 'rejected') {
        $query->where('status', 'rejected');
    }
    
    // Apply search if provided
    if ($search) {
        $query->where(function($q) use ($search) {
            // Search in description
            $q->where('description', 'LIKE', '%' . $search . '%')
              // Search by user name (using relationship)
              ->orWhereHas('user', function($query) use ($search) {
                  $query->where('name', 'LIKE', '%' . $search . '%');
              });
        });
    }
    
    // Apply sorting
    if ($sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } else {
        // Default to newest
        $query->orderBy('created_at', 'desc');
    }
    
    $mutasi = $query->get();
    
    // Pass filter, search, and sort parameters to the view
    $filter_text = '';
    if ($filter) {
        $filter_text = match($filter) {
            'topup' => 'Top-up',
            'withdraw' => 'Tarik Tunai',
            'transfer' => 'Transfer',
            'rejected' => 'Ditolak',
            default => ''
        };
    }
    
    $sort_text = $sort === 'oldest' ? 'Terlama' : 'Terbaru';
    
    $pdf = Pdf::loadView('riwayat-transaksi', compact('mutasi', 'filter_text', 'search', 'sort_text'));
    
    $filename = 'riwayat_transaksi';
    if ($filter_text) {
        $filename .= '_' . strtolower($filter_text);
    }
    if ($search) {
        $filename .= '_search_' . str_replace(' ', '_', $search);
    }
    $filename .= '_' . strtolower($sort_text);
    $filename .= '.pdf';
    
    return $pdf->download($filename);
    }

    public function downloadSingleTransactionPDF($id)
{
    $transaction = Dompet::with('user')
                    ->findOrFail($id);
    
    // Check permission - if user is admin, allow any transaction
    // If user is student, only allow their own transactions
    if (Auth::user()->role !== 'admin' && Auth::user()->id !== $transaction->user_id) {
        abort(403, 'Unauthorized action.');
    }
    
    // Generate a transaction-specific title
    $title = 'Transaksi_' . preg_replace('/[^A-Za-z0-9]/', '_', $transaction->description);
    $timestamp = date('Ymd_His');
    $filename = $title . '_' . $timestamp . '.pdf';
    
    // Load PDF view for a single transaction
    $pdf = Pdf::loadView('riwayat-transaksi-single', compact('transaction'));
    
    return $pdf->download($filename);
}
}