<?php
include 'db.php';

$result = "";
$percentage = 0;
$category = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect inputs
    $Age = $_POST['Age'];
    $Gender = $_POST['Gender'];
    $JobRole = $_POST['JobRole'];
    $Experience = $_POST['Experience'];
    $WorkHoursPerWeek = $_POST['WorkHoursPerWeek'];
    $RemoteRatio = $_POST['RemoteRatio'];
    $SatisfactionLevel = $_POST['SatisfactionLevel'];
    $StressLevel = $_POST['StressLevel'];

    // ✅ Safe command (IMPORTANT)
    $command = "python predict.py "
        . escapeshellarg($Age) . " "
        . escapeshellarg($Gender) . " "
        . escapeshellarg($JobRole) . " "
        . escapeshellarg($Experience) . " "
        . escapeshellarg($WorkHoursPerWeek) . " "
        . escapeshellarg($RemoteRatio) . " "
        . escapeshellarg($SatisfactionLevel) . " "
        . escapeshellarg($StressLevel)
        . " 2>&1";

    $output = shell_exec($command);
    $output = trim($output);

    if ($output != "") {

        // ✅ Expected format: 72|Burnout Detected - Critical
        list($percentage, $result_text) = explode("|", $output);

        $result = $result_text;

        // Extract category (after "-")
        if (strpos($result_text, '-') !== false) {
            $parts = explode("-", $result_text);
            $category = trim($parts[1]);
        }

        // ✅ Save ALL data
        $stmt = $conn->prepare("INSERT INTO predictions 
        (age, gender, job_role, experience, work_hours, remote_ratio, satisfaction, stress, percentage, category, result) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "iiiiidddsss",
            $Age,
            $Gender,
            $JobRole,
            $Experience,
            $WorkHoursPerWeek,
            $RemoteRatio,
            $SatisfactionLevel,
            $StressLevel,
            $percentage,
            $category,
            $result
        );

        $stmt->execute();

    } else {
        $result = "Error running prediction";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Prediction — BurnoutSense</title>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="assets/css/prediction.css">
</head>

<body>

<div class="container">
    <?php if ($result != "") { ?>
    <div class="result">
        <strong><?php echo $result; ?></strong><br>
        Confidence: <?php echo $percentage; ?>%<br>
        Level: <?php echo $category; ?>
    </div>
<?php } ?>

    <h2>Prediction</h2>

    <form method="POST">
        <div class="grid">
            <input name="Age" placeholder="Age" required>

            <select name="Gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="1">Male</option>
                <option value="0">Female</option>
            </select>

            <select name="JobRole" required>
                <option value="" disabled selected>Select Job Role</option>
                <option value="1">Engineer</option>
                <option value="3">Manager</option>
                <option value="0">Analyst</option>
                <option value="2">HR</option>
                <option value="4">Sales</option>
            </select>
            
            <input name="Experience" placeholder="Years of Experience" required>
            <input name="WorkHoursPerWeek" placeholder="Work Hours per Week" required>
            <input name="RemoteRatio" placeholder="Remote Ratio " required>
            <input name="SatisfactionLevel" placeholder="Satisfaction Level " required>
            <input name="StressLevel" placeholder="Stress Level " required>
        </div>

        <button type="submit">Predict</button>
    </form>


</div>

</body>
</html>