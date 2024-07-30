<?php
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login1.php");
    exit();
}

require_once "database.php";

$user_id = $_SESSION["user"];
$form_filled = false;

// Check if the user has already filled out the form
$sql = "SELECT form_filled FROM users1 WHERE id = ?";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $form_filled = $row['form_filled'];
    }
}

// If the form is already filled, redirect to the dashboard
if ($form_filled) {
    header("Location: jobseekerdashboard.php");
    exit();
}

// If form is submitted, process the data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phoneno = $_POST["phoneno"];
    $country = $_POST["country"];
    $city = $_POST["city"];
    $pincode = $_POST["pincode"];
    $experience = $_POST["experience"];
    $skills = $_POST["skills"];
    $resume = $_FILES["resume"]["name"];

    // Temporary file location
    $tmp_resume = $_FILES["resume"]["tmp_name"];


    // Move uploaded file to desired location
  move_uploaded_file($tmp_resume, "uploads/" . $resume);
   
    // Insert form data into the database
    $sql_insert = "INSERT INTO userdetails (id, firstname, lastname, email, phoneno, country, city, pincode, experience, skills, resume) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
        mysqli_stmt_bind_param($stmt_insert, "issssssssss", $user_id, $firstname, $lastname, $email, $phoneno, $country, $city, $pincode, $experience, $skills, $resume);
        mysqli_stmt_execute($stmt_insert);

        // Update the form_filled flag in the users table
        $sql_update = "UPDATE users1 SET form_filled = 1 WHERE id = ?";
        $stmt_update = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt_update, $sql_update)) {
            mysqli_stmt_bind_param($stmt_update, "i", $user_id);
            mysqli_stmt_execute($stmt_update);

            // Redirect to the job seeker dashboard after successful form submission
            header("Location: jobseekerdashboard.php");
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
        <h1 class="mt-5 mb-4">Job Seeker Details</h1>
        <?php if (!$form_filled) : ?>
            <!-- Display the form only if the user has not already filled it out -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name:</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phoneno" class="form-label">Phone Number:</label>
                    <input type="tel" id="phoneno" name="phoneno" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">Country:</label>
                    <input type="text" id="country" name="country" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City:</label>
                    <input type="text" id="city" name="city" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="pincode" class="form-label">Pincode:</label>
                    <input type="text" id="pincode" name="pincode" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="experience" class="form-label">Experience:</label>
                    <input type="text" id="experience" name="experience" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="skills" class="form-label">Skills:</label>
                    <input type="text" id="skills" name="skills" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="resume" class="form-label">Resume:</label>
                    <input type="file" id="resume" name="resume" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
