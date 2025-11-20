<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - CampusMarket</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Hide scrollbar untuk semua browser */
        html, body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            display: none;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        .navbar {
            background: #01343B;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #ACEB02;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-size: 20px;
            font-weight: 600;
            color: white;
            text-decoration: none;
        }
        
        .navbar-right {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .btn-login {
            background: #ACEB02;
            border: 2px solid #ACEB02;
            color: #01343B;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-login:hover {
            background: #9dd302;
            border-color: #9dd302;
        }
        
        .btn-register {
            background: #ACEB02;
            border: 2px solid #ACEB02;
            color: #01343B;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-register:hover {
            background: #9dd302;
            border-color: #9dd302;
        }
        
        .user-info {
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 15px;
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
        
        .construction-box {
            background: white;
            padding: 80px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .construction-icon {
            font-size: 72px;
            margin-bottom: 20px;
        }
        
        .construction-text {
            color: #01343B;
            font-size: 24px;
            font-weight: 600;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }
            
            .navbar-brand {
                font-size: 16px;
            }
            
            .navbar-right {
                gap: 10px;
            }
            
            .btn-login, .btn-register, .btn-logout {
                padding: 6px 15px;
                font-size: 14px;
            }
            
            .container {
                padding: 40px 15px;
            }
            
            .construction-box {
                padding: 60px 20px;
            }
            
            .construction-icon {
                font-size: 56px;
            }
            
            .construction-text {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('catalog') }}" class="navbar-brand">CampusMarket</a>
        
        <div class="navbar-right">
            @auth
                <div class="user-info">
                    <span>Halo, {{ Auth::user()->name }}!</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-login">Login</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        <div class="construction-box">
            <div class="construction-icon">🚧</div>
            <div class="construction-text">Halaman sedang dalam konstruksi</div>
        </div>
    </div>
</body>
</html>
