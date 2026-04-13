<?php
session_start();
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $role  = $_POST['role'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    // 2. Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already registered!";
        } else {

            $sql = "INSERT INTO users (fname, lname, email, role, password, Cpassword) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $fname, $lname, $email, $role, $password, $confirm_password);

            if ($stmt->execute()) {
                header("Location: login.php?registered=1");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>BurnoutSense — Register</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="assets/css/register.css" />
</head>
<body>

<div class="card">
  <!-- ... Logo Section ... -->

  <div id="form-section">
    <h2>Create account</h2>
    <p class="subtitle">Fill in your details to get started.</p>

    <!-- 1. Added Form Tag with method and action -->
    <form method="POST" action="register.php" id="registrationForm">
      
      <div class="two-col">
        <div class="field">
          <label>First Name</label>
          <!-- 2. Added name="fname" -->
          <input type="text" name="fname" id="fname" placeholder="Juan" required />
        </div>
        <div class="field">
          <label>Last Name</label>
          <!-- 2. Added name="lname" -->
          <input type="text" name="lname" id="lname" placeholder="dela Cruz" required />
        </div>
      </div>

      <div class="field">
        <label>Email Address</label>
        <!-- 2. Added name="email" -->
        <input type="email" name="email" id="email" placeholder="you@company.com" required />
      </div>

      <div class="field">
        <label>Role</label>
        <!-- 2. Added name="role" -->
        <select name="role" id="role" required>
          <option value="">Select your role…</option>
          <option value="HR Manager">HR Manager</option>
          <option value="Department Head">Department Head</option>
          <option value="Data Analyst">Data Analyst</option>
          <option value="Team Leader">Team Leader</option>
          <option value="Admin">Admin</option>
        </select>
      </div>

      <div class="field">
        <label>Password</label>
        <div class="pw-wrap">
          <!-- 2. Added name="password" -->
          <input type="password" name="password" id="pass" placeholder="Min. 8 characters" oninput="checkStrength(this.value)" required />
        </div>
      </div>

      <div class="field">
        <label>Confirm Password</label>
        <div class="pw-wrap">
          <!-- 2. Added name="confirm_password" -->
          <input type="password" name="confirm_password" id="pass2" placeholder="Repeat your password" required />
        </div>
      </div>

      <!-- 3. Changed button type to submit -->
      <button type="submit" class="btn" id="reg-btn">
        <span class="btn-label">Create Account</span>
      </button>
    </form>

    <p class="login-link">Already have an account? <a href="login.php">Sign in</a></p>
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