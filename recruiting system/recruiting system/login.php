<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: login.php");
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
 <style>body {
    background-color: black;
}

.login-container {
    background-color: #343a40;
    padding: 50px;
    border-radius: 10px;
    margin-top: 150px;
    color: white;
    max-width: 450px; /* Added to limit the width */
    margin-left: auto; /* Added to center the form horizontally */
    margin-right: auto; /* Added to center the form horizontally */
}

.form-btn input[type="submit"] {
    background: linear-gradient(102.57deg, #d0121e, #e41175 100%);
    color: white;
    border: none;
}

.form-btn input[type="submit"]:hover {
    background: linear-gradient(102.57deg, #e41175, #d0121e);
}
.form-group {
    margin-bottom: 20px; /* Adjust the margin as needed */
}


</style>
</head>
<body style="background-color: black;">
    <div class="container login-container">
        <?php
        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    // Start the session and set user ID
                    session_start();
                    $_SESSION["user"] = $user["id"];

                    // Redirect to form.php if the form is not filled
                    if (!$user["form_filled"]) {
                        header("Location: form.php");
                        exit();
                    } else {
                        // Redirect to recruiter dashboard if the form is already filled
                        header("Location: recruitdashboard.php");
                        exit();
                    }
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div>
    </div>
</body>
</html>
