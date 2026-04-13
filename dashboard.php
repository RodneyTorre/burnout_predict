<?php
include 'db.php';

// TOTAL RECORDS
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM predictions");
$totalData = $totalQuery->fetch_assoc();

// BURNOUT COUNT
$burnoutQuery = $conn->query("SELECT COUNT(*) as total FROM predictions WHERE result='Burnout Detected'");
$burnoutData = $burnoutQuery->fetch_assoc();

// NO BURNOUT COUNT
$normalQuery = $conn->query("SELECT COUNT(*) as total FROM predictions WHERE result='No Burnout'");
$normalData = $normalQuery->fetch_assoc();

// RECENT DATA
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard — BurnoutSense</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

<?php include 'header.php'; ?>
<style>
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f5f4f2;
    padding: 30px;
}

h1 {
    margin-bottom: 20px;
}

.cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.card {
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

.card h3 {
    font-size: 14px;
    color: #777;
}

.card h2 {
    font-size: 28px;
    margin-top: 10px;
}

.table {
    margin-top: 30px;
    background: #fff;
    padding: 20px;
    border-radius: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-align: left;
    font-size: 14px;
}

th {
    color: #999;
}

tr:not(:last-child) {
    border-bottom: 1px solid #eee;
}

.badge {
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

.burnout {
    background: #ffe5e5;
    color: #c53030;
}

.normal {
    background: #e6f9f0;
    color: #2d9c6a;
}
.nav {
    margin-bottom: 20px;
}
.nav a {
    margin-right: 10px;
    text-decoration: none;
    font-weight: bold;
    color: #f97b3d;
}
</style>
</head>

<body>

<h1>Dashboard</h1>

<div class="cards">
    <div class="card">
        <h3>Total Records</h3>
        <h2><?php echo $totalData['total']; ?></h2>
    </div>

    <div class="card">
        <h3>Burnout Cases</h3>
        <h2><?php echo $burnoutData['total']; ?></h2>
    </div>

    <div class="card">
        <h3>No Burnout</h3>
        <h2><?php echo $normalData['total']; ?></h2>
    </div>
</div>

<div class="table">
    <h3>Recent Predictions</h3>

    <table>
        <tr>
            <th>ID</th>
            <th>Result</th>
            <th>Date</th>
        </tr>

        <?php while($row = $recent->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td>
                <span class="badge <?php echo ($row['result'] == 'Burnout Detected') ? 'burnout' : 'normal'; ?>">
                    <?php echo $row['result']; ?>
                </span>
            </td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>