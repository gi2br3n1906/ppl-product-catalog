<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Seller</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: white;
            min-height: 100vh;
        }
        
        .navbar {
            background: #01343B;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #ACEB02;
        }
        
        .navbar-brand {
            font-size: 20px;
            font-weight: 600;
            color: white;
        }
        
        .btn-logout {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-logout:hover {
            background: white;
            color: #01343B;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
            text-align: center;
        }
        
        .welcome-message {
            margin-bottom: 20px;
        }
        
        .welcome-message h1 {
            color: #01343B;
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .welcome-message p {
            color: #666;
            font-size: 16px;
        }
        
        .empty-state {
            margin-top: 60px;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px dashed #e1e1e1;
        }
        
        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: #ACEB02;
        }
        
        .empty-state-text {
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">CampusMarket - Seller Panel</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </nav>

    <div class="container">
        <div class="welcome-message">
            <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p>Dashboard seller Anda</p>
        </div>

        <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <div class="empty-state-text">
                Dashboard seller sedang dalam pengembangan.<br>
                Fitur manajemen produk akan segera hadir.
            </div>
        </div>
    </div>
</body>
</html>
