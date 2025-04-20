<?php
namespace App\Http\Controllers;

use App\Models\Dompet;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('filter');

        $filterMutasi = function ($query) use ($filter) {
            if ($filter == 'topup') {
                $query->where('description', 'like', '%Top-up%');
            } elseif ($filter == 'withdraw') {
                $query->where('description', 'like', '%Withdraw%');
            } elseif ($filter == 'transfer') {
                $query->where('description', 'like', '%Transfer%');
            }

            
            if ($filter == 'done') {
                $query->where('status', 'done');
            } elseif ($filter == 'process') {
                $query->where('status', 'process');
            } elseif ($filter == 'rejected') {
                $query->where('status', 'reject');
            }

            return $query;
        };


        
        if ($user->role == 'admin') {
            $users = User::all();

            $mutasiQuery = Dompet::where('status', 'done');
            $mutasi = $filterMutasi($mutasiQuery)->orderBy('created_at', 'desc')->get();

            return view('home', compact('users', 'mutasi'));
        }

       
        if ($user->role == 'bank') {
            $dompet = Dompet::where('status', 'done')->get();
            $credit = $dompet->sum('credit');
            $debit  = $dompet->sum('debit');
            $saldo = $credit - $debit;

            $users = User::where('role', 'siswa')->get();
            $request_payment = Dompet::where('status', 'process')->orderBy('created_at', 'DESC')->get();

            $mutasiQuery = Dompet::where('status', 'done');
            $mutasi = $filterMutasi($mutasiQuery)->orderBy('created_at', 'DESC')->get();

            $allMutasi = Dompet::where('status', 'done')->count();

            return view('home', compact('saldo', 'users', 'request_payment', 'mutasi', 'allMutasi'));
        }

        if ($user->role == 'siswa') {
           
            $dompets = Dompet::where('user_id', $user->id)->where('status', 'done')->get();
            $credit = $dompets->sum('credit');
            $debit  = $dompets->sum('debit');
            $saldo = $credit - $debit;

            
            $mutasiQuery = Dompet::where('user_id', $user->id)->whereIn('status', ['done', 'process', 'rejected']);
            $mutasi = $filterMutasi($mutasiQuery)->orderBy('created_at', 'desc')->get();


            
            $users = User::where('role', 'siswa')->where('id', '!=', $user->id)->get();

            
            return view('home', compact('saldo', 'mutasi', 'users'));
        }


        return redirect()->route('home');
    }

    
}
