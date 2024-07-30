<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user'])) {
    header("Location: login1.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['job_id'])) {
    // Retrieve user details from userdetails table based on user's session
    $user_id = $_SESSION['user'];
    $sql_user_details = "SELECT * FROM userdetails WHERE id = ?";
    $stmt_user_details = mysqli_prepare($conn, $sql_user_details);
    
    if (!$stmt_user_details) {
        // Error handling for prepare statement
        die("Prepare statement failed: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt_user_details, "i", $user_id);
    mysqli_stmt_execute($stmt_user_details);
    $user_result = mysqli_stmt_get_result($stmt_user_details);
    $user_details = mysqli_fetch_assoc($user_result);

    // Insert user details into application table
    $sql_insert_application = "INSERT INTO applications (job_id, user_id, firstname, lastname, email, phoneno, country, city, pincode, experience, skills, resume) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_application = mysqli_prepare($conn, $sql_insert_application);
    
    if (!$stmt_insert_application) {
        // Error handling for prepare statement
        die("Prepare statement failed: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt_insert_application, "iissssssssss", $_POST['job_id'], $user_id, $user_details['firstname'], $user_details['lastname'], $user_details['email'], $user_details['phoneno'], $user_details['country'], $user_details['city'], $user_details['pincode'], $user_details['experience'], $user_details['skills'], $user_details['resume']);
    mysqli_stmt_execute($stmt_insert_application);

    // Redirect to a success page or any other page after applying
     header("Location: success.php");
    
    exit;
}
?>