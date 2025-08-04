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

        <div class="page-content" id="users">
            <div class="page-header">
                <h2>إدارة المستخدمين</h2>
                <button class="btn btn-primary" onclick="showAddUserModal()">
                    <i class="fas fa-plus"></i>
                    إضافة مستخدم
                </button>
            </div>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="البحث في المستخدمين..." id="userSearch">
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>صورة الهوية الامامية</th>
                            <th>صورة الهوية الخلفية</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الرصيد</th>
                            <th>تاريخ التسجيل</th>
                            {{-- <th>الحالة</th> --}}
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <img src="{{ asset($user->national_id_front) }}" alt="صورة الهوية الأمامية"
                                        style="width: 120px; height: auto; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);">
                                </td>
                                <td>
                                    <img src="{{ asset($user->national_id_back) }}" alt="صورة الهوية الخلفية"
                                        style="width: 120px; height: auto; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);">
                                </td>

                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->balance }}</td>
                                <td>{{ $user->created_at }}</td>
                                {{-- <td><span class="status active">نشط</span></td> --}}
                                <td>
                                    <button class="btn-action edit"
                                        onclick="showEditUserModal(
        {{ $user->id }}, 
        '{{ addslashes($user->name) }}', 
        '{{ addslashes($user->email) }}'
    )">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn-action balance"
                                        onclick="showAddBalanceModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->balance }}')">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <form action="{{ route('users.delete', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-action delete" onclick="deleteUser(1)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
















        <div class="modal" id="addUserModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>إضافة مستخدم جديد</h3>
                    <button class="modal-close" onclick="closeModal('addUserModal')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>الاسم الكامل</label>
                            <input name="name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input name="email" type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>كلمة المرور</label>
                            <input name="password" type="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> رقم الهاتف</label>
                            <input name="phone" type="number" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            <label>الرصيد الأولي</label>
                            <input name="balance" type="number" class="form-control" value="0">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary"
                                onclick="closeModal('addUserModal')">إلغاء</button>
                            <button class="btn btn-primary">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- نافذة تعديل مستخدم -->
        <div class="modal" id="editUserModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>تعديل المستخدم</h3>
                    <button class="modal-close" onclick="closeModal('editUserModal')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>الاسم الكامل</label>
                            <input name="name" type="text" class="form-control" value="أحمد محمد">
                        </div>
                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input name="email" readonly type="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> كلمة السر</label>
                            <input name="password" type="password" class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" onclick="closeModal('editUserModal')">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- نافذة إضافة رصيد -->
        <div class="modal" id="addBalanceModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>إضافة رصيد</h3>
                    <button class="modal-close" onclick="closeModal('addBalanceModal')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>المستخدم</label>
                            <input type="text" class="form-control user-name" readonly>
                        </div>
                        <div class="form-group">
                            <label>الرصيد الحالي</label>
                            <input type="text" class="form-control user-balance" readonly>
                        </div>
                        <div class="form-group">
                            <label>المبلغ المضاف</label>
                            <input name="amount" type="number" class="form-control" placeholder="أدخل المبلغ"
                                required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="closeModal('addBalanceModal')">إلغاء</button>
                            <button type="submit" class="btn btn-primary">إضافة الرصيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </main>


    <script src="{{ asset('script.js') }}"></script>


</body>

</html>
