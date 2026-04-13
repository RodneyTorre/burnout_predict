<?php
// detect current page
$current = basename($_SERVER['PHP_SELF']);
?>

<style>
.header {
    background: #fff;
    padding: 15px 30px;
    border-radius: 12px;
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.logo {
    font-weight: 700;
    font-size: 18px;
    color: #1a1a1a;
}

.nav {
    display: flex;
    gap: 20px;
}

.nav a {
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    color: #777;
    padding: 8px 12px;
    border-radius: 8px;
    transition: 0.2s;
}

.nav a:hover {
    background: #f5f4f2;
}

/* ACTIVE TAB */
.nav a.active {
    background: linear-gradient(135deg, #e8400c, #f97b3d);
    color: #fff;
}
</style>

<div class="header">
    <div class="logo">🔥 BurnoutSense</div>

    <div class="nav">
        <a href="dashboard.php" class="<?php echo ($current == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
        <a href="prediction.php" class="<?php echo ($current == 'prediction.php') ? 'active' : ''; ?>">Prediction</a>
        <a href="users.php" class="<?php echo ($current == 'users.php') ? 'active' : ''; ?>">Users</a>
        <a href="logout.php">Logout</a>
    </div>
</div>