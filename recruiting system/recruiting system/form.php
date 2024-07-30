<?php
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

require_once "database.php";

$user_id = $_SESSION["user"];
$form_filled = false;

// Check if the user has already filled out the form
$sql = "SELECT form_filled FROM users WHERE id = ?";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $form_filled = $row['form_filled'];
    }
}

// If the form is already filled, redirect to the recruiter dashboard
if ($form_filled) {
    header("Location: recruitdashboard.php");
    exit();
}

// If form is submitted, process the data
if (isset($_POST["submit"])) {
    $companyname = $_POST["companyname"];
    $emp_name = $_POST["emp_name"];
    $emp_id = $_POST["emp_id"];
    $email = $_POST["email"];
    $dept = $_POST["dept"];
    $phone = $_POST["phone"];

    // Insert form data into the database
    $sql_insert = "INSERT INTO recruitdetails (id, companyname, emp_name, emp_id, email, dept, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
        mysqli_stmt_bind_param($stmt_insert, "issssss", $user_id, $companyname, $emp_name, $emp_id, $email, $dept, $phone);
        mysqli_stmt_execute($stmt_insert);

        // Update the form_filled flag in the users table
        $sql_update = "UPDATE users SET form_filled = 1 WHERE id = ?";
        $stmt_update = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt_update, $sql_update)) {
            mysqli_stmt_bind_param($stmt_update, "i", $user_id);
            mysqli_stmt_execute($stmt_update);

            // Redirect to the recruiter dashboard after successful form submission
            header("Location: recruitdashboard.php");
            exit();
        } else {
            echo "Error updating form status: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php if (!$form_filled) : ?>
            <!-- Display the form only if the user has not already filled it out -->
            <h2 class="mt-5 mb-4">User Details Form</h2>
            <form action="form.php" method="post">
                <div class="mb-3">
                    <label for="companyname" class="form-label">Company Name:</label>
                    <input type="text" id="companyname" name="companyname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="emp_name" class="form-label">Employee Name:</label>
                    <input type="text" id="emp_name" name="emp_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="emp_id" class="form-label">Employee ID:</label>
                    <input type="text" id="emp_id" name="emp_id" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="dept" class="form-label">Department:</label>
                    <input type="text" id="dept" name="dept" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="tel" id="phone" name="phone" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
