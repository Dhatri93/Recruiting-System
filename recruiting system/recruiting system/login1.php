<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: form1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
        if (isset($_POST["login1"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Include database connection
            require_once "database.php";

            $sql = "SELECT * FROM users1 WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_assoc($result);

                if ($user) {
                    if (password_verify($password, $user["password"])) {
                        // Start the session and set user ID
                        session_start();
                        $_SESSION["user"] = $user["id"]; // Setting session variable for jobseeker

                        // Redirect to form1.php if the form is not filled
                        if (!$user["form_filled"]) {
                            header("Location: form1.php");
                            exit();
                        } else {
                            // Redirect to recruiter dashboard if the form is already filled
                            header("Location: jobseekerdashboard.php");
                            exit();
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Password does not match</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Email does not exist</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error: Database query failed</div>";
            }
        }
        ?>
        <form action="login1.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login1" class="btn btn-primary">
            </div>
        </form>
        <div><p>Not registered yet <a href="registration1.php">Register Here</a></p></div>
    </div>
</body>
</html>
