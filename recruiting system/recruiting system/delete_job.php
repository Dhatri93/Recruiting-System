<?php
session_start();

include 'database.php'; 

if (isset($_POST['job_id'])) {
    $jobId = $_POST['job_id'];

    $sql = "DELETE FROM jobdescription WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $jobId);
    
    
    if (mysqli_stmt_execute($stmt)) {
        echo 'success'; 
    } else {
        echo 'error'; 
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo 'error';
}
?>
