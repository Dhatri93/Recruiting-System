<?php
session_start();

include 'database.php'; 


if (!isset($_SESSION['user'])) {
    header("Location: login.php"); 
    exit;
}


$sql = "SELECT * FROM jobdescription";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posted Jobs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }

        .job-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .job-card {
            width: calc(33.33% - 20px); 
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .job-card h2 {
            margin-top: 0;
            color: #007bff;
        }

        .job-card h4 {
            margin-bottom: 10px;
            color: black;
        }

        .job-card p {
            margin-bottom: 10px;
        }

        .delete-job-btn {
            padding: 5px 10px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .delete-job-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<h1>Posted Jobs</h1>

<?php
if (mysqli_num_rows($result) > 0) {
    echo '<div class="job-container">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="job-card" id="job_' . $row['id'] . '">';
        echo '<h2>' . $row['jobtitle'] . '</h2>';
        echo '<h4>Company: ' . $row['companyname'] . '</h4>';
        echo '<p>Salary: ' . $row['salary'] . '</p>';
        echo '<p>Experience: ' . $row['experience'] . '</p>';
        echo '<p>Description: ' . $row['description'] . '</p>';
        echo '<button class="delete-job-btn" onclick="deleteJob(' . $row['id'] . ')">Delete</button>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "No posted jobs found.";
}
?>

<script>
    function deleteJob(jobId) {
        if (confirm("Are you sure you want to delete this job?")) {
        
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_job.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    
                    var jobCard = document.getElementById("job_" + jobId);
                    if (jobCard) {
                        jobCard.remove();
                    }
                }
            };
            xhr.send("job_id=" + jobId);
        }
    }
</script>

</body>
</html>
