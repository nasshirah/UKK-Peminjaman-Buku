<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: white;
            border-right: 1px solid #e9ecef;
            padding: 20px;
        }

        .brand-logo {
            color: #198754;
            font-weight: 700;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            padding-left: 10px;
        }

        .sidebar a {
            color: #6c757d;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: all 0.3s;
            font-weight: 500;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Style untuk link aktif (tiru admin) */
        .sidebar a.active {
            background: #198754;
            color: white;
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
        }

        .sidebar a:hover:not(.active) {
            background: #f0fdf4;
            color: #198754;
        }

        .logout-link {
            color: #dc3545 !important;
            margin-top: auto;
            position: absolute;
            bottom: 30px;
            width: calc(100% - 40px);
        }

        .main {
            margin-left: 260px;
            padding: 40px;
        }

        /* Topbar simulasi */
        .topbar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="brand-logo">
        <i class="bi bi-graph-up-arrow"></i> E-Perpus
    </div>

    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Dashboard
    </a>
    <a href="{{ route('user.daftarBuku') }}" class="{{ request()->routeIs('user.daftarBuku') ? 'active' : '' }}">
        <i class="bi bi-book"></i> Daftar Buku
    </a>
    <a href="{{ route('user.books') }}" class="{{ request()->routeIs('user.books') ? 'active' : '' }}">
        <i class="bi bi-journal-arrow-up"></i> Peminjaman
    </a>
    <a href="{{ route('user.pinjaman') }}" class="{{ request()->routeIs('user.pinjaman') ? 'active' : '' }}">
        <i class="bi bi-journal-arrow-down"></i> Pengembalian
    </a>
    <a href="{{ route('user.riwayat') }}" class="{{ request()->routeIs('user.riwayat') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Riwayat
    </a>

    <a href="{{ route('logout') }}" class="logout-link">
        <i class="bi bi-box-arrow-left"></i> Logout
    </a>
</div>

<div class="main">
    <div class="topbar">
        <span>User • {{ date('d M Y') }}</span>
    </div>
    @yield('content')
</div>

</body>
</html>