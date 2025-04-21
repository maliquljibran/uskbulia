<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #fff3e0, #fef7e8);
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
            padding: 2rem;
        }

        .container {
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            width: 100%;
            max-width: 1200px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 0.5s ease-out;
        }

        .container:hover {
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h4 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #f97316;
            letter-spacing: 0.5px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 3px solid #ea580c;
            padding-bottom: 10px;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            background-color: #fff;
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(to right, #f97316, #ea580c);
            color: #fff;
        }

        .table thead th {
            padding: 15px;
            font-weight: 500;
            font-size: 0.95rem;
            border: none;
            text-align: left;
        }

        .table tbody tr {
            transition: background 0.3s, transform 0.2s;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #fff7ed;
        }

        .table tbody tr:nth-child(even) {
            background-color: #fef3c7;
        }

        .table tbody tr:hover {
            background-color: #fed7aa;
            transform: translateY(-1px);
        }

        .table tbody td {
            padding: 15px;
            font-size: 0.9rem;
            font-weight: 400;
            color: #333;
            border: none;
            border-bottom: 1px solid #e5e7eb;
        }

        .debit-value {
            color: #dc2626;
            font-weight: 500;
        }

        .credit-value {
            color: #16a34a;
            font-weight: 500;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .btn-back {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            background: linear-gradient(to right, #f97316, #ea580c);
            color: #fff;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.2);
            margin-right: 10px;
        }

        .btn-back:hover {
            background: linear-gradient(to right, #ea580c, #c2410c);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        .btn-back:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.2);
        }

        .alert-no-transaction {
            background: #fed7aa;
            color: #c2410c;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            font-size: 0.9rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .page-link {
            border-radius: 6px;
            margin: 0 3px;
            font-size: 0.9rem;
            color: #f97316;
            transition: background 0.3s, color 0.3s;
        }

        .page-link:hover {
            background: #fed7aa;
            color: #c2410c;
        }

        .page-item.active .page-link {
            background: #f97316;
            border-color: #f97316;
            color: #fff;
        }

        /* Override Bootstrap badge colors */
        .bg-success {
            background-color: #15803d !important;
        }

        .bg-warning {
            background-color: #d97706 !important;
            color: #fff !important;
        }

        .bg-danger {
            background-color: #b91c1c !important;
        }

        .bg-secondary {
            background-color: #6b7280 !important;
        }

        /* Filter Section Styling */
        .filter-section {
            background-color: #fff7ed;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #fed7aa;
        }

        .filter-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ea580c;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-filter {
            padding: 8px 16px;
            border-radius: 6px;
            background-color: #ffedd5;
            border: 1px solid #fed7aa;
            color: #ea580c;
            font-weight: 500;
            margin-right: 5px;
            transition: all 0.2s;
        }

        .btn-filter:hover, .btn-filter.active {
            background-color: #f97316;
            color: white;
            border-color: #f97316;
        }

        .search-input {
            border-radius: 6px;
            border: 1px solid #fed7aa;
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .search-input:focus {
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.25);
            border-color: #f97316;
        }

        .btn-search {
            padding: 10px 20px;
            background: linear-gradient(to right, #f97316, #ea580c);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-search:hover {
            background: linear-gradient(to right, #ea580c, #c2410c);
        }

        .btn-reset {
            padding: 10px 20px;
            background-color: #e5e7eb;
            color: #4b5563;
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
            border-top: 1px solid #fed7aa;
            padding-top: 15px;
        }

        .sort-label {
            font-weight: 500;
            color: #ea580c;
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
            border: 1px solid #fed7aa;
            background-color: #ffedd5;
            color: #ea580c;
            transition: all 0.2s;
        }

        .btn-sort:hover, .btn-sort.active {
            background-color: #f97316;
            color: white;
            border-color: #f97316;
        }

        /* Second row in filter section */
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h4>
            <i class="fas fa-history"></i>
            Semua Riwayat Transaksi
        </h4>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-title">
                <i class="fas fa-filter"></i> Filter Transaksi
            </div>
            
            <form action="{{ route('wallet.all') }}" method="GET">
                <div class="filter-row">
                    <div class="mb-3">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('wallet.all', ['sort' => request('sort')]) }}" class="btn-filter {{ !request('filter') || request('filter') == 'all' ? 'active' : '' }}">
                                <i class="fas fa-list-ul"></i> Semua
                            </a>
                            <a href="{{ route('wallet.all', ['filter' => 'topup', 'search' => request('search'), 'sort' => request('sort')]) }}" class="btn-filter {{ request('filter') == 'topup' ? 'active' : '' }}">
                                <i class="fas fa-arrow-up"></i> Top-up
                            </a>
                            <a href="{{ route('wallet.all', ['filter' => 'withdraw', 'search' => request('search'), 'sort' => request('sort')]) }}" class="btn-filter {{ request('filter') == 'withdraw' ? 'active' : '' }}">
                                <i class="fas fa-arrow-down"></i> Tarik Tunai
                            </a>
                            <a href="{{ route('wallet.all', ['filter' => 'transfer', 'search' => request('search'), 'sort' => request('sort')]) }}" class="btn-filter {{ request('filter') == 'transfer' ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt"></i> Transfer
                            </a>
                            <a href="{{ route('wallet.all', ['filter' => 'rejected', 'search' => request('search'), 'sort' => request('sort')]) }}" class="btn-filter {{ request('filter') == 'rejected' ? 'active' : '' }}">
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
                                <a href="{{ route('wallet.all', ['filter' => request('filter'), 'search' => request('search'), 'sort' => 'newest']) }}" class="btn-sort {{ !request('sort') || request('sort') == 'newest' ? 'active' : '' }}">
                                    <i class="fas fa-calendar-alt me-1"></i> Terbaru
                                </a>
                                <a href="{{ route('wallet.all', ['filter' => request('filter'), 'search' => request('search'), 'sort' => 'oldest']) }}" class="btn-sort {{ request('sort') == 'oldest' ? 'active' : '' }}">
                                    <i class="fas fa-history me-1"></i> Terlama
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control search-input" placeholder="Cari user atau deskripsi..." value="{{ request('search') }}">
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                            <button class="btn btn-search" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search') || request('filter') || request('sort') && request('sort') != 'newest')
                                <a href="{{ route('wallet.all') }}" class="btn btn-reset">
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
                <i class="fas fa-info-circle"></i>
                Tidak ada transaksi yang sesuai dengan filter.
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user me-2"></i>User</th>
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
                                <td>{{ $item->user->name ?? 'Unknown' }}</td>
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
        <div class="d-flex justify-content-start mt-4">
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