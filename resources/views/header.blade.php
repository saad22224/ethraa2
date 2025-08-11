        <header class="top-header">
            <button id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <style>
                #sidebarToggle {
                    display: none;
                }

                @media (max-width: 768px) {
                    .sidebar {
                        position: fixed;
                        top: 0;
                        right: -250px;
                        /* مخفي */
                        width: 250px;
                        height: 100%;
                        background: #2c3e50;
                        color: white;
                        transition: right 0.3s ease;
                        z-index: 999;
                    }

                    /* لما يكون مفتوح */
                    .sidebar.open {
                        right: 0;
                    }

                    #sidebarToggle {
                        display: block;
                        background: linear-gradient(135deg, #3498db, #2ecc71);
                        border: none;
                        padding: 10px 14px;
                        border-radius: 8px;
                        font-size: 20px;
                        color: white;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                    }

                    /* تأثير عند المرور بالماوس */
                    #sidebarToggle:hover {
                        transform: scale(1.05);
                        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.3);
                    }

                    /* تأثير عند الضغط */
                    #sidebarToggle:active {
                        transform: scale(0.95);
                        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
                    }

                }


                /* زرار الهامبورجر يظهر في الشاشات الصغيرة */
                /* .sidebar-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 22px;
    color: white;
    cursor: pointer;
} */

                @media (max-width: 768px) {
                    .sidebar-toggle {
                        display: block;
                    }
                }
            </style>

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

        <script>
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('open');
            });
        </script>
