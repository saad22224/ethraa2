// Mobile Menu Functionality
const hamburger = document.getElementById('hamburger');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const closeBtn = document.getElementById('closeBtn');
const sidebarLinks = document.querySelectorAll('.sidebar-link');

// Open sidebar
hamburger.addEventListener('click', () => {
    sidebar.classList.add('active');
    overlay.classList.add('active');
    hamburger.classList.add('active');
    document.body.style.overflow = 'hidden';
});

// Close sidebar
function closeSidebar() {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    hamburger.classList.remove('active');
    document.body.style.overflow = 'auto';
}

closeBtn.addEventListener('click', closeSidebar);
overlay.addEventListener('click', closeSidebar);

// Close sidebar when clicking on links
sidebarLinks.forEach(link => {
    link.addEventListener('click', () => {
        closeSidebar();
    });
});

// FAQ Accordion
const faqItems = document.querySelectorAll('.faq-item');

faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    
    question.addEventListener('click', () => {
        // Close other items
        faqItems.forEach(otherItem => {
            if (otherItem !== item) {
                otherItem.classList.remove('active');
            }
        });
        
        // Toggle current item
        item.classList.toggle('active');
    });
});

// Smooth Scrolling for Navigation Links
const navLinks = document.querySelectorAll('a[href^="#"]');

navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        
        const targetId = link.getAttribute('href');
        const targetSection = document.querySelector(targetId);
        
        if (targetSection) {
            const offsetTop = targetSection.offsetTop - 80; // Account for fixed header
            
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });
});

// Header Background on Scroll
const header = document.querySelector('.header');

window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        header.style.background = 'rgba(26, 26, 26, 0.98)';
    } else {
        header.style.background = 'rgba(26, 26, 26, 0.95)';
    }
});

// Animate Elements on Scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe elements for animation
// const animateElements = document.querySelectorAll('.about-card, .feature-card, .faq-item');

// animateElements.forEach(el => {
//     el.style.opacity = '0';
//     el.style.transform = 'translateY(30px)';
//     el.style.transition = 'all 0.6s ease';
//     observer.observe(el);
// });

// Counter Animation for Hero Stats
const statNumbers = document.querySelectorAll('.stat-number');

const animateCounter = (element, target) => {
    const increment = target / 100;
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        
        if (target >= 1000000) {
            element.textContent = (current / 1000000).toFixed(1) + 'M+';
        } else if (target >= 1000) {
            element.textContent = (current / 1000).toFixed(0) + 'K+';
        } else {
            element.textContent = current.toFixed(0);
        }
        
        if (element.textContent.includes('24')) {
            element.textContent = '24/7';
        }
    }, 20);
};

// Start counter animation when hero section is visible
const heroObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            statNumbers.forEach(stat => {
                const text = stat.textContent;
                let target = 0;
                
                if (text.includes('50K')) target = 50000;
                else if (text.includes('1M')) target = 1000000;
                else if (text.includes('24')) target = 24;
                
                if (target > 0) {
                    animateCounter(stat, target);
                }
            });
            heroObserver.unobserve(entry.target);
        }
    });
});

const heroSection = document.querySelector('.hero');
if (heroSection) {
    heroObserver.observe(heroSection);
}

// Add loading animation
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
    
    // Animate hero elements
    const heroElements = document.querySelectorAll('.hero-text > *');
    heroElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.animation = `fadeInUp 0.8s ease forwards ${index * 0.1}s`;
    });
});

// Add CSS animation keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);

// Add parallax effect to hero section
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.floating-card');
    
    parallaxElements.forEach((el, index) => {
        const speed = 0.5 + (index * 0.1);
        el.style.transform = `translateY(${scrolled * speed}px)`;
    });
});

// Add click effect to buttons
const buttons = document.querySelectorAll('.btn, .app-btn');

buttons.forEach(button => {
    button.addEventListener('click', (e) => {
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        button.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});

// Add ripple effect CSS
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
    .btn, .app-btn {
        position: relative;
        overflow: hidden;
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(rippleStyle);