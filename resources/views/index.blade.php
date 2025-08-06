<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم الإدارية</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- الشريط الجانبي -->
    @include('sidebar')

    <!-- المحتوى الرئيسي -->
    <main class="main-content">
        <!-- الهيدر العلوي -->
        @include('header')

        <!-- صفحة الإحصائيات -->
        <div class="page-content active" id="dashboard">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-details">
                        <h3>إجمالي المستخدمين</h3>
                        <p class="stat-number">1,254</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="stat-details">
                        <h3>إجمالي الأرصدة</h3>
                        <p class="stat-number">$45,678</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="stat-details">
                        <h3>إجمالي السحوبات</h3>
                        <p class="stat-number">$12,345</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-details">
                        <h3>التحويلات اليوم</h3>
                        <p class="stat-number">89</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-details">
                        <h3>عدد المكاتب</h3>
                        <p class="stat-number">156</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-details">
                        <h3>معدل النمو</h3>
                        <p class="stat-number">+15%</p>
                    </div>
                </div>
            </div>

            <div class="recent-activity">
                <h2>النشاطات الأخيرة</h2>
                <div class="activity-list">
                    <div class="activity-item">
                        <i class="fas fa-user-plus"></i>
                        <span>تم إضافة مستخدم جديد: أحمد محمد</span>
                        <small>منذ 5 دقائق</small>
                    </div>
                    <div class="activity-item">
                        <i class="fas fa-money-bill"></i>
                        <span>تم إضافة رصيد 500$ لـ سارة أحمد</span>
                        <small>منذ 15 دقيقة</small>
                    </div>
                    <div class="activity-item">
                        <i class="fas fa-exchange-alt"></i>
                        <span>تحويل جديد بقيمة 1000$ إلى مصر</span>
                        <small>منذ ساعة</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- صفحة المستخدمين -->
    

        <!-- صفحة التحويلات -->
        <div class="page-content" id="transfers">
            <div class="page-header">
                <h2>التحويلات المصرفية</h2>
                <button class="btn btn-primary" onclick="showAddTransferModal()">
                    <i class="fas fa-plus"></i>
                    إضافة تحويل
                </button>
            </div>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="البحث في التحويلات..." id="transferSearch">
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>رقم الحوالة</th>
                            <th>كود الحوالة</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>العنوان</th>
                            <th>الكمية</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody id="transfersTableBody">
                        <tr>
                            <td>TR001</td>
                            <td>MTR123456</td>
                            <td>أحمد محمد</td>
                            <td>ahmed@example.com</td>
                            <td>القاهرة، مصر</td>
                            <td>$500</td>
                            <td>2024-01-20</td>
                            <td><span class="status completed">مكتملة</span></td>
                        </tr>
                        <tr>
                            <td>TR002</td>
                            <td>MTR789012</td>
                            <td>فاطمة علي</td>
                            <td>fatima@example.com</td>
                            <td>الرياض، السعودية</td>
                            <td>$1,200</td>
                            <td>2024-01-19</td>
                            <td><span class="status pending">قيد المعالجة</span></td>
                        </tr>
                        <tr>
                            <td>TR003</td>
                            <td>MTR345678</td>
                            <td>خالد أحمد</td>
                            <td>khaled@example.com</td>
                            <td>دبي، الإمارات</td>
                            <td>$800</td>
                            <td>2024-01-18</td>
                            <td><span class="status completed">مكتملة</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- صفحة مكاتب التحويل -->
        {{-- <div class="page-content" id="offices">
            <div class="page-header">
                <h2>مكاتب التحويل</h2>
                <button class="btn btn-primary" onclick="showAddOfficeModal()">
                    <i class="fas fa-plus"></i>
                    إضافة مكتب
                </button>
            </div>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="البحث في المكاتب..." id="officeSearch">
            </div>

            <div class="offices-grid" id="officesGrid">
                <div class="office-card">
                    <div class="office-header">
                        <h3>مكتب الشرق الأوسط</h3>
                        <span class="office-country">مصر - القاهرة</span>
                    </div>
                    <div class="office-details">
                        <p><i class="fas fa-map-marker-alt"></i> شارع التحرير، وسط البلد</p>
                        <p><i class="fas fa-phone"></i> +20123456789</p>
                    </div>
                    <div class="office-actions">
                        <button class="btn-action edit" onclick="showEditOfficeModal(1)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action delete" onclick="deleteOffice(1)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div class="office-card">
                    <div class="office-header">
                        <h3>مكتب الخليج</h3>
                        <span class="office-country">السعودية - الرياض</span>
                    </div>
                    <div class="office-details">
                        <p><i class="fas fa-map-marker-alt"></i> شارع الملك فهد، العليا</p>
                        <p><i class="fas fa-phone"></i> +966123456789</p>
                    </div>
                    <div class="office-actions">
                        <button class="btn-action edit" onclick="showEditOfficeModal(2)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action delete" onclick="deleteOffice(2)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div class="office-card">
                    <div class="office-header">
                        <h3>مكتب الإمارات</h3>
                        <span class="office-country">الإمارات - دبي</span>
                    </div>
                    <div class="office-details">
                        <p><i class="fas fa-map-marker-alt"></i> شارع الشيخ زايد، دبي مارينا</p>
                        <p><i class="fas fa-phone"></i> +971123456789</p>
                    </div>
                    <div class="office-actions">
                        <button class="btn-action edit" onclick="showEditOfficeModal(3)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action delete" onclick="deleteOffice(3)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}
    </main>

    <!-- النوافذ المنبثقة -->

    <!-- نافذة إضافة مستخدم -->


    <!-- نافذة إضافة تحويل -->
    {{-- <div class="modal" id="addTransferModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>إضافة تحويل جديد</h3>
                <button class="modal-close" onclick="closeModal('addTransferModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group">
                            <label>رقم الحوالة</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>كود الحوالة</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>اسم المرسل</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>العنوان</label>
                        <textarea class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>المبلغ</label>
                        <input type="number" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('addTransferModal')">إلغاء</button>
                <button class="btn btn-primary">إضافة التحويل</button>
            </div>
        </div>
    </div> --}}

    <!-- نافذة إضافة مكتب -->
    {{-- <div class="modal" id="addOfficeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>إضافة مكتب جديد</h3>
                <button class="modal-close" onclick="closeModal('addOfficeModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>الدولة</label>
                        <select class="form-control" id="countrySelect" onchange="updateCities()">
                            <option value="">اختر الدولة</option>
                            <option value="egypt">مصر</option>
                            <option value="saudi">السعودية</option>
                            <option value="uae">الإمارات</option>
                            <option value="jordan">الأردن</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>المدينة</label>
                        <select class="form-control" id="citySelect">
                            <option value="">اختر المدينة</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>اسم المكتب</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>العنوان</label>
                        <textarea class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>رقم الهاتف</label>
                        <input type="tel" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('addOfficeModal')">إلغاء</button>
                <button class="btn btn-primary">إضافة المكتب</button>
            </div>
        </div>
    </div> --}}

    <script src="{{ asset('script.js') }}"></script>
</body>

</html>
