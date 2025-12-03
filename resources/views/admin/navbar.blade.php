<nav class="admin-navbar">
    <div class="admin-navbar-container">
        <span class="admin-navbar-brand">CampusMarket</span>
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.seller-registrations.index') }}" class="admin-nav-link{{ request()->routeIs('admin.seller-registrations.index') ? ' active' : '' }}">Verifikasi Seller</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left:auto;">
            @csrf
            <button type="submit" class="admin-btn-logout">Logout</button>
        </form>
    </div>
</nav>

<style>
.admin-navbar {
    background: #01343B;
    padding: 18px 40px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-bottom: 3px solid #ACEB02;
}
.admin-navbar-container {
    display: flex;
    align-items: center;
    gap: 28px;
}
.admin-navbar-brand {
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    margin-right: 32px;
    letter-spacing: 1px;
}
.admin-nav-link {
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    padding: 6px 0;
    transition: font-weight 0.2s;
}
.admin-nav-link.active {
    font-weight: 900;
}
.admin-btn-logout {
    background: #ACEB02;
    color: #01343B;
    border: 2px solid #ACEB02;
    padding: 8px 20px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    font-size: 15px;
    margin-left: 24px;
    transition: background 0.2s, color 0.2s;
}
.admin-btn-logout:hover {
    background: #9dd302;
    border-color: #9dd302;
    color: #01343B;
}
</style>
