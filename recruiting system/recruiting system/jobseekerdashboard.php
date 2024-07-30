<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Recruitment System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Style for navigation bar */
        body{
            background-color:black;
        }
        .container {
            font-family: apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,Liberation Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;

            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color:#343a40;
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(102.57deg,#d0121e,#e41175 100%);
            padding: 15px 20px;
            color: #f2f2f2;
        }

        /*.navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 20px 20px;
            text-decoration: none;
        }*/
        /*.navbar a, .search-icon {
            color: #f2f2f2;
            text-align: center;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
        }*/
        .navbar-left, .navbar-right {
            display: flex;
            align-items: center;
        }
        .navbar a, .search-icon {
            margin-right: 30px;
            padding: 10px 20px;
            color: #ddd;
            text-decoration: none;
        }


        .navbar-left a:hover,.search-icon:hover {
            background-color: #ccc;
            border-radius: 5px;
            color: #d0121e;
        }

        /* Style for job list */
        .job-list {
            list-style-type: none;
            padding: 0;
        }

        .job-item {
            margin-bottom: 20px;
            text-align: left;
        }

        .job-title {
            font-weight: bold;
            font-size: 18px;
        }

        .job-description {
            margin-top: 5px;
        }

        .apply-btn {
            background: linear-gradient(102.57deg,#d0121e,#e41175 100%,#e41175 0);

            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transform: all 0.5s;
        }

        .apply-btn:hover {
            box-shadow: 0 0 20px #e41175;
        }

        .container {
            text-align: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .user-profile img {
            width: 25px;
            height: 25px;
            margin-right: 10px;
        }
        .popup-menu {
            display: none;
            position: absolute;
            background-color: #333;
            padding: 10px;
            border-radius: 5px;
            top: 40px;
            right: 0;
            z-index: 1;
        }

        .menu-item:hover {
            color: #e41175;
            cursor: pointer;
        }

        /*.popup-menu .menu-item:hover 
        {background-color: beige; }
        */
        .popup-menu a{
            text-decoration: none;
        }
        /*.search-container {
            display: none;
            position: relative;
        }

        .search-box {
            width: 100%;
            padding: 10px;
            margin-top: 2px;
            border: none;
            border-radius: 5px;
        }*/
        .search-container {
            display: none;
            position: relative;
            align-items: center;
        }
        .search-box {
            width: 250px; /* Increased width */
            padding: 10px;
            border: 2px solid black;
            border-radius: 5px;
            margin-left: -20px; /* Adjust as necessary */
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <a href="a.php">Home</a>
            <a href="">My Application Form</a>
            <a href="currentjobs.php">Current Jobs</a>
            <a href="contact.html">Contact</a>
            <a href="appled for.php">Applied For</a>
            <div class="search-icon"><i class="fas fa-search"></i></div>
            <div class="search-container">
                <input type="text" class="search-box" placeholder="Search...">
            </div>
        </div>
        <div class="navbar-right">
            <div class="user-profile" id="userProfile">
                <img src="https://pluspng.com/img-png/png-user-icon-circled-user-icon-2240.png" alt="usericon">
                <div class="user-name">Profile</div>
                <div class="popup-menu" id="popupMenu">
                    <a href="account1.php"><div class="menu-item">View Profile</div></a>
                    <a href="logout1.php"><div class="menu-item" id="logout">Logout</div></a>
                </div>
            </div>
    
    
    
    
        
    </div>
</div>
<section id="currentjobs">
<div class="container">
    <h2>Current Job Opportunities</h2>
    <ul class="job-list">
    <?php
// Include database connection file
include 'database.php';

// Fetch job details from the database
$sql = "SELECT * FROM jobdescription";
$result = mysqli_query($conn, $sql);

// Check if there are any jobs in the database
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<h2>' . $row['jobtitle'] . '</h2>';
        echo '<h4>Company: ' . $row['companyname'] . '</h4>';
        echo '<p>Salary: ' . $row['salary'] . '</p>';
        echo '<p>Experience: ' . $row['experience'] . '</p>';
        echo '<p>Description: ' . $row['description'] . '</p>';
        // Form with hidden input for job_id
        echo '<form action="apply_job.php" method="post">';
        echo '<input type="hidden" name="job_id" value="' . $row['id'] . '">';
        echo '<button type="submit" class="apply-job-btn">Apply Job</button>';
        echo '</form>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p>No jobs found.</p>';
}

// Close database connection
mysqli_close($conn);
?>
</ul>
</div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var userProfile = document.getElementById("userProfile");
        var popupMenu = document.getElementById("popupMenu");

        userProfile.addEventListener("click", function(event) {
            event.stopPropagation(); // Prevents the click event from propagating to the document

            // Toggle display of the popup menu
            if (popupMenu.style.display === "block") {
                popupMenu.style.display = "none";
            } else {
                popupMenu.style.display = "block";
            }
        });

        // Close the popup menu when clicking outside of it
        

        // Logout functionality
        
    });
    document.addEventListener("DOMContentLoaded", function() {
    var searchIcon = document.querySelector(".search-icon");
    var searchContainer = document.querySelector(".search-container");

    searchIcon.addEventListener("click", function() {
        if (searchContainer.style.display === "flex") {
            searchContainer.style.display = "none";
        } else {
            searchContainer.style.display = "flex";
        }
    });

    // User profile and logout script unchanged
});


</script>

</body>
</html>
