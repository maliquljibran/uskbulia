<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;    
        }

        body {
            background: linear-gradient(135deg, #fff3e0, #fef7e8);
            color: #2f3e46;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #f97316; /* Primary orange */
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
            text-align: center;
            border-bottom: 3px solid #ea580c; /* Darker orange */
            padding-bottom: 0.5rem;
            animation: fadeIn 0.5s ease-out;
        }

        .table-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.07);
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 0.5s ease-out;
        }

        .table-container:hover {
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        thead {
            background: linear-gradient(to right, #f97316, #ea580c); /* Orange gradient */
            color: #ffffff;
        }

        th {
            padding: 15px;
            font-weight: 600;
            font-size: 0.95rem;
            text-align: left;
            border: none;
        }

        tbody tr {
            transition: background 0.3s, transform 0.2s;
        }

        tbody tr:nth-child(odd) {
            background-color: #fff7ed; /* Light orange background */
        }

        tbody tr:nth-child(even) {
            background-color: #fef3c7; /* Slightly darker light orange */
        }

        tbody tr:hover {
            background-color: #fed7aa; /* Medium orange on hover */
            transform: translateY(-1px);
        }

        td {
            padding: 15px;
            font-size: 0.9rem;
            font-weight: 400;
            color: #2d3748;
            border: none;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Status & Value Colors */
        .debit-value {
            color: #dc2626; /* Red for debit, kept for contrast */
            font-weight: 500;
        }

        .credit-value {
            color: #16a34a; /* Green for credit, kept for contrast */
            font-weight: 500;
        }

        .status-done {
            color: #15803d; /* Dark green, kept for contrast */
            font-weight: 500;
        }

        .status-process {
            color: #d97706; /* Orange-yellow for process */
            font-weight: 500;
        }

        .status-rejected {
            color: #b91c1c; /* Dark red, kept for contrast */
            font-weight: 500;
        }

        .status-unknown {
            color: #6b7280; /* Neutral gray */
            font-weight: 500;
        }

        /* Print Styles */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .table-container {
                box-shadow: none;
                margin: 0;
                max-width: none;
            }
            .table-container:hover {
                transform: none;
                box-shadow: none;
            }
            h1 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
            th, td {
                padding: 8px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <h1>Riwayat Transaksi</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if($mutasi->isEmpty())
                    <tr>
                        <td colspan="6" style="text-align: center; color: #6b7280; font-weight: 400;">
                            Tidak ada transaksi.
                        </td>
                    </tr>
                @else
                    @foreach($mutasi as $item)
                        <tr>
                            <td>{{ $item->user->name ?? 'Unknown' }}</td>
                            <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td>{{ $item->description }}</td>
                            <td class="debit-value">
                                {{ $item->debit > 0 ? 'Rp ' . number_format($item->debit, 0, ',', '.') : '-' }}
                            </td>
                            <td class="credit-value">
                                {{ $item->credit > 0 ? 'Rp ' . number_format($item->credit, 0, ',', '.') : '-' }}
                            </td>
                            <td class="{{ 'status-' . ($item->status ?? 'unknown') }}">
                                @if($item->status === 'done')
                                    Selesai
                                @elseif($item->status === 'process')
                                    Diproses
                                @elseif($item->status === 'rejected')
                                    Ditolak
                                @else
                                    Tidak diketahui
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>