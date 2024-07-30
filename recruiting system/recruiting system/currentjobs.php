<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user'])) {
    header("Location: login1.php");
    exit;
}

$sql = "SELECT * FROM jobdescription";
$result = mysqli_query($conn, $sql);

if (!$result) {
    // Query failed, handle the error
    echo "Error: " . mysqli_error($conn);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posted Jobs</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <h1>Current Job Openings</h1>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="job-container">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="job-card" id="job_' . $row['id'] . '">';
            echo '<h2>' . $row['jobtitle'] . '</h2>';
            echo '<h4>Company: ' . $row['companyname'] . '</h4>';
            echo '<p>Salary: ' . $row['salary'] . '</p>';
            echo '<p>Experience: ' . $row['experience'] . '</p>';
            echo '<p>Description: ' . $row['description'] . '</p>';
            // Form with hidden input for job_id
            echo '<form action="apply_job.php" method="post">';
            echo '<input type="hidden" name="job_id" value="' . $row['id'] . '">';
            echo '<button type="submit" class="apply-job-btn">Apply Job</button>';
            echo '</form>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "No posted jobs found.";
    }
    ?>

    <!-- Add your JavaScript here if needed -->
</body>
</html>
