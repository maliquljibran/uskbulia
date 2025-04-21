<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding: 20px;
            color: #2d1b4e;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ff8c38;
            padding-bottom: 10px;
        }
        .transaction-details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .transaction-details th, .transaction-details td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .transaction-details th {
            background-color: #f8f1e9;
            width: 40%;
        }
        .school-info {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
            color: #706b62;
        }
        .success {
            color: #00cc66;
            font-weight: bold;
        }
        .warning {
            color: #ffb07f;
            font-weight: bold;
        }
        .danger {
            color: #ff4d4d;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Detail Transaksi</h2>
        <p>{{ date('d F Y H:i:s') }}</p>
    </div>
    
    <table class="transaction-details">
        <tr>
            <th>ID Transaksi</th>
            <td>{{ $transaction->id }}</td>
        </tr>
        <tr>
            <th>Tanggal & Waktu</th>
            <td>{{ $transaction->created_at->format('d M Y, H:i:s') }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $transaction->description }}</td>
        </tr>
        <tr>
            <th>Jumlah Keluar</th>
            <td>{{ $transaction->debit > 0 ? 'Rp ' . number_format($transaction->debit, 0, ',', '.') : '-' }}</td>
        </tr>
        <tr>
            <th>Jumlah Masuk</th>
            <td>{{ $transaction->credit > 0 ? 'Rp ' . number_format($transaction->credit, 0, ',', '.') : '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if($transaction->status === 'done')
                    <span class="success">Selesai</span>
                @elseif($transaction->status === 'process')
                    <span class="warning">Diproses</span>
                @elseif($transaction->status === 'rejected')
                    <span class="danger">Ditolak</span>
                @else
                    <span>Tidak diketahui</span>
                @endif
            </td>
        </tr>
        @if($transaction->status === 'rejected')
        <tr>
            <th>Alasan Penolakan</th>
            <td>{{ $transaction->rejection_reason ?? 'Tidak ada alasan yang tercatat' }}</td>
        </tr>
        @endif
    </table>
    
    <div class="school-info">
        <p><strong>Dokumen ini diterbitkan secara elektronik oleh sistem E-Wallet Sekolah</strong></p>
        <p>© {{ date('Y') }} E-Wallet Sekolah</p>
    </div>
</body>
</html>