<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        h1 {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #ea580c;
        }
        .filter-info {
            font-size: 14px;
            margin-bottom: 15px;
            color: #555;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f97316;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #fff7ed;
        }
        tr:nth-child(odd) {
            background-color: #fef3c7;
        }
        .debit {
            color: #dc2626;
            font-weight: bold;
        }
        .credit {
            color: #16a34a;
            font-weight: bold;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }
        .badge-success {
            background-color: #15803d;
        }
        .badge-warning {
            background-color: #d97706;
        }
        .badge-danger {
            background-color: #b91c1c;
        }
        .badge-secondary {
            background-color: #6b7280;
        }
        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Riwayat Transaksi</h1>
        
        @if(isset($filter_text) && $filter_text || isset($search) && $search || isset($sort_text))
            <div class="filter-info">
                @if(isset($filter_text) && $filter_text)
                    Filter: {{ $filter_text }}
                @endif
                
                @if(isset($search) && $search)
                    @if(isset($filter_text) && $filter_text) | @endif
                    Pencarian: "{{ $search }}"
                @endif
                
                @if(isset($sort_text))
                    @if((isset($filter_text) && $filter_text) || (isset($search) && $search)) | @endif
                    Urutan: {{ $sort_text }}
                @endif
            </div>
        @endif
        
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Keluar</th>
                    <th>Masuk</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if($mutasi->isEmpty())
                    <tr>
                        <td colspan="6" style="text-align: center;">Tidak ada transaksi yang sesuai dengan filter</td>
                    </tr>
                @else
                    @foreach($mutasi as $item)
                        <tr>
                            <td>{{ $item->user->name ?? 'Unknown' }}</td>
                            <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td>{{ $item->description }}</td>
                            <td class="debit">
                                {{ $item->debit > 0 ? 'Rp ' . number_format($item->debit, 0, ',', '.') : '-' }}
                            </td>
                            <td class="credit">
                                {{ $item->credit > 0 ? 'Rp ' . number_format($item->credit, 0, ',', '.') : '-' }}
                            </td>
                            <td>
                                @if($item->status === 'done')
                                    <span class="badge badge-success">Selesai</span>
                                @elseif($item->status === 'process')
                                    <span class="badge badge-warning">Diproses</span>
                                @elseif($item->status === 'rejected')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-secondary">Tidak diketahui</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        
        <div class="footer">
            Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}
        </div>
    </div>
</body>
</html>