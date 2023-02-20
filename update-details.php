<?php

include 'config.php';

session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["whale_enterprises_loggedin"]) || $_SESSION["whale_enterprises_loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$username = $_SESSION["username"];
$userid = $_POST["userid"];
error_reporting(0); // For not showing any error
$sql = "SELECT * FROM users Where username IN ('$username')";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$admin = trim($row['designation']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whale Enterprises Pvt Ltd</title>
    <link rel="stylesheet" href="./css/profile.css">
    <link rel="icon" type="image/x-icon" href="./assets/logo.png">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.10/css/all.css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>
<style>
    form {
        display: flex !important;
        flex-direction: column;
        width: 70%;
        margin-top: 5.2vh;
        justify-content: space-between;
    }

    body {
        max-height: 100vh !important;
    }
</style>

<body>
    <?php if (trim($admin) == 'SuperAdmin' or trim($admin) == 'Admin') { ?>
        <nav>
            <div class="logo">
                <img class="logo-c" src=".\assets\logo.png">
                <h1>Whale Enterprises Pvt Ltd.</h1>
            </div>
            <div class="hamburger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="view-only.php">Documents</a></li>
                <li><a href="useraccess.php" style="color:#fff" class="active">User Details</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php" class="join-button">Logout</a></li>
            </ul>
        </nav>
    <?php }
    if (trim($admin) == 'User') { ?>

        <nav>
            <div class="logo">
                <img class="logo-c" src=".\assets\logo.png">
                <h1>Whale Enterprises Pvt Ltd.</h1>
            </div>
            <div class="hamburger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="view-only.php">Documents</a></li>
                <li><a href="useraccess.php" style="color:#fff" class="active">User Details</a></li>
                <li><a href="profile.php" class="">Profile</a></li>
                <li><a href="logout.php" class="join-button">Logout</a></li>
            </ul>
        </nav>
    <?php } ?>
    <!-- partial:index.partial.html -->
    <section class="over-all-box">
        <div class="container margin_top">
            <div id="logoo">
                <h1 class="logoo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
            </div>
            <?php
            $sql = "SELECT * FROM users WHERE username = '$userid'";
            $result = mysqli_query($link, $sql);
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="rightbox">
                    <div class="profile">
                        <h1>Update Details of <?php echo $row['name'] ?></h1>
                        <form action="action.php" method="post">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="emp_name" placeholder="Enter Employee Name" value="<?php echo $row['name'] ?>" required><br />
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="emp_number" placeholder="Enter Phone Number" value="<?php echo $row['phone_number'] ?>" required><br />
                            <label>Sector</label>
                            <select class="form-control" name="sector" id="sector">
                                <option value=" <?php echo $row['sector'] ?>"><?php echo $row['sector'] ?></option>
                                <option value="Fabrication">Fabrication</option>
                                <option value="Parts">Parts</option>
                                <option value="New Product Development">New Product Development</option>
                                <option value="Machine Shop">Machine Shop</option>
                            </select><br />
                            <?php if (trim($admin) == 'SuperAdmin') { ?>
                                <label>privilege</label>
                                <select class="form-control" name="privilege" id="privilege">
                                    <option value=" <?php echo $row['designation'] ?>"><?php echo $row['designation'] ?></option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select><br />
                                <input type="hidden" name="emp_username" value="<?php echo $row['username'] ?>">
                                <div class="flex-row">
                                    <button type="submit" class="btnRegister" name="update-details" onclick="return confirm('Are you sure you want to Submit?')" value="Submit">Update</button>
                                    <button type="submit" class="btnRegister delete" onclick="return confirm('Are you sure you want to Delete?')" name="delete-user">Delete</button>
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                <?php
            }
                ?>
                </div>
        </div>
    </section>
    <!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src="./js/script.js"></script>
    <script src="./js/nav.js"></script>


</body>


</html>