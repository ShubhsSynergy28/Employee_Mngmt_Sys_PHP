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
    const password = document.querySelector('#reg_password');
    const togglePasswordConf = document.querySelector('#togglePasswordConf');
    const passwordConf = document.querySelector('#reg_passwordConf');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });
    
    togglePasswordConf.addEventListener('click', function() {
        const type = passwordConf.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConf.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });

    // Password strength meter
    password.addEventListener('input', function() {
        const strength = zxcvbn(this.value);
        const strengthMeter = document.getElementById('password-strength');
        const strengthColors = [
            { color: '#dc3545', width: '20%' }, // Very weak
            { color: '#fd7e14', width: '40%' }, // Weak
            { color: '#ffc107', width: '60%' }, // Moderate
            { color: '#28a745', width: '80%' }, // Strong
            { color: '#20c997', width: '100%' } // Very strong
        ];
        
        strengthMeter.style.width = strengthColors[strength.score].width;
        strengthMeter.style.background = strengthColors[strength.score].color;
    });

    // Form submission animation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const button = this.querySelector('button');
        button.innerHTML = 'Registering <i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
    });
});