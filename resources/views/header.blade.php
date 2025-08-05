        <header class="top-header">
            <!-- زر إظهار/إخفاء الشريط الجانبي -->


            <div class="header-left">
                <h1 id="pageTitle">الإحصائيات</h1>
            </div>
            {{-- <button id="toggleSidebarBtn" class="sidebar-toggle-btn">
    <i class="fas fa-angle-double-right"></i>
</button> --}}
            <div class="header-right">
                <div class="user-info">
                    <span>مرحباً، المدير</span>
                    <i class="fas fa-user-circle"></i>
                </div>
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout-btn" onclick="return  confirm('هل تريد تسجيل الخروج؟')">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </header>
