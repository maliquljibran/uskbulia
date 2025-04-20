<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2d1b4e;
            --secondary: #ff8c38;
            --accent: #ffb07f;
            --background: #f8f1e9;
            --panel-bg: #fff9ef;
            --text-color: #2d1b4e;
            --muted-text: #706b62;
            --success: #00cc66;
            --danger: #ff4d4d;
            --warning: #ffb07f;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--background);
            color: var(--text-color);
            min-height: 100vh;
            margin: 0;
            padding: 20px 0;
        }

        .container {
            background: var(--panel-bg);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 0 auto;
        }

        h4 {
            color: var(--primary);
            font-weight: 700;
            border-bottom: 3px solid var(--secondary);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .table thead {
            background: var(--secondary);
            color: #fff;
        }

        .table thead th {
            font-weight: 500;
        }

        .debit-value {
            color: var(--danger);
            font-weight: 500;
        }

        .credit-value {
            color: var(--success);
            font-weight: 500;
        }

        .badge.bg-success {
            background: var(--success) !important;
        }

        .badge.bg-warning {
            background: var(--warning) !important;
            color: var(--text-color);
        }

        .badge.bg-danger {
            background: var(--danger) !important;
        }

        .btn-back {
            background: var(--secondary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .btn-back:hover {
            background: #e67e22;
            color: #fff;
        }

        .alert-no-transaction {
            background: var(--panel-bg);
            color: var(--muted-text);
            border: 1px solid var(--accent);
            border-radius: 10px;
        }

        .page-link {
            color: var(--secondary);
            border-radius: 8px;
            margin: 0 2px;
        }

        .page-link:hover {
            background: var(--accent);
            color: #fff;
        }

        .page-item.active .page-link {
            background: var(--secondary);
            border-color: var(--secondary);
            color: #fff;
        }

        .pagination {
            justify-content: center;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .table-responsive {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h4>
            <i class="fas fa-history me-2"></i>
            Riwayat Transaksi Saya
        </h4>

        @if($mutasi->isEmpty())
            <div class="alert alert-no-transaction">
                <i class="fas fa-info-circle me-2"></i>
                Tidak ada transaksi.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><i class="fas fa-calendar-alt me-2"></i>Tanggal</th>
                            <th><i class="fas fa-file-alt me-2"></i>Deskripsi</th>
                            <th><i class="fas fa-arrow-down me-2"></i>Keluar</th>
                            <th><i class="fas fa-arrow-up me-2"></i>Masuk</th>
                            <th><i class="fas fa-check-circle me-2"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mutasi as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                                <td>{{ $item->description }}</td>
                                <td class="debit-value">
                                    {{ $item->debit > 0 ? 'Rp ' . number_format($item->debit, 0, ',', '.') : '-' }}
                                </td>
                                <td class="credit-value">
                                    {{ $item->credit > 0 ? 'Rp ' . number_format($item->credit, 0, ',', '.') : '-' }}
                                </td>
                                <td>
                                    @if($item->status === 'done')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($item->status === 'process')
                                        <span class="badge bg-warning text-dark">Diproses</span>
                                    @elseif($item->status === 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak diketahui</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $mutasi->links('pagination::bootstrap-5') }}
            </div>
        @endif
        <div class="d-flex justify-content-start gap-3 mt-4">
            <a href="{{ route('export.pdf') }}" class="btn btn-back">
                <i class="fas fa-file-pdf me-1"></i> Download PDF
            </a>
            <a href="{{ route('home') }}" class="btn btn-back">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>

</html>