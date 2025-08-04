// بيانات تسجيل الدخول الافتراضية
const adminCredentials = {
    username: 'admin',
    password: 'admin123'
};

// تسجيل الدخول
// document.addEventListener('DOMContentLoaded', function() {
//     const loginForm = document.getElementById('loginForm');
    
//     // التحقق من حالة تسجيل الدخول
//     if (localStorage.getItem('isLoggedIn') === 'true') {
//         window.location.href = 'index.html';
//     }
    
//     loginForm.addEventListener('submit', function(e) {
//         e.preventDefault();
        
//         const username = document.getElementById('username').value;
//         const password = document.getElementById('password').value;
//         const rememberMe = document.getElementById('rememberMe').checked;
        
//         // التحقق من بيانات تسجيل الدخول
//         if (username === adminCredentials.username && password === adminCredentials.password) {
//             // حفظ حالة تسجيل الدخول
//             localStorage.setItem('isLoggedIn', 'true');
//             localStorage.setItem('adminUsername', username);
            
//             if (rememberMe) {
//                 localStorage.setItem('rememberMe', 'true');
//             }
            
//             // عرض رسالة نجاح
//             showSuccessMessage('تم تسجيل الدخول بنجاح');
            
//             // الانتقال إلى لوحة التحكم بعد ثانيتين
//             setTimeout(() => {
//                 window.location.href = 'index.html';
//             }, 1500);
            
//         } else {
//             // عرض رسالة خطأ
//             showErrorMessage('اسم المستخدم أو كلمة المرور غير صحيحة');
            
//             // هز النموذج
//             loginForm.classList.add('shake');
//             setTimeout(() => {
//                 loginForm.classList.remove('shake');
//             }, 500);
//         }
//     });
// });

// تبديل إظهار/إخفاء كلمة المرور
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// عرض رسالة نجاح
function showSuccessMessage(message) {
    showMessage(message, 'success');
}

// عرض رسالة خطأ
function showErrorMessage(message) {
    showMessage(message, 'error');
}

// عرض الرسائل
function showMessage(message, type) {
    // إزالة الرسائل السابقة
    const existingMessages = document.querySelectorAll('.message');
    existingMessages.forEach(msg => msg.remove());
    
    // إنشاء عنصر الرسالة
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;
    messageDiv.textContent = message;
    
    const bgColor = type === 'success' ? '#10b981' : '#ef4444';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    messageDiv.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
    `;
    
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        animation: slideInRight 0.3s ease;
        backdrop-filter: blur(10px);
    `;
    
    document.body.appendChild(messageDiv);
    
    // إزالة الرسالة بعد 3 ثوان
    setTimeout(() => {
        messageDiv.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.parentNode.removeChild(messageDiv);
            }
        }, 300);
    }, 3000);
}

// إضافة الرسوم المتحركة
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
    
    .shake {
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
`;
document.head.appendChild(style);