<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>BurnoutSense — Register</title>
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
    max-width: 420px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.04), 0 20px 60px rgba(0,0,0,0.08);
    animation: fadeIn .45s ease both;
  }

  @keyframes fadeIn { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }

  .logo {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 32px;
  }
  .logo-icon {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #e8400c, #f97b3d);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
  }
  .logo-name { font-size: 17px; font-weight: 700; color: #1a1a1a; }
  .logo-sub  { font-size: 11px; color: #999; margin-top: 1px; }

  h2 { font-size: 22px; font-weight: 700; color: #1a1a1a; margin-bottom: 6px; }
  .subtitle { font-size: 13.5px; color: #999; margin-bottom: 28px; }

  .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

  .field { margin-bottom: 16px; }
  .field label {
    display: block; font-size: 12.5px; font-weight: 600;
    color: #555; margin-bottom: 7px;
  }
  .field input, .field select {
    width: 100%; padding: 12px 14px;
    border: 1.5px solid #e8e8e8; border-radius: 10px;
    font-family: inherit; font-size: 14px; color: #1a1a1a;
    outline: none; background: #fafafa;
    transition: border-color .2s, box-shadow .2s;
  }
  .field input:focus, .field select:focus {
    border-color: #f97b3d; background: #fff;
    box-shadow: 0 0 0 3px rgba(249,123,61,0.1);
  }
  .field input::placeholder { color: #bbb; }
  .field select { color: #1a1a1a; cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23999' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px;
  }
  .field select option[value=""] { color: #bbb; }

  .field-error { font-size: 12px; color: #e53e3e; margin-top: 5px; display: none; }
  .field.error input, .field.error select { border-color: #e53e3e; }
  .field.error .field-error { display: block; }

  /* password strength */
  .pw-bars { display: flex; gap: 4px; margin-top: 8px; }
  .pw-bar { flex: 1; height: 3px; border-radius: 2px; background: #eee; transition: background .3s; }
  .pw-hint { font-size: 11.5px; color: #aaa; margin-top: 5px; }

  /* password wrapper */
  .pw-wrap { position: relative; }
  .pw-wrap input { padding-right: 42px; }
  .eye-btn {
    position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    font-size: 15px; color: #bbb; transition: color .2s;
  }
  .eye-btn:hover { color: #555; }

  .terms {
    display: flex; align-items: flex-start; gap: 9px;
    font-size: 13px; color: #777; margin-bottom: 22px; margin-top: 4px;
    cursor: pointer; line-height: 1.5;
  }
  .terms input { accent-color: #f97b3d; width: 15px; height: 15px; flex-shrink: 0; margin-top: 2px; cursor: pointer; }
  .terms a { color: #f97b3d; text-decoration: none; font-weight: 600; }
  .terms a:hover { text-decoration: underline; }
  .terms-err { font-size: 12px; color: #e53e3e; margin-bottom: 14px; margin-top: -10px; display: none; }
  .terms-err.show { display: block; }

  .btn {
    width: 100%; padding: 13px;
    background: linear-gradient(135deg, #e8400c, #f97b3d);
    color: #fff; font-family: inherit; font-size: 15px; font-weight: 700;
    border: none; border-radius: 10px; cursor: pointer;
    transition: opacity .2s, transform .15s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
  }
  .btn:hover { opacity: .92; transform: translateY(-1px); }
  .btn:active { transform: translateY(0); }
  .btn:disabled { opacity: .6; cursor: not-allowed; transform: none; }

  @keyframes spin { to { transform: rotate(360deg); } }
  .spinner {
    width: 15px; height: 15px; border-radius: 50%;
    border: 2px solid rgba(255,255,255,.4); border-top-color: #fff;
    animation: spin .6s linear infinite; display: none;
  }
  .btn.loading .spinner { display: block; }
  .btn.loading .btn-label { opacity: .7; }

  .login-link { text-align: center; margin-top: 22px; font-size: 13px; color: #999; }
  .login-link a { color: #f97b3d; font-weight: 600; text-decoration: none; }
  .login-link a:hover { text-decoration: underline; }

  /* success */
  .success-screen {
    display: none; flex-direction: column;
    align-items: center; text-align: center; padding: 20px 0;
  }
  .success-screen.show { display: flex; }
  .check {
    width: 64px; height: 64px; border-radius: 50%;
    background: #edfaf4; border: 2px solid #b2dfcb;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; margin-bottom: 16px;
    animation: pop .35s cubic-bezier(.3,1.4,.5,1) both;
  }
  @keyframes pop { from { transform:scale(.5); opacity:0; } to { transform:scale(1); opacity:1; } }
  .success-screen h3 { font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 6px; }
  .success-screen p  { font-size: 13.5px; color: #999; }

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
</style>
</head>
<body>

<div class="card">

  <div class="logo">
    <div class="logo-icon">🔥</div>
    <div>
      <div class="logo-name">BurnoutSense</div>
      <div class="logo-sub">Employee Burnout Prediction</div>
    </div>
  </div>

  <!-- Registration Form -->
  <div id="form-section">
    <h2>Create account</h2>
    <p class="subtitle">Fill in your details to get started.</p>

    <div class="two-col">
      <div class="field" id="f-fname">
        <label>First Name</label>
        <input type="text" id="fname" placeholder="Juan" />
        <div class="field-error">Required.</div>
      </div>
      <div class="field" id="f-lname">
        <label>Last Name</label>
        <input type="text" id="lname" placeholder="dela Cruz" />
        <div class="field-error">Required.</div>
      </div>
    </div>

    <div class="field" id="f-email">
      <label>Email Address</label>
      <input type="email" id="email" placeholder="you@company.com" />
      <div class="field-error">Enter a valid email address.</div>
    </div>

    <div class="field" id="f-role">
      <label>Role</label>
      <select id="role">
        <option value="">Select your role…</option>
        <option>HR Manager</option>
        <option>Department Head</option>
        <option>Data Analyst</option>
        <option>Team Leader</option>
        <option>Admin</option>
      </select>
      <div class="field-error">Please select a role.</div>
    </div>

    <div class="field" id="f-pass">
      <label>Password</label>
      <div class="pw-wrap">
        <input type="password" id="pass" placeholder="Min. 8 characters" oninput="checkStrength(this.value)" />
        <button type="button" class="eye-btn" onclick="togglePw('pass','eye1')" id="eye1">👁</button>
      </div>
      <div class="pw-bars">
        <div class="pw-bar" id="b1"></div>
        <div class="pw-bar" id="b2"></div>
        <div class="pw-bar" id="b3"></div>
        <div class="pw-bar" id="b4"></div>
      </div>
      <div class="pw-hint" id="pw-hint">Use 8+ characters with numbers &amp; symbols.</div>
      <div class="field-error">Password must be at least 8 characters.</div>
    </div>

    <div class="field" id="f-pass2">
      <label>Confirm Password</label>
      <div class="pw-wrap">
        <input type="password" id="pass2" placeholder="Repeat your password" />
        <button type="button" class="eye-btn" onclick="togglePw('pass2','eye2')" id="eye2">👁</button>
      </div>
      <div class="field-error">Passwords do not match.</div>
    </div>

    <button class="btn" id="reg-btn" onclick="doRegister()">
      <div class="spinner"></div>
      <span class="btn-label">Create Account</span>
    </button>

    <p class="login-link">Already have an account? <a href="login.php">Sign in</a></p>
  </div>

  <!-- Success -->
  <div class="success-screen" id="success-screen">
    <div class="check">✓</div>
    <h3>Account created!</h3>
    <p>Redirecting you to the login page…</p>
  </div>

</div>

<div class="toast" id="toast"></div>

<script>
  /* password strength */
  const colors = ['#e53e3e','#f97b3d','#7c6eff','#2d9c6a'];
  const labels = ['Weak','Fair','Good','Strong'];
  function checkStrength(v) {
    let s = 0;
    if (v.length >= 8) s++;
    if (/[A-Z]/.test(v)) s++;
    if (/[0-9]/.test(v)) s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;
    ['b1','b2','b3','b4'].forEach((id,i) => {
      document.getElementById(id).style.background = i < s ? colors[s-1] : '#eee';
    });
    const hint = document.getElementById('pw-hint');
    hint.textContent = s ? labels[s-1] : 'Use 8+ characters with numbers & symbols.';
    hint.style.color  = s ? colors[s-1] : '#aaa';
  }

  /* show/hide password */
  function togglePw(inputId, btnId) {
    const inp = document.getElementById(inputId);
    const btn = document.getElementById(btnId);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.textContent = inp.type === 'password' ? '👁' : '🙈';
  }

  /* clear error */
  function clr(id) { document.getElementById(id).classList.remove('error'); }
  ['fname','lname','email','role','pass','pass2'].forEach(id => {
    const el = document.getElementById(id);
    el.addEventListener('input',  () => clr('f-' + id));
    el.addEventListener('change', () => clr('f-' + id));
  });

  /* register */
  function doRegister() {
    const fname = document.getElementById('fname').value.trim();
    const lname = document.getElementById('lname').value.trim();
    const email = document.getElementById('email').value.trim();
    const role  = document.getElementById('role').value;
    const pass  = document.getElementById('pass').value;
    const pass2 = document.getElementById('pass2').value;
    const agreed = document.getElementById('terms').checked;
    let ok = true;

    // reset
    ['f-fname','f-lname','f-email','f-role','f-pass','f-pass2'].forEach(id =>
      document.getElementById(id).classList.remove('error'));
    document.getElementById('terms-err').classList.remove('show');

    if (!fname) { document.getElementById('f-fname').classList.add('error'); ok = false; }
    if (!lname) { document.getElementById('f-lname').classList.add('error'); ok = false; }
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { document.getElementById('f-email').classList.add('error'); ok = false; }
    if (!role)  { document.getElementById('f-role').classList.add('error'); ok = false; }
    if (pass.length < 8) { document.getElementById('f-pass').classList.add('error'); ok = false; }
    if (pass !== pass2)  { document.getElementById('f-pass2').classList.add('error'); ok = false; }
    if (!agreed) { document.getElementById('terms-err').classList.add('show'); ok = false; }
    if (!ok) return;

    const btn = document.getElementById('reg-btn');
    btn.classList.add('loading'); btn.disabled = true;
    document.querySelector('.btn-label').textContent = 'Creating account…';

    setTimeout(() => {
      document.getElementById('form-section').style.display = 'none';
      document.getElementById('success-screen').classList.add('show');
      showToast('Account created successfully!', 'ok');
    }, 1600);
  }

  function showToast(msg, type) {
    const t = document.getElementById('toast');
    t.textContent = msg; t.className = 'toast ' + type + ' show';
    setTimeout(() => t.classList.remove('show'), 3000);
  }
</script>
</body>
</html>