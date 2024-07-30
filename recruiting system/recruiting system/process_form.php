<?php
include 'database.php'; // Include the database connection file

// Retrieve form data
$emp_name = $_POST['emp_name'];
$companyname = $_POST['companyname'];
$emp_id = $_POST['emp_id'];
$dept = $_POST['dept'];
$email = $_POST['email'];
$phone = $_POST['phone'];


$sql = "INSERT INTO recruitdetails (emp_name, companyname, emp_id, dept, email, phone) VALUES ('$emp_name', '$companyname', '$emp_id', '$dept', '$email', '$phone')";
if (mysqli_query($conn, $sql)) {
    
    header("Location: recruitdashboard.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn); // Close the database connection
?>
