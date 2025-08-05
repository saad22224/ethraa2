    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-tachometer-alt"></i>
                <span>لوحة التحكم</span>
            </div>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item active" data-page="dashboard">
                <a href="#" class="menu-link">
                    <i class="fas fa-home"></i>
                    <span>الإحصائيات</span>
                </a>
            </li>
            <li class="" data-page="users">
                <a href="{{ route('users') }}" class="menu-link">
                    <i class="fas fa-users"></i>
                    <span>المستخدمين</span>
                </a>
            </li>
            <li class="menu-item" data-page="transfers">
                <a href="#" class="menu-link">
                    <i class="fas fa-exchange-alt"></i>
                    <span>التحويلات</span>
                </a>
            </li>
            <li class="" data-page="offices">
                <a href="{{ route('offices') }}" class="menu-link">
                    <i class="fas fa-building"></i>
                    <span>مكاتب التحويل</span>
                </a>
            </li>
        </ul>
    </nav>