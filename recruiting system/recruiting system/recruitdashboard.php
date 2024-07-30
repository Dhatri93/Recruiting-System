<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $companyname=$_POST["companyname"];
    $jobtitle = $_POST["jobtitle"];
    $salary = $_POST["salary"];
    $experience = $_POST["experience"];
    $description = $_POST["description"];
    require_once "database.php";

    $sql = "INSERT INTO jobdescription (companyname,jobtitle, salary, experience, description) VALUES (?,?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

    if ($prepareStmt) {
        mysqli_stmt_bind_param($stmt, "sssss",$companyname, $jobtitle, $salary, $experience, $description);
        mysqli_stmt_execute($stmt);
        echo "<div class='alert alert-success'>Job details added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Something went wrong: " . mysqli_error($conn) . "</div>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    font-size: larger;
    margin: 0;
    padding: 0;
    background-color:#2f383d;
    color: #ddd;
}

.sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #1e2022;
    color: #ddd;
    padding-top: 20px;
}
.alert alert-success{
position: relative;
right:20px;
}

.sidebar h2 {
    color: #fff;
    text-align: center;
    margin-bottom: 30px;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.sidebar ul li {
    padding: 25px;
}

.sidebar ul li a {
    color: #fff;
    text-decoration: none;
    display: block;
}

.sidebar ul li a:hover {
    background:linear-gradient(102.57deg,#d0121e,#e41175 100%,#e41175 0); ;
    padding: 20px;
}


.content {
    margin-left: 250px;
    padding: 20px;
}
.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    color: #ddd;
    background-color: #495156;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  }
  
  h1 {
    text-align: center;
    margin-bottom: 30px;
    color: #ddd;
  }
  
  .job {
    background-color: #f9f9f9;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    position: relative;
  }
  
  .job h2 {
    margin-top: 0;
    color: #007bff;
  }
  .job h4 {
    margin-bottom: 10px;
    color: black;
  }
  .job p {
    margin-bottom: 10px;
  }
  
  .delete-job-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 5px;
    /* background-color: #dc3545; */
    background: linear-gradient(to right, #f32170, 
                    #ff6b08, #cf23cf, #eedd44);
                    -webkit-text-fill-color: transparent; 
            -webkit-background-clip: text;
    color: #fff;
    border: none;
     border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
  }
  
  /* .delete-job-btn:hover { */
    /* background-color: #c82333; */
  /* } */
  
  .add-job-btn {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background:linear-gradient(102.57deg,#d0121e,#e41175 100%,#e41175 0); 
    /* background: linear-gradient(to right, #f32170, 
                    #ff6b08, #cf23cf, #eedd44);
                    -webkit-text-fill-color: transparent; 
            -webkit-background-clip: text; */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
  }
  
  /* .add-job-btn:hover { */
    /* background-color: #0056b3; */
  /* } */
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #ddd;
    
  }
  input,textarea{
  border-color:#099FFF;
  border-radius:5px;
  overflow: scroll;
  }
  .submit-btn {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background:linear-gradient(102.57deg,#d0121e,#e41175 100%,#e41175 0); 
    /* background: linear-gradient(to right, #f32170, 
                    #ff6b08, #cf23cf, #eedd44);
                    -webkit-text-fill-color: transparent; 
            -webkit-background-clip: text; */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
  }

  
  /*button[type="submit"] {
    display: block;
    margin-top: 10px;
    padding: 10px 20px;
    background:linear-gradient(102.57deg,#d0121e,#e41175 100%,#e41175 0); 
    /* background-color: #28a745;  */
    /*background-color: linear-gradient(to right, #f32170, 
                    #ff6b08, #cf23cf, #eedd44);
                    -webkit-text-fill-color: transparent; 
            -webkit-background-clip: text;*/
    /*color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
  }*/
   

  /* button[type="submit"]:hover { */
    /* background-color: #218838;  */
  /* } */
  #submit{
    background:linear-gradient(102.57deg,#d0121e,#e41175 100%,#e41175 0); 
    color: white;

            
  }

    </style>
</head>
<body>

<div class="sidebar">
<h2>Dashboard</h2>
    <ul>
    <li><a href="a.php">Home</a></li>
        <li><a href="account.php">Account</a></li>
        <li><a href="application.php">Applications</a></li>
        
        <li><a href="help.php">Help</a></li>
        <li><a href="logout.php">Log out</a></li>
        <li><a href="posted_jobs.php">Posted Jobs</a></li>

    </ul>
  
</div>

<div class="content">
    <h2>Home</h2>
    <p>Welcome to your dashboard.</p>
</div>

<div class="container">
    <h1>Job Board</h1>
    <button class="add-job-btn" onclick="showForm()">Add Job</button>
    <form id="jobForm" style="display: none;" method="post">
    <div>
            <label for="companyname">Company Name:</label>
            <input type="text" id="companyname" name="companyname" required>
        </div>
        <br>
        <div>
            <label for="jobtitle">Job Title:</label>
            <input type="text" id="jobtitle" name="jobtitle" required>
        </div>
        <br>
        <div>
            <label for="salary">Salary:</label>
            <input type="text" id="salary" name="salary" required>
        </div>
        <br>
        <div>
            <label for="experience">Experience:</label>
            <input type="number" id="experience" name="experience" required>
        </div>
        <br>
        <div>
            <label for="description">Job Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <br>
        <button type="submit" id="submit" name="submit">Submit</button>
    </form>
</div>

<script>
    function showForm() {
        document.getElementById("jobForm").style.display = "block";
    }

    function deleteJob(element) {
        element.parentNode.remove();
    }
</script>

</body>
</html>
