 // Initialize Reveal.js animations
 document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on load
    const reveals = document.querySelectorAll('.reveal');
    reveals.forEach((el, i) => {
        setTimeout(() => {
            el.classList.add('active');
        }, 200 * i);
    });

    // Password visibility toggle
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#log_password');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });

    // Form submission animation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const button = this.querySelector('button');
        button.innerHTML = 'Logging in <i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
    });
});