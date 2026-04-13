<?php
session_start();
include 'db.php'; // your database.php connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

// Check if user exists
$sql = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password']) || $password === $row['password']) {
      $_SESSION['email'] = $row['email'];
      header("Location: dashboard.php");
      exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>BurnoutSense — Login</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="assets/css/login.css" />
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
  <?php if (!empty($error)) { echo "<div class='error'>{$error}</div>"; } ?>
  <p class="subtitle">Sign in to access your dashboard.</p>

  <!-- Added Form Tag -->
  <form id="loginForm" method="POST" action="login.php">
    <div class="field">
      <label>Email</label>
      <!-- Added name="email" -->
      <input type="email" name="email" id="email" placeholder="you@company.com" required />
      <div class="field-error">Please enter a valid email.</div>
    </div>

    <div class="field" id="f-pass">
      <label>Password</label>
      <!-- Added name="password" -->
      <input type="password" name="password" id="pass" placeholder="••••••••" required />
      <div class="field-error">Password is required.</div>
    </div>

    <!-- Changed button to type="button" to keep your JS validation control -->
    <button type="submit" class="btn" id="login-btn">
      <div class="spinner"></div>
      <span class="btn-label">Sign in</span>
    </button>
  </form>

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
  function doLogin() {
  const email = document.getElementById('email').value;
  const pass = document.getElementById('pass').value;
  
  if (!email || !pass) {
    alert("Please fill in all fields.");
    return;
  }
  
  document.getElementById('loginForm').submit(); // submit the form to PHP
}
</script>

</body>
</html>