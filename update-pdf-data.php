<?php

include 'config.php';

session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["whale_enterprises_loggedin"]) || $_SESSION["whale_enterprises_loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$username = $_SESSION["username"];
error_reporting(0); // For not showing any error
$sql = "SELECT * FROM users Where username IN ('$username')";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$admin = trim($row['designation']);
$file_name = $_POST["filename"];
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

    .select-dropdown {
        position: relative;
        height: 30px;
        width: 98%;
        border: 1px solid;
        border-image: linear-gradient(to right, #0c48db, #ffffff) 0 0 1 0%;
        background-color: #fff;
        font-size: 14px;
        font-family: "Roboto", sans-serif;
        margin-top: 0;
        padding-top: 0;
        top: -18px;
    }

    .select-dropdown__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 5px;
        cursor: pointer;

    }



    .select-dropdown__toggle {
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 5px 4px 0 4px;
        border-color: #333 transparent transparent transparent;
    }

    .select-dropdown__options {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid #ccc;
        border-top: none;
        display: none;
    }

    .select-dropdown__options label {
        display: block;
        padding: 5px 10px;
    }

    .select-dropdown__options input[type="checkbox"] {
        margin-right: 5px;
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
                <li><a href="view-only.php" style="color:#fff" class="active">Documents</a></li>
                <li><a href="#">User Details</a></li>
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
            $sql = "SELECT * FROM `software_model` WHERE `file` = '$file_name'";
            #echo $sql;
            $result = mysqli_query($link, $sql);
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="rightbox">
                    <div class="profile">
                        <h1>Update Details of <?php echo $row['drawing_number'] ?></h1>
                        <form action="action.php" method="post">
                            <label>Drawing Number</label>
                            <input type="text" class="form-control" name="drawing_number" placeholder="Enter Drawing Name" value="<?php echo $row['drawing_number'] ?>" required><br />
                            <label>Revision Number</label>
                            <input type="text" class="form-control" name="revision_number" placeholder="Enter Revision Number" value="<?php echo $row['revision_number'] ?>" required><br />
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" placeholder="Enter Description" value="<?php echo $row['description'] ?>" required><br />
                            <br />

                            <?php if (trim($admin) == 'SuperAdmin' or trim($admin) == 'Admin') { ?>
                                <input style="display:none" type="text" name="id" value="<?php echo $row['id'] ?>">
                                <input style="display:none" type="text" name="file" value="<?php echo $row['file'] ?>">
                                <input style="display:none" type="text" name="sector" value="<?php echo $row['sector'] ?>">
                                <div class="flex-row">
                                    <button type="submit" class="btnRegister" name="update-pdf-details" onclick="return confirm('Are you sure you want to Submit?')" value="Submit">Update</button>
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

<script src="./js/script.js"></script>
<script language="javascript">
    var noPrint = true;
    var noCopy = true;
    var noScreenshot = true;
    var autoBlur = false;
</script>
<script type="text/javascript" src="https://pdfanticopy.com/noprint.js"></script>

</html>