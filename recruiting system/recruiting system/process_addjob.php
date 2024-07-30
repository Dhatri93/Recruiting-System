<?php
include 'database.php'; // Include the database connection file


$jobtitle = $_POST['jobtitle'];
$companyname = $_POST['companyname'];
$salary = $_POST['salary'];
$experience = $_POST['experience'];
$description= $_POST['description'];


// Insert form data into the recruitdetails table
$sql = "INSERT INTO jobdescription (jobtitle, companyname, salary,experience, description) VALUES ('$jobtitle', '$companyname', '$salary', '$experience', '$description')";

if (mysqli_query($conn, $sql)) {
    echo "successfully submitted";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn); // Close the database connection
?>
