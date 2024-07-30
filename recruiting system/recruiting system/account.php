<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

require_once "database.php";

$user_id = $_SESSION["user"];

$sql = "SELECT * FROM recruitdetails WHERE id = ?";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2 class="mt-5 mb-4">User Account Details</h2>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Company Name:</strong> <?php echo $row['companyname']; ?></li>
                    <li class="list-group-item"><strong>Employee Name:</strong> <?php echo $row['emp_name']; ?></li>
                    <li class="list-group-item"><strong>Employee ID:</strong> <?php echo $row['emp_id']; ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo $row['email']; ?></li>
                    <li class="list-group-item"><strong>Department:</strong> <?php echo $row['dept']; ?></li>
                    <li class="list-group-item"><strong>Phone:</strong> <?php echo $row['phone']; ?></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
