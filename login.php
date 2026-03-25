<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>BurnoutSense — Login</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f5f4f2;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .card {
    background: #fff;
    border-radius: 20px;
    padding: 48px 44px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.04), 0 20px 60px rgba(0,0,0,0.08);
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 32px;
  }
  .logo-icon {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #e8400c, #f97b3d);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
  }
  .logo-name {
    font-size: 17px;
    font-weight: 700;
    color: #1a1a1a;
  }
  .logo-sub {
    font-size: 11px;
    color: #999;
    margin-top: 1px;
  }

  h2 {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 6px;
  }
  .subtitle {
    font-size: 13.5px;
    color: #999;
    margin-bottom: 32px;
  }

  .field { margin-bottom: 18px; }
  .field label {
    display: block;
    font-size: 12.5px;
    font-weight: 600;
    color: #555;
    margin-bottom: 7px;
  }
  .field input {
    width: 100%;
    padding: 12px 14px;
    border: 1.5px solid #e8e8e8;
    border-radius: 10px;
    font-family: inherit;
    font-size: 14px;
    color: #1a1a1a;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    background: #fafafa;
  }
  .field input:focus {
    border-color: #f97b3d;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(249,123,61,0.1);
  }
  .field input::placeholder { color: #bbb; }

  .field-error {
    font-size: 12px;
    color: #e53e3e;
    margin-top: 5px;
    display: none;
  }
  .field.error input { border-color: #e53e3e; }
  .field.error .field-error { display: block; }

  .row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }
  .remember {
    display: flex; align-items: center; gap: 7px;
    font-size: 13px; color: #777; cursor: pointer;
  }
  .remember input { accent-color: #f97b3d; width: 14px; height: 14px; cursor: pointer; }
  .forgot { font-size: 13px; color: #f97b3d; text-decoration: none; font-weight: 600; }
  .forgot:hover { text-decoration: underline; }

  .btn {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #e8400c, #f97b3d);
    color: #fff;
    font-family: inherit;
    font-size: 15px;
    font-weight: 700;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: opacity .2s, transform .15s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
  }
  .btn:hover { opacity: .92; transform: translateY(-1px); }
  .btn:active { transform: translateY(0); }
  .btn:disabled { opacity: .6; cursor: not-allowed; transform: none; }

  @keyframes spin { to { transform: rotate(360deg); } }
  .spinner {
    width: 15px; height: 15px;
    border: 2px solid rgba(255,255,255,.4);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin .6s linear infinite;
    display: none;
  }
  .btn.loading .spinner { display: block; }
  .btn.loading .btn-label { opacity: .7; }

  .register {
    text-align: center;
    margin-top: 22px;
    font-size: 13px;
    color: #999;
  }
  .register a { color: #f97b3d; font-weight: 600; text-decoration: none; }
  .register a:hover { text-decoration: underline; }

  .toast {
    position: fixed; bottom: 24px; right: 24px;
    padding: 12px 18px; border-radius: 10px;
    font-size: 13.5px; font-weight: 600;
    opacity: 0; transform: translateY(6px);
    transition: all .25s; pointer-events: none;
  }
  .toast.show { opacity: 1; transform: translateY(0); }
  .toast.ok  { background: #edfaf4; color: #2d9c6a; border: 1px solid #b2dfcb; }
  .toast.err { background: #fff0f0; color: #c53030; border: 1px solid #f5c0c0; }

  .success-screen {
    display: none;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 20px 0;
  }
  .success-screen.show { display: flex; }
  .check {
    width: 64px; height: 64px; border-radius: 50%;
    background: #edfaf4; border: 2px solid #b2dfcb;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; margin-bottom: 16px;
    animation: pop .35s cubic-bezier(.3,1.4,.5,1) both;
  }
  @keyframes pop { from { transform: scale(.5); opacity:0; } to { transform: scale(1); opacity:1; } }
  .success-screen h3 { font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 6px; }
  .success-screen p  { font-size: 13.5px; color: #999; }

  @keyframes fadeIn { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
  .card { animation: fadeIn .45s ease both; }
</style>
</head>
<body>

<div class="card">

  <!-- Logo -->
  <div class="logo">
    <div class="logo-icon">🔥</div>
    <div>
      <div class="logo-name">BurnoutSense</div>
      <div class="logo-sub">Employee Burnout Prediction</div>
    </div>
  </div>

  <!-- Form -->
  <div id="form-section">
    <h2>Welcome back</h2>
    <p class="subtitle">Sign in to access your dashboard.</p>

    <div class="field" id="f-email">
      <label>Email</label>
      <input type="email" id="email" placeholder="you@company.com" />
      <div class="field-error">Please enter a valid email.</div>
    </div>

    <div class="field" id="f-pass">
      <label>Password</label>
      <input type="password" id="pass" placeholder="••••••••" />
      <div class="field-error">Password is required.</div>
    </div>

    <div class="row">
      <label class="remember">
        <input type="checkbox" /> Remember me
      </label>
      <a href="#" class="forgot">Forgot password?</a>
    </div>

    <button class="btn" id="login-btn" onclick="doLogin()">
      <div class="spinner"></div>
      <span class="btn-label">Sign in</span>
    </button>

    <p class="register">Don't have an account? <a href="register.php">Sign up</a></p>
  </div>

  <!-- Success -->
  <div class="success-screen" id="success-screen">
    <div class="check">✓</div>
    <h3>Login successful!</h3>
    <p>Redirecting to your dashboard…</p>
  </div>

</div>

<div class="toast" id="toast"></div>

<script>
  const USERS = [
    { email: 'admin@burnoutsense.ph', pass: 'admin123' },
    { email: 'demo@burnoutsense.ph',  pass: 'demo1234' },
  ];

  function doLogin() {
    const email = document.getElementById('email').value.trim();
    const pass  = document.getElementById('pass').value;
    let valid = true;

    // clear errors
    document.getElementById('f-email').classList.remove('error');
    document.getElementById('f-pass').classList.remove('error');

    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      document.getElementById('f-email').classList.add('error');
      valid = false;
    }
    if (!pass) {
      document.getElementById('f-pass').classList.add('error');
      valid = false;
    }
    if (!valid) return;

    const user = USERS.find(u => u.email === email && u.pass === pass);
    if (!user) {
      toast('Invalid email or password.', 'err');
      document.getElementById('f-email').classList.add('error');
      document.getElementById('f-pass').classList.add('error');
      return;
    }

    const btn = document.getElementById('login-btn');
    btn.classList.add('loading');
    btn.disabled = true;
    document.querySelector('.btn-label').textContent = 'Signing in…';

    setTimeout(() => {
      document.getElementById('form-section').style.display = 'none';
      document.getElementById('success-screen').classList.add('show');
      toast('Login successful!', 'ok');
    }, 1600);
  }

  function toast(msg, type) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'toast ' + type + ' show';
    setTimeout(() => t.classList.remove('show'), 3000);
  }

  // submit on Enter
  document.addEventListener('keydown', e => { if (e.key === 'Enter') doLogin(); });
</script>
</body>
</html>