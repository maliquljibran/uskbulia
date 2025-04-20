<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>64 BANK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');

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
            padding: 0;
        }

        .navbar {
            background: var(--primary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--secondary);
            font-size: 1.8rem;
        }

        .container-main {
            max-width: 1500px;
            margin: 40px auto;
            padding: 20px;
            display: flex;
            gap: 30px;
        }

        .sidebar {
            width: 250px;
            background: var(--panel-bg);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
        }

        .sidebar-nav li {
            margin-bottom: 10px;
        }

        .sidebar-nav a {
            color: var(--text-color);
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 10px;
            transition: background 0.3s;
        }

        .sidebar-nav a:hover {
            background: var(--accent);
            color: #fff;
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .stats-grid {
            display: flex;
            gap: 20px;
            justify-content: space-between;
        }

        .stat-panel {
            background: var(--secondary);
            color: #fff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            flex: 1;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .stat-title {
            font-size: 1.1rem;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .panel {
            background: var(--panel-bg);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .panel:hover {
            transform: translateY(-5px);
        }

        .panel-header {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 15px;
        }

        .list-group-item {
            background: transparent;
            border: none;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 12px;
            font-weight: 500;
        }

        .badge.bg-success {
            background: var(--success) !important;
            color: #fff;
        }

        .badge.bg-danger {
            background: var(--danger) !important;
            color: #fff;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
        }

        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .btn-primary {
            background: var(--secondary);
            border: none;
        }

        .btn-primary:hover {
            background: #e67e22;
        }

        .btn-danger {
            background: var(--danger);
            border: none;
        }

        .btn-danger:hover {
            background: #e63939;
        }

        .btn-warning {
            background: var(--warning);
            border: none;
            color: var(--text-color);
        }

        .btn-warning:hover {
            background: #ff9f66;
        }

        .modal-content {
            border-radius: 15px;
            background: var(--panel-bg);
        }

        .modal-header {
            border-bottom: 2px solid var(--accent);
        }

        .modal-footer {
            border-top: 2px solid var(--accent);
        }

        @media (max-width: 768px) {
            .container-main {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                margin-bottom: 20px;
            }

            .stats-grid {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">64 BANK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto"></ul>
                <div class="d-flex align-items-center">
                    <span class="text-dark me-3">{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-main">
        <aside class="sidebar">
            <ul class="sidebar-nav">
                <li><a href="#">Dashboard</a></li>
            </ul>
        </aside>

        <div class="content">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Admin Dashboard -->
            @if(Auth::user()->role == 'admin')
            <h3 class="section-title">Admin Dashboard</h3>
            <div class="stats-grid">
                <div class="stat-panel">
                    <div class="stat-title">Total Pengguna</div>
                    <div class="stat-value">{{ $users->count() }}</div>
                </div>
                <div class="stat-panel">
                    <div class="stat-title">Siswa</div>
                    <div class="stat-value">{{ $users->where('role', 'siswa')->count() }}</div>
                </div>
                <div class="stat-panel">
                    <div class="stat-title">Total Transaksi</div>
                    <div class="stat-value">{{ $mutasi->count() }}</div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-header">Transaksi Terakhir</div>
                @if($mutasi->isEmpty())
                    <p class="text-muted">Tidak Ada Transaksi.</p>
                @else
                    <div class="list-group">
                        @foreach($mutasi->take(5) as $mutation)
                            <div class="list-group-item">
                                <div>{{ $mutation->description }}</div>
                                <small class="text-muted">{{ $mutation->created_at->format('d M Y, H:i') }}</small>
                                <span class="{{ $mutation->credit > 0 ? 'badge bg-success' : 'badge bg-danger' }}">
                                    {{ $mutation->credit > 0 ? '+' : '-' }} Rp {{ number_format($mutation->credit > 0 ? $mutation->credit : $mutation->debit, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('mutasi.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                    </div>
                @endif
            </div>
            <div class="panel">
                <div class="panel-header">Manajemen Pengguna</div>
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus"></i> Tambah Pengguna
                </button>
                @if($users->isEmpty())
                    <p class="text-muted">Tidak Ada Pengguna.</p>
                @else
                    <div class="list-group">
                        @foreach($users as $user)
                            <div class="list-group-item">
                                <div>{{ $user->name }} ({{ ucfirst($user->role) }})</div>
                                <small class="text-muted">{{ $user->email }}</small>
                                <div>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('delete-user', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @endif

            <!-- Siswa Dashboard -->
            @if(Auth::user()->role == 'siswa')
            <h3 class="section-title">Siswa Dashboard</h3>
            <div class="stats-grid">
                <div class="stat-panel">
                    <div class="stat-title">Saldo</div>
                    <div class="stat-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-header">Aksi</div>
                <div class="row">
                    <div class="col-md-4">
                        <form action="{{ route('topUp') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Top-up</label>
                                <input type="number" class="form-control" name="credit" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Top-up</button>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('withdraw') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tarik Tunai</label>
                                <input type="number" class="form-control" name="credit" required>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Tarik Tunai</button>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('transfer') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Transfer</label>
                                <input type="number" class="form-control" name="recepient_id" placeholder="ID Penerima" required>
                                <input type="number" class="form-control mt-2" name="amount" placeholder="Jumlah" required>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">Transfer</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-header">Riwayat Transaksi</div>
                @if($mutasi->isEmpty())
                    <p class="text-muted">Tidak ada transaksi.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Tarik Tunai</th>
                                    <th>Top-up</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mutasi->take(5) as $item)
                                    <tr>
                                        <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->debit > 0 ? 'Rp ' . number_format($item->debit, 0, ',', '.') : '-' }}</td>
                                        <td>{{ $item->credit > 0 ? 'Rp ' . number_format($item->credit, 0, ',', '.') : '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $item->status == 'done' ? 'success' : ($item->status == 'process' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            @endif

            <!-- Bank Dashboard -->
            @if(Auth::user()->role == 'bank')
            <h3 class="section-title">Bank Dashboard</h3>
            <div class="panel">
                <div class="panel-header">Manajemen Pengguna</div>
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus"></i> Tambah Siswa
                </button>
                @if($users->where('role', 'siswa')->isEmpty())
                    <p class="text-muted">Belum ada user.</p>
                @else
                    <div class="list-group">
                        @foreach($users->where('role', 'siswa') as $user)
                            <div class="list-group-item">
                                <div>{{ $user->name }} ({{ ucfirst($user->role) }})</div>
                                <small class="text-muted">{{ $user->email }}</small>
                                <div>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('delete-user', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="panel">
                <div class="panel-header">Transaksi Siswa</div>
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('bank.topup') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Top-up ke Siswa</label>
                                <input type="number" class="form-control" name="siswa_id" placeholder="ID Siswa" required>
                                <input type="number" class="form-control mt-2" name="amount" placeholder="Nominal" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Top-up</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('bank.withdraw') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Withdraw untuk Siswa</label>
                                <input type="number" class="form-control" name="siswa_id" placeholder="ID Siswa" required>
                                <input type="number" class="form-control mt-2" name="amount" placeholder="Nominal" required>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Withdraw</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-header">Permintaan</div>
                @if(empty($request_payment) || count($request_payment) == 0)
                    <p class="text-muted">No pending requests</p>
                @else
                    <div class="list-group">
                        @foreach($request_payment as $dompet)
                            <div class="list-group-item">
                                <div>{{ $dompet->description }}</div>
                                <small class="text-muted">{{ $dompet->created_at->format('d M Y, H:i') }}</small>
                                <div class="fw-bold">Rp {{ number_format($dompet->credit - $dompet->debit, 0, ',', '.') }}</div>
                                <div class="mt-2">
                                    <form action="{{ route('approve', $dompet->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Terima</button>
                                    </form>
                                    <form action="{{ route('reject', $dompet->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @endif

            <!-- Bagian Mutasi -->
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <span>Mutasi</span>
        <div class="dropdown">
            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="?filter=all">Semua</a></li>
                <li><a class="dropdown-item" href="?filter=topup">Top-up</a></li>
                <li><a class="dropdown-item" href="?filter=withdraw">Tarik Tunai</a></li>
                <li><a class="dropdown-item" href="?filter=transfer">Transfer</a></li>
            </ul>
        </div>
    </div>
    @if($mutasi->isEmpty())
        <p class="text-muted">Tidak ada transaksi ditemukan.</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mutasi->take(5) as $item)
                        <tr>
                            <td>{{ $item->user->name ?? 'Tidak Diketahui' }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>{{ $item->description }}</td>
                            <td class="{{ $item->credit > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $item->credit > 0 ? '+' : '-' }} Rp {{ number_format($item->credit > 0 ? $item->credit : $item->debit, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center mt-3">
            @if (Auth::user()->role == 'siswa')
                <a href="{{ route('siswa.mutasi') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
            @else
                <a href="{{ route('mutasi.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
            @endif
        </div>
    @endif
</div>
        </div>

        
    </div>

    

    <!-- Modals for Admin -->
    @if(Auth::user()->role == 'admin')
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('add-user') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="siswa">Siswa</option>
                                <option value="admin">Admin</option>
                                <option value="bank">Bank</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @foreach($users as $user)
    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('update-user', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password (optional)</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach
    @endif

    <!-- Modals for Bank -->
    @if(Auth::user()->role == 'bank')
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('user.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <input type="hidden" name="role" value="siswa">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @foreach($users->where('role', 'siswa') as $user)
    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('update-user', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password (kosongkan jika tidak diganti)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <input type="hidden" name="role" value="siswa">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>