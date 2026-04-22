<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Admin Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; color: #334155; }
        
        .sidebar { 
            width: 260px; height: 100vh; position: fixed; background: white; 
            border-right: 1px solid #e2e8f0; padding-top: 20px; z-index: 100; 
        }

        .sidebar-header { padding: 0 25px 20px; display: flex; align-items: center; gap: 12px; color: #10b981; }

        .sidebar a { 
            color: #64748b; text-decoration: none; display: flex; align-items: center; 
            gap: 12px; padding: 12px 25px; margin: 4px 15px; border-radius: 10px; font-weight: 500; transition: all 0.2s; 
        }

        .sidebar a:hover { background: #f0fdf4; color: #10b981; }
        .sidebar a.active { background: linear-gradient(135deg, #10b981, #059669); color: white; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); }

        .main-content { margin-left: 260px; padding: 30px; }

        /* Style Tabel Custom */
        .table thead th { 
            background-color: #f8fafc; color: #64748b; font-size: 0.75rem; 
            text-transform: uppercase; letter-spacing: 0.05em; border: none; padding: 15px;
        }
        .table tbody td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }

        .logout-link { position: absolute; bottom: 20px; width: calc(100% - 30px); }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <i data-lucide="library"></i>
            <h5 class="fw-bold mb-0">E-Perpus</h5>
        </div>
        <div class="mt-3">
            <a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}"><i data-lucide="layout-dashboard"></i> Dashboard</a>
            <a href="/books" class="{{ Request::is('books*') ? 'active' : '' }}"><i data-lucide="book-open"></i> Data Buku</a>
            <a href="/members" class="{{ Request::is('members*') ? 'active' : '' }}"><i data-lucide="users"></i> Data Anggota</a>
            <a href="/transactions" class="{{ Request::is('transactions*') ? 'active' : '' }}"><i data-lucide="arrow-left-right"></i> Transaksi</a>
            <a href="{{ route('laporan.index') }}" class="{{ Request::is('laporan*') ? 'active' : '' }}"><i data-lucide="file-bar-chart"></i> Laporan</a>
            <div class="logout-link">
                <hr class="mx-3 my-3 text-muted">
                <a href="{{ route('logout') }}" class="text-danger"><i data-lucide="log-out"></i> Logout</a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0">@yield('page_title')</h4>
            <div class="text-muted small fw-medium">Admin &bull; {{ date('d M Y') }}</div>
        </div>
        @yield('content')
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>