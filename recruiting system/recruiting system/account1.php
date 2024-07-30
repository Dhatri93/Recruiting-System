<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login1.php");
    exit();
}

require_once "database.php";

$user_id = $_SESSION["user"];

// Query to retrieve user details
$sql = "SELECT * FROM userdetails WHERE id = ?";
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
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2 class="mt-5 mb-4">User Profile Details</h2>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    
                    <li class="list-group-item"><strong>First Name:</strong> <?php echo $row['firstname']; ?></li>
                    <li class="list-group-item"><strong>Last Name:</strong> <?php echo $row['lastname']; ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo $row['email']; ?></li>
                    <li class="list-group-item"><strong>Phone No:</strong> <?php echo $row['phoneno']; ?></li>
                    <li class="list-group-item"><strong>Country:</strong> <?php echo $row['country']; ?></li>
                    <li class="list-group-item"><strong>City:</strong> <?php echo $row['city']; ?></li>
                    <li class="list-group-item"><strong>Pin Code:</strong> <?php echo $row['pincode']; ?></li>
                    <li class="list-group-item"><strong>Experience:</strong> <?php echo $row['experience']; ?></li>
                    <li class="list-group-item"><strong>Skills:</strong> <?php echo $row['skills']; ?></li>
                    <!-- Display a download link for the resume -->
                    <li class="list-group-item"><strong>Resume:</strong> <a href="uploads/<?php echo $row['resume']; ?>" download><?php echo $row['resume']; ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
