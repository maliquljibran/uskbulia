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

        /* Filter Section Styling */
        .filter-section {
            background-color: var(--panel-bg);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--accent);
        }

        .filter-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-filter {
            padding: 8px 16px;
            border-radius: 6px;
            background-color: #fff;
            border: 1px solid var(--accent);
            color: var(--primary);
            font-weight: 500;
            margin-right: 5px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-filter:hover, .btn-filter.active {
            background-color: var(--secondary);
            color: white;
            border-color: var(--secondary);
        }

        .search-input {
            border-radius: 6px;
            border: 1px solid var(--accent);
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .search-input:focus {
            box-shadow: 0 0 0 2px rgba(255, 140, 56, 0.25);
            border-color: var(--secondary);
            outline: none;
        }

        .btn-search {
            padding: 10px 20px;
            background: var(--secondary);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-search:hover {
            background: #e67e22;
        }

        .btn-reset {
            padding: 10px 20px;
            background-color: #e5e7eb;
            color: var(--text-color);
            border: none;
            border-radius: 6px;
            font-weight: 500;
            margin-left: 5px;
        }

        .btn-reset:hover {
            background-color: #d1d5db;
        }

        /* Sort Controls Styling */
        .sort-controls {
            display: flex;
            margin-top: 15px;
            align-items: center;
            border-top: 1px solid var(--accent);
            padding-top: 15px;
        }

        .sort-label {
            font-weight: 500;
            color: var(--primary);
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .sort-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-sort {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            border: 1px solid var(--accent);
            background-color: #fff;
            color: var(--primary);
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-sort:hover, .btn-sort.active {
            background-color: var(--secondary);
            color: white;
            border-color: var(--secondary);
        }

        /* Filter row styling */
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .table-responsive {
                font-size: 0.9rem;
            }
            
            .btn-filter, .btn-sort {
                font-size: 0.8rem;
                padding: 6px 10px;
            }
            
            .filter-section {
                padding: 15px;
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

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-title">
                <i class="fas fa-filter"></i> Filter Transaksi
            </div>
            
            <form action="{{ route('siswa.mutasi') }}" method="GET">
                <div class="filter-row">
                    <div class="mb-3">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('siswa.mutasi', ['sort' => request('sort')]) }}" class="btn-filter {{ !request('filter') || request('filter') == 'all' ? 'active' : '' }}">
                                <i class="fas fa-list-ul"></i> Semua
                            </a>
                            <a href="{{ route('siswa.mutasi', ['filter' => 'topup', 'search' => request('search'), 'sort' => request('sort')]) }}" class="btn-filter {{ request('filter') == 'topup' ? 'active' : '' }}">
                                <i class="fas fa-arrow-up"></i> Top-up
                            </a>
                            <a href="{{ route('siswa.mutasi', ['filter' => 'withdraw', 'search' => request('search'), 'sort' => request('sort')]) }}" class="btn-filter {{ request('filter') == 'withdraw' ? 'active' : '' }}">
                                <i class="fas fa-arrow-down"></i> Tarik Tunai
                            </a>
                            <a href="{{ route('siswa.mutasi', ['filter' => 'transfer', 'search' => request('search'), 'sort' => request('sort')]) }}" class="btn-filter {{ request('filter') == 'transfer' ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt"></i> Transfer
                            </a>
                            <a href="{{ route('siswa.mutasi', ['filter' => 'rejected', 'search' => request('search'), 'sort' => request('sort')]) }}" class="btn-filter {{ request('filter') == 'rejected' ? 'active' : '' }}">
                                <i class="fas fa-times-circle"></i> Ditolak
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-8">
                        <!-- Sort Controls -->
                        <div class="sort-controls">
                            <div class="sort-label">
                                <i class="fas fa-sort me-1"></i> Urutan:
                            </div>
                            <div class="sort-buttons">
                                <a href="{{ route('siswa.mutasi', ['filter' => request('filter'), 'search' => request('search'), 'sort' => 'newest']) }}" class="btn-sort {{ !request('sort') || request('sort') == 'newest' ? 'active' : '' }}">
                                    <i class="fas fa-calendar-alt me-1"></i> Terbaru
                                </a>
                                <a href="{{ route('siswa.mutasi', ['filter' => request('filter'), 'search' => request('search'), 'sort' => 'oldest']) }}" class="btn-sort {{ request('sort') == 'oldest' ? 'active' : '' }}">
                                    <i class="fas fa-history me-1"></i> Terlama
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control search-input" placeholder="Cari deskripsi..." value="{{ request('search') }}">
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                            <button class="btn btn-search" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search') || request('filter') || request('sort') && request('sort') != 'newest')
                                <a href="{{ route('siswa.mutasi') }}" class="btn btn-reset">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if($mutasi->isEmpty())
            <div class="alert alert-no-transaction">
                <i class="fas fa-info-circle me-2"></i>
                Tidak ada transaksi yang sesuai dengan filter.
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
                                <td>
                                    <a href="{{ route('download.transaction.pdf', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-file-pdf me-1"></i> PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $mutasi->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif
        <div class="d-flex justify-content-start gap-3 mt-4">
            <a href="{{ route('export.pdf', ['filter' => request('filter'), 'search' => request('search'), 'sort' => request('sort')]) }}" class="btn btn-back">
                <i class="fas fa-file-pdf me-1"></i> Download PDF
            </a>
            <a href="{{ route('home') }}" class="btn btn-back">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>

</html>