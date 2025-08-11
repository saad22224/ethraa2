// بيانات المدن حسب الدولة
const cities = {
    مصر: ['القاهرة', 'الإسكندرية', 'الجيزة', 'أسوان', 'الأقصر'],
    السعودية: ['الرياض', 'جدة', 'الدمام', 'مكة', 'المدينة'],
    الإمارات: ['دبي', 'أبوظبي', 'الشارقة', 'عجمان', 'رأس الخيمة'],
    الأردن: ['عمان', 'إربد', 'الزرقاء', 'العقبة', 'السلط']
};

// التنقل بين الصفحات
document.addEventListener('DOMContentLoaded', function () {
    // التحقق من حالة تسجيل الدخول
    // if (localStorage.getItem('isLoggedIn') !== 'true') {
    //     window.location.href = 'login.html';
    //     return;
    // }

    const menuItems = document.querySelectorAll('.menu-item');
    const pageContents = document.querySelectorAll('.page-content');
    const pageTitle = document.getElementById('pageTitle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    // عناوين الصفحات
    const pageTitles = {
        dashboard: 'الإحصائيات',
        users: 'إدارة المستخدمين',
        transfers: 'التحويلات المصرفية',
        offices: 'مكاتب التحويل'
    };

    // التنقل بين الصفحات
    menuItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            const targetPage = this.getAttribute('data-page');

            // إزالة الكلاس النشط من جميع العناصر
            menuItems.forEach(mi => mi.classList.remove('active'));
            pageContents.forEach(pc => pc.classList.remove('active'));

            // إضافة الكلاس النشط للعنصر المحدد
            this.classList.add('active');
            document.getElementById(targetPage).classList.add('active');

            // تحديث عنوان الصفحة
            pageTitle.textContent = pageTitles[targetPage];
        });
    });

    // تبديل الشريط الجانبي للهواتف
    sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('active');
    });

    // إغلاق الشريط الجانبي عند النقر خارجه
    document.addEventListener('click', function (e) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        }
    });

    // إعداد البحث
    setupSearch();
});

// إعداد البحث
function setupSearch() {
    const userSearch = document.getElementById('userSearch');
    const transferSearch = document.getElementById('transferSearch');
    const officeSearch = document.getElementById('officeSearch');

    if (userSearch) {
        userSearch.addEventListener('input', function () {
            searchTable('usersTableBody', this.value);
        });
    }

    if (transferSearch) {
        transferSearch.addEventListener('input', function () {
            searchTable('transfersTableBody', this.value);
        });
    }

    if (officeSearch) {
        officeSearch.addEventListener('input', function () {
            searchCards('officesGrid', this.value);
        });
    }
}

// البحث في الجداول
function searchTable(tableBodyId, searchTerm) {
    const tableBody = document.getElementById(tableBodyId);
    if (!tableBody) return;

    const rows = tableBody.querySelectorAll('tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const isVisible = text.includes(searchTerm.toLowerCase());
        row.style.display = isVisible ? '' : 'none';
    });
}

// البحث في بطاقات المكاتب
function searchCards(gridId, searchTerm) {
    const grid = document.getElementById(gridId);
    if (!grid) return;

    const cards = grid.querySelectorAll('.office-card');

    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        const isVisible = text.includes(searchTerm.toLowerCase());
        card.style.display = isVisible ? '' : 'none';
    });
}

// إدارة النوافذ المنبثقة
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// إغلاق النافذة عند النقر على الخلفية
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('modal')) {
        closeModal(e.target.id);
    }
});

// إغلاق النافذة بمفتاح Escape
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const activeModal = document.querySelector('.modal.active');
        if (activeModal) {
            closeModal(activeModal.id);
        }
    }
});

// وظائف المستخدمين
function showAddUserModal() {
    showModal('addUserModal');
}
function showAddbannerModal() {
    showModal('AddbannerModal');
}

function showEditUserModal(userId, name, email) {
    // افتح المودال
    showModal('editUserModal');

    // عيّن البيانات داخل الحقول
    document.querySelector('#editUserModal input[name="name"]').value = name;
    document.querySelector('#editUserModal input[name="email"]').value = email;

    // خلي الباسورد فاضي دايمًا عند التعديل
    document.querySelector('#editUserModal input[name="password"]').value = '';

    // حدّث مسار الفورم حسب ID المستخدم
    document.querySelector('#editUserModal form').action = `/users/update/${userId}`;
}

function showAddBalanceModal(userId, name, balance) {
    showModal('addBalanceModal');

    // ضبط الفورم على الرابط الصحيح
    const form = document.querySelector('#addBalanceModal form');
    form.action = `/users/addbalance/${userId}`; // تأكد إن ده نفس المسار في web.php

    // تعبئة الحقول
    form.querySelector('input[name="amount"]').value = ''; // نبدأ المبلغ فاضي
    form.querySelector('.user-name').value = name;
    form.querySelector('.user-balance').value = balance;
}





function deleteUser(userId) {
    if (confirm('هل أنت متأكد من حذف هذا المستخدم؟')) {
        console.log('حذف المستخدم:', userId);
        // هنا يتم حذف المستخدم
    }
}

// وظائف التحويلات
function showAddTransferModal() {
    showModal('addTransferModal');
}

// وظائف المكاتب
function showAddOfficeModal() {
    showModal('addOfficeModal');

    const countrySelect = document.getElementById('countrySelect');
    const citySelect = document.getElementById('citySelect');

    // 1. فضي الدولة والمدينة
    countrySelect.value = '';
    updateCitiesAdd(); // لازم تتنفذ عشان المدن تفضى أو تتحدث

    // 2. بعد تحديث المدن فضي المدينة
    setTimeout(() => {
        citySelect.value = '';
    }, 50);

    // 3. فضي باقي البيانات
    document.querySelector('#addOfficeModal input[type="text"]').value = '';
    document.querySelector('#addOfficeModal textarea').value = '';
    document.querySelector('#addOfficeModal input[type="tel"]').value = '';

    // 4. عدل عنوان المودال وزر الإرسال
    document.querySelector('#addOfficeModal .modal-header h3').textContent = 'إضافة مكتب';
    const submitBtn = document.querySelector('#addOfficeModal .modal-footer .btn-primary');
    submitBtn.textContent = 'إضافة المكتب';

    // 5. إعدادات الفورم
    const form = document.getElementById('addofficeForm');
    // form.action = `/offices/store`;
    form.method = 'POST';

    // 6. احذف _method لو موجود
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }

    // 7. تأكد من وجود CSRF
    if (!form.querySelector('input[name="_token"]')) {
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}'; // Laravel token
        form.appendChild(tokenInput);
    }
}


function showEditOfficeModal(office) {
    showModal('editOfficeModal');

    const countrySelect = document.getElementById('countrySelectEdit');
    const citySelect = document.getElementById('citySelectEdit');

    // 1. ضع الدولة أولاً
    countrySelect.value = office.country?.toLowerCase() || '';

    // 2. نحدث المدن بناءً على الدولة
    updateCitiesedit(); // لازم تفك الكومنت هنا علشان المدن تتحدث

    // 3. نستخدم setTimeout علشان نستنى لما المدن تتحدث
    setTimeout(() => {
        citySelect.value = office.city || '';
    }, 50);

    // 4. باقي البيانات
    document.querySelector('#editOfficeModal input[type="text"]').value = office.name || '';
    document.querySelector('#editOfficeModal textarea').value = office.addresse || '';
    document.querySelector('#editOfficeModal input[type="tel"]').value = office.phone || '';

    document.querySelector('#editOfficeModal .modal-header h3').textContent = 'تعديل المكتب';
    const submitBtn = document.querySelector('#editOfficeModal .modal-footer .btn-primary');
    submitBtn.textContent = 'تحديث المكتب';

    const form = document.getElementById('officeForm');
    form.action = `/offices/update/${office.id}`;
    form.method = 'POST';

    // _method PUT
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        form.appendChild(methodInput);
    }
    methodInput.value = 'PUT';

    // CSRF
    if (!form.querySelector('input[name="_token"]')) {
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';
        form.appendChild(tokenInput);
    }
}

function deleteOffice(officeId) {
    if (confirm('هل أنت متأكد من حذف هذا المكتب؟')) {
        console.log('حذف المكتب:', officeId);
        // هنا يتم حذف المكتب
    }
}

// تحديث المدن حسب الدولة المختارة
function updateCitiesAdd() {
    const countrySelect = document.getElementById('countrySelectAdd');
    const citySelect = document.getElementById('citySelectAdd');

    if (!countrySelect || !citySelect) return;

    const selectedCountry = countrySelect.value;

    // مسح المدن الحالية
    citySelect.innerHTML = '<option value="">اختر المدينة</option>';

    // إضافة المدن الجديدة
    if (selectedCountry && cities[selectedCountry]) {
                console.log('Available Cities:', cities[selectedCountry]); // تتبع

        cities[selectedCountry].forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        });
    }
}
function updateCitiesedit() {
    const countrySelect = document.getElementById('countrySelectEdit');
    const citySelect = document.getElementById('citySelectEdit');

    if (!countrySelect || !citySelect) return;

    const selectedCountry = countrySelect.value;

    // مسح المدن الحالية
    citySelect.innerHTML = '<option value="">اختر المدينة</option>';

    // إضافة المدن الجديدة
    if (selectedCountry && cities[selectedCountry]) {
                console.log('Available Cities:', cities[selectedCountry]); // تتبع

        cities[selectedCountry].forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        });
    }
}

// تحديث الساعة (اختياري)
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('ar-EG');

    // يمكن إضافة عنصر لعرض الوقت إذا لزم الأمر
    console.log('الوقت الحالي:', timeString);
}

// تشغيل تحديث الوقت كل دقيقة
setInterval(updateTime, 60000);

// معالجة إرسال النماذج (يمكن تخصيصها حسب الحاجة)
// document.addEventListener('submit', function(e) {
//     e.preventDefault();

//     const form = e.target;
//     const formData = new FormData(form);

//     // هنا يمكن إرسال البيانات إلى الخادم
//     console.log('إرسال البيانات:', Object.fromEntries(formData));

//     // إغلاق النافذة المنبثقة
//     const modal = form.closest('.modal');
//     if (modal) {
//         closeModal(modal.id);
//     }

//     // عرض رسالة نجاح
//     showSuccessMessage('تم حفظ البيانات بنجاح');
// });

// عرض رسائل النجاح
function showSuccessMessage(message) {
    // إنشاء عنصر الرسالة
    const messageDiv = document.createElement('div');
    messageDiv.className = 'success-message';
    messageDiv.textContent = message;
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        z-index: 3000;
        animation: slideInRight 0.3s ease;
    `;

    document.body.appendChild(messageDiv);

    // إزالة الرسالة بعد 3 ثوان
    setTimeout(() => {
        messageDiv.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(messageDiv);
        }, 300);
    }, 3000);
}

// تسجيل الخروج
function logout() {
    if (confirm('هل أنت متأكد من تسجيل الخروج؟')) {
        // مسح بيانات تسجيل الدخول
        localStorage.removeItem('isLoggedIn');
        localStorage.removeItem('adminUsername');
        localStorage.removeItem('rememberMe');

        // عرض رسالة تسجيل الخروج
        showSuccessMessage('تم تسجيل الخروج بنجاح');

        // الانتقال إلى صفحة تسجيل الدخول
        setTimeout(() => {
            window.location.href = 'login.html';
        }, 1500);
    }
}

// إضافة الرسوم المتحركة للرسائل
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);