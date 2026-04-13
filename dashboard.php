<?php
include 'db.php';

$sql = "SELECT * FROM predictions ORDER BY created_at DESC";
$result = $conn->query($sql);

// TOTAL RECORDS
$totalQuery = $conn->query("
SELECT COUNT(*) as total 
FROM predictions");
$totalData = $totalQuery->fetch_assoc();

// BURNOUT COUNT
$burnoutQuery = $conn->query("
    SELECT COUNT(*) as burnout_total 
    FROM predictions 
    WHERE LOWER(TRIM(result)) = 'burnout detected'
");
$burnoutData = $burnoutQuery ? $burnoutQuery->fetch_assoc() : ['burnout_total' => 0];

// NO BURNOUT COUNT
$normalQuery = $conn->query("
    SELECT COUNT(*) as normal_total 
    FROM predictions 
    WHERE LOWER(TRIM(result)) = 'no burnout'
");
$normalData = $normalQuery ? $normalQuery->fetch_assoc() : ['normal_total' => 0];

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
    font-family: 'Segoe UI', sans-serif;
    background: #f5f6f8;
    margin: 0;
    padding: 30px;
    color: #333;
}

/* PAGE TITLE */
h1, h2 {
    font-weight: 600;
    color: #222;
}

/* CARDS (optional match) */
.cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 20px;
}

.card h3 {
    font-size: 13px;
    color: #777;
    margin-bottom: 10px;
}

.card h2 {
    font-size: 26px;
}

/* TABLE CONTAINER */
.table {
    width: 100%;
    background: #fff;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 20px;
    overflow-x: auto;
}

/* HEADER */
thead {
    background: #fafafa;
}

th {
    text-align: left;
    padding: 14px 12px;
    font-size: 13px;
    color: #555;
    border-bottom: 1px solid #eaeaea;
    font-weight: 600;
}

/* ROWS */
td {
    padding: 12px;
    font-size: 13px;
    border-bottom: 1px solid #f0f0f0;
    color: #333;
}

/* HOVER */
tr:hover {
    background: #f9fafb;
}

/* BADGES */
.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.burnout {
    background: #ffeaea;
    color: #c0392b;
}

.normal {
    background: #eafaf1;
    color: #1e8449;
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
        <h2><?php echo $burnoutData['burnout_total']; ?></h2>
    </div>

    <div class="card">
        <h3>No Burnout</h3>
        <h2><?php echo $normalData['normal_total']; ?></h2>
    </div>
</div>

<h2>Prediction Records</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Job Role</th>
            <th>Experience</th>
            <th>Work Hours</th>
            <th>Remote Ratio</th>
            <th>Satisfaction</th>
            <th>Stress</th>
            <th>Percentage</th>
            <th>Result</th>
            <th>Date</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['prediction-id'] ?></td>  
            <td><?= $row['age'] ?></td>
            <td><?= $row['gender'] == 1 ? 'Male' : 'Female' ?></td>
            <td>
                <?php
                    switch($row['job_role']){
                        case 1: echo "Engineer"; break;
                        case 3: echo "Manager"; break;
                        case 0: echo "Analyst"; break;
                        case 2: echo "HR"; break;
                        case 4: echo "Sales"; break;
                    }
                ?>
            </td>
            <td><?= $row['experience'] ?></td>
            <td><?= $row['work_hours'] ?></td>
            <td><?= $row['remote_ratio'] ?></td>
            <td><?= $row['satisfaction'] ?></td>
            <td><?= $row['stress'] ?></td>
            <td><?= $row['percentage'] ?>%</td>
            <td><?= $row['result'] ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>