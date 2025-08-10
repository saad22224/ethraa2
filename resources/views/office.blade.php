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



        <!-- صفحة مكاتب التحويل -->
        <div class="page-content" id="offices">
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
                @foreach ($money_receipts as $office)
                    <div class="office-card">
                        <div class="office-header">
                            <h3>{{ $office->name }}</h3>
                            <span class="office-country">
                                {{ $office->country }} - {{ $office->city }}</span>
                        </div>
                        <div class="office-details">
                            <p><i class="fas fa-map-marker-alt">
                                </i>{{ $office->addresse }}</p>
                            @if ($office->phone)
                                <p><i class="fas fa-phone"></i> {{ $office->phone }}</p>
                            @endif
                        </div>
                        <div class="office-actions">
                            <button class="btn-action edit" onclick='showEditOfficeModal(@json($office))'>
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('offices.delete', $office->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action delete" onclick=" return confirm('هل تريد حذف هذا المكتب؟')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="office-card">
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
                </div> --}}
            </div>
        </div>



        <div class="modal" id="editOfficeModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>إضافة مكتب جديد</h3>
                    <button class="modal-close" onclick="closeModal('editOfficeModal')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="officeForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>الدولة</label>
                            <select name="country" class="form-control" id="countrySelectEdit"
                                onchange="updateCitiesedit()">
                                <option value="">اختر الدولة</option>
                                <option value="مصر">مصر</option>
                                <option value="السعودية">السعودية</option>
                                <option value="الإمارات">الإمارات</option>
                                <option value="الأردن">الأردن</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>المدينة</label>
                            <select name="city" class="form-control" id="citySelectEdit">
                                <option value="">اختر المدينة</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>اسم المكتب</label>
                            <input name="name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>العنوان</label>
                            <textarea name="addresse" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>رقم الهاتف</label>
                            <input name="phone" type="tel" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="closeModal('editOfficeModal')">إلغاء</button>
                            <button type="submit" class="btn btn-primary">إضافة المكتب</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal" id="addOfficeModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>إضافة مكتب جديد</h3>
                    <button class="modal-close" onclick="closeModal('addOfficeModal')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addofficeForm" method="POST" action="{{ route('offices.store') }}"">
                        @csrf
                        <div class="form-group">
                            <label>الدولة</label>
                            <select name="country" class="form-control" id="countrySelectAdd"
                                onchange="updateCitiesAdd()">
                                <option value="">اختر الدولة</option>
                                <option value="مصر">مصر</option>
                                <option value="السعودية">السعودية</option>
                                <option value="الإمارات">الإمارات</option>
                                <option value="الأردن">الأردن</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>المدينة</label>
                            <select name="city" class="form-control" id="citySelectAdd">
                                <option value="">اختر المدينة</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>اسم المكتب</label>
                            <input name="name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>العنوان</label>
                            <textarea name="addresse" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>رقم الهاتف</label>
                            <input name="phone" type="tel" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="closeModal('addOfficeModal')">إلغاء</button>
                            <button type="submit" class="btn btn-primary">إضافة المكتب</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>


    <script src="{{ asset('script.js') }}"></script>


</body>

</html>
