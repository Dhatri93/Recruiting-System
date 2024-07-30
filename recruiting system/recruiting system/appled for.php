<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user'])) {
    header("Location: login1.php");
    exit;
}

// Prepare the SQL query to retrieve job descriptions based on user's applied jobs
$sql = "SELECT jobdescription.*
        FROM applications
        JOIN jobdescription ON applications.job_id = jobdescription.id
        WHERE applications.user_id = ?";

// Prepare the SQL statement
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Prepare statement failed: " . mysqli_error($conn));
}

// Bind parameters and execute the statement
$user_id = $_SESSION['user'];
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

// Get the result set
$result = mysqli_stmt_get_result($stmt);

// Check if there are any job descriptions
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        // Output job title and description
        echo "Job Title: " . $row["jobtitle"] . "<br>"; // Update the column name
        echo "Description: " . $row["description"] . "<br>";
        // Output other job details as needed
        echo "salary: " . $row["salary"] . "<br>"; // Update the column name
        echo "experience: " . $row["experience"] . "<br>";
    }
} else {
    echo "No job descriptions found for the user.";
}

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
