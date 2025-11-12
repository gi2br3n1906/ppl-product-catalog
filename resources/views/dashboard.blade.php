<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Product Catalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            background: linear-gradient(135deg, #01343B 0%, #023840 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            color: #333;
        }
        
        .user-email {
            font-size: 12px;
            color: #666;
        }
        
        .btn-logout {
            padding: 8px 20px;
            background: linear-gradient(135deg, #01343B 0%, #023840 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
        }
        
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .welcome-card h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .welcome-card p {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #ACEB02 0%, #8BC900 100%);
            color: #01343B;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(172, 235, 2, 0.3);
        }
        
        .stat-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            opacity: 0.9;
        }
        
        .stat-card .stat-value {
            font-size: 36px;
            font-weight: bold;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">Product Catalog</div>
        <div class="navbar-user">
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-email">{{ auth()->user()->email }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="welcome-card">
            <h1>Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p>Anda berhasil login ke Product Catalog Dashboard</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Produk</h3>
                    <div class="stat-value">0</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #01343B 0%, #023840 100%); color: white;">
                    <h3>Kategori</h3>
                    <div class="stat-value">0</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #7BD404 0%, #ACEB02 100%); color: #01343B;">
                    <h3>User Terdaftar</h3>
                    <div class="stat-value">{{ \App\Models\User::count() }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
