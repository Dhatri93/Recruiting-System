<?php
session_start();

// Redirect if the user is already logged in
if (isset($_SESSION["jobseeker"])) {
    header("Location: form1.php");
    exit();
}

require_once "database.php";

// Initialize variables
$full_name = $email = "";
$errors = array();

// Process form data when submitted
if (isset($_POST["submit"])) {
    // Sanitize and validate input
    $full_name = htmlspecialchars($_POST["full_name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];

    if (empty($full_name) || empty($email) || empty($password) || empty($passwordRepeat)) {
        $errors[] = "All fields are required";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    if ($password !== $passwordRepeat) {
        $errors[] = "Passwords do not match";
    }

    // Check if email already exists
    $sql = "SELECT * FROM users1 WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = "Email already exists";
        }
    } else {
        $errors[] = "Database error. Please try again later.";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $sql = "INSERT INTO users1 (full_name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $full_name, $email, $passwordHash);
            if (mysqli_stmt_execute($stmt)) {
                // Registration successful, redirect to login page
                header("Location: login1.php");
                exit();
            } else {
                $errors[] = "Error registering user";
            }
        } else {
            $errors[] = "Database error. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<style>body {
    background-color: black;
    color: white;
}

.container {
    background-color: #333;
    padding: 60px;
    border-radius: 10px;
}

.form-control {
    width: calc(100% - 20px); /* Adjust the width as needed */
    padding: 8px;
    margin-bottom: 15px;
    background-color: white;
    border: none;
    border-radius: 5px;
    color: white;
}

.form-label {
    color: white; /* Change label color to white */
}

.btn-primary {
    background: linear-gradient(to right, #f32170, 
                    #ff6b08, #cf23cf, #eedd44);
                    
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    color: white;
    cursor: pointer;
    
}

.btn-primary:hover {
    background: linear-gradient(to right, #45a049, #1e87dd);
}


</style></head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Job Seeker Registration</h1>
        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="registration1.php" method="post">
            <div class="mb-2">
                <label for="full_name" class="form-label">Full Name:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo $full_name; ?>" required>
            </div>
            <div class="mb-2">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
            </div>
            <div class="mb-2">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="repeat_password" class="form-label">Repeat Password:</label>
                <input type="password" id="repeat_password" name="repeat_password" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Register</button>
        </form>
        <div class="mt-2">
            <p>Already have an account? <a href="login1.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
