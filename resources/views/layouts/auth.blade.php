<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@yield('title', 'Login')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            height: 100vh;
            /* Background ganti ke Teal-Grey yang sangat soft */
            background: radial-gradient(circle at top right, #f0fdf4 0%, #dcfce7 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 24px; /* Sedikit lebih melengkung agar modern */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.04), 0 10px 10px -5px rgba(0, 0, 0, 0.01);
            background: #ffffff;
        }

        .card-body {
            padding: 3.5rem 2.5rem;
        }

        .input-group-text {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
            border-radius: 12px 0 0 12px !important;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        /* Focus state ganti ke warna Emerald */
        .form-control:focus {
            background-color: #ffffff;
            border-color: #10b981; 
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); 
            z-index: 3;
        }

        .btn-primary {
            border-radius: 12px;
            padding: 0.8rem;
            font-weight: 600;
            /* Button menggunakan gradien Emerald ke Teal */
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        /* Link ganti ke Emerald */
        a {
            color: #059669;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        a:hover {
            color: #064e3b;
            text-decoration: underline;
        }

        /* Tambahan styling untuk icon di login.blade agar sinkron */
        .icon-box {
            background: linear-gradient(135deg, #10b981, #059669) !important;
            box-shadow: 0 8px 16px rgba(16, 185, 129, 0.2) !important;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="card">
            <div class="card-body">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
      lucide.createIcons();
    </script>
</body>
</html>