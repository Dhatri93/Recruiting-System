<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: login1.php");
   exit(); // Add exit to prevent further execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: black;
            color: white;
        }

        .container {
            background-color: #343a40; /* Grey color for container */
            padding: 50px;
            border-radius: 10px;
            margin-top: 150px;
            max-width: 450px; /* Adjust container width */
            margin-left: auto;
            margin-right: auto;
        }

        .form-control {
            background-color: #2b2f33; /* Dark grey color for form inputs */
            color: white;
            border-color: #495057; /* Darker grey border color */
        }

        .form-control:focus {
            background-color: #2b2f33; /* Dark grey color for focused inputs */
            color: white;
            border-color: #495057; /* Darker grey border color */
            box-shadow: none; /* Remove focus box-shadow */
        }

        .form-btn input[type="submit"] {
            background: linear-gradient(102.57deg, #d0121e, #e41175 100%); /* Gradient for button background */
            color: white;
            border: none;
        }

        .form-btn input[type="submit"]:hover {
            background: linear-gradient(102.57deg, #e41175, #d0121e); /* Gradient for button background on hover */
        }
        .form-group {
    margin-bottom: 20px;
    color: white; /* Adjust the margin as needed */
}
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $full_name = $_POST["full_name"]; // Changed $full_name from $fullName
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (empty($full_name) || empty($email) || empty($password) || empty($passwordRepeat)) { // Changed OR to ||
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password) < 8) { // Corrected spelling of "characters" and added a space after 8
            array_push($errors,"Password must be at least 8 characters long");
           }
           if ($password !== $passwordRepeat) {
            array_push($errors,"Passwords do not match"); // Changed "Password does not match" to "Passwords do not match"
           }
           require_once "database.php";
           $sql = "SELECT * FROM users1 WHERE email = ?";
           $stmt = mysqli_stmt_init($conn);
           if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);
                if ($rowCount > 0) {
                    array_push($errors, "Email already exists!");
                }
           } else {
                die("Database error. Please try again later."); // Handle database query preparation error
           }

           if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           } else {
                $sql = "INSERT INTO users1 (full_name, email, password) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sss", $full_name, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";
                } else {
                    die("Database error. Please try again later."); // Handle database insertion error
                }
           }
        }
        ?>
        <form action="registration1.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="full_name" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:"> <!-- Fixed typo -->
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
        <div><p>Already Registered <a href="login1.php">Login Here</a></p></div>
      </div>
    </div>
</body>
</html>
