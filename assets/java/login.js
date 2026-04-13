function doLogin() {
    const emailField = document.getElementById('email');
    const passField = document.getElementById('pass');
    const form = document.getElementById('loginForm');
    
    let valid = true;

    // Reset UI
    document.getElementById('f-email').classList.remove('error');
    document.getElementById('f-pass').classList.remove('error');

    // Validation
    if (!emailField.value.includes('@')) {
        document.getElementById('f-email').classList.add('error');
        valid = false;
    }
    if (passField.value.length < 1) {
        document.getElementById('f-pass').classList.add('error');
        valid = false;
    }

    if (!valid) return;

    // UI Loading State
    const btn = document.getElementById('login-btn');
    btn.classList.add('loading');
    btn.disabled = true;
    document.querySelector('.btn-label').textContent = 'Checking...';

    // Submit the form to PHP
    form.submit();
}

function toast(msg, type) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'toast ' + type + ' show';
    setTimeout(() => t.classList.remove('show'), 3000);
}
