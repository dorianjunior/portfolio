// Menu Mobile Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            this.classList.toggle('active');
        });
    }
    
    // Seletor de idioma
    const languageBtn = document.getElementById('languageBtn');
    const languageDropdown = document.getElementById('languageDropdown');
    
    if (languageBtn && languageDropdown) {
        languageBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            languageDropdown.classList.toggle('active');
        });
        
        // Fechar dropdown ao clicar fora
        document.addEventListener('click', function(e) {
            if (!languageBtn.contains(e.target) && !languageDropdown.contains(e.target)) {
                languageDropdown.classList.remove('active');
            }
        });
    }
    
    // Smooth scroll para links internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Highlight do menu ativo
    const currentPage = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }
    });
});

// Formulário de contato - Validação básica
const contactForm = document.querySelector('form[action="/contato"]');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        const name = this.querySelector('[name="name"]');
        const email = this.querySelector('[name="email"]');
        const message = this.querySelector('[name="message"]');
        
        let hasError = false;
        
        if (name && !name.value.trim()) {
            alert('Por favor, preencha seu nome');
            name.focus();
            e.preventDefault();
            return false;
        }
        
        if (email && !email.value.trim()) {
            alert('Por favor, preencha seu email');
            email.focus();
            e.preventDefault();
            return false;
        }
        
        if (email && !isValidEmail(email.value)) {
            alert('Por favor, insira um email válido');
            email.focus();
            e.preventDefault();
            return false;
        }
        
        if (message && !message.value.trim()) {
            alert('Por favor, escreva sua mensagem');
            message.focus();
            e.preventDefault();
            return false;
        }
    });
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Animação das barras de progresso (skills)
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const progressBars = entry.target.querySelectorAll('.skill-progress');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        }
    });
}, observerOptions);

const skillsSection = document.querySelector('.skills');
if (skillsSection) {
    observer.observe(skillsSection);
}
// Fim do script.js
