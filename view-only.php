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

$search_username = $row['username'];
$sector_sql = "SELECT * FROM `sectors` WHERE username = '$username'";
$sector_result = mysqli_query($link, $sector_sql);
$multi_sector = array();
while ($sector_row = mysqli_fetch_assoc($sector_result)) {
    array_push($multi_sector, $sector_row['sector']);
}
$length = count($multi_sector);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whale Enterprises Pvt Ltd</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="icon" type="image/x-icon" href="./assets/logo.png">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="./js/script.js"></script>
</head>
<style>
    body {
        background: linear-gradient(to right, #ecf0fb, #f5f6f8);
    }

    .rwd-table {
        transform: scale(.95);
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
                <li><a href="#" style="color:#fff" class="active">Documents</a></li>
                <li><a href="useraccess.php" class="">User Details</a></li>
                <li><a href="profile.php" class="">Profile</a></li>
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
                <li><a href="#" style="color:#fff" class="active">Documents</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php" class="join-button">Logout</a></li>
            </ul>
        </nav>
    <?php } ?>
    <section class="pdflist">
        <h1>View the Documents </h1>
        <div class="search-box">
            <form class="search-box" action="" method="post">
                <input class="search-bar" type="text" name="filter-value" placeholder="Search Here!" />
                <button name="filter" class="search_details">Search</button>
            </form>
        </div>
        <table class="rwd-table">
            <tbody>
                <tr>
                    <th>S.No</th>
                    <th>Drawing Number</th>
                    <th>Revision Number</th>
                    <th>Description</th>
                    <th>Sector</th>
                    <th>File</th>
                    <th> </th>
                </tr>
                <?php
                if (isset($_POST['filter'])) {
                    $s_no = 1;
                    $value_filter = $_POST['filter-value'];
                    for ($i = 0; $i < $length; $i++) {
                        if ($sector == '') {
                            $search_sql = "SELECT * from software_model where CONCAT(drawing_number, revision_number,`sector`, `description`, `file`) LIKE '%$value_filter%' and sector = '$multi_sector[$i]'";
                            unset($multi_sector[$i]);
                        }
                        if ($sector != '') {
                            $search_sql = "SELECT * from software_model where CONCAT(drawing_number, revision_number,`sector`, `description`, `file`) LIKE '%$value_filter%' and sector = '$sector';";
                        }
                        $search_result = mysqli_query($link, $search_sql);
                        if (mysqli_num_rows($search_result) > 0) {
                            while ($search_row = mysqli_fetch_assoc($search_result)) { ?>
                                <tr id='display'>
                                    <td data-th="S.No">
                                        <?php echo $s_no;
                                        $s_no += 1; ?>
                                    </td>
                                    <td data-th="Drawing Number">
                                        <?php echo $search_row['drawing_number']; ?>
                                    </td>
                                    <td data-th="Revision Numebr">
                                        <?php echo $search_row['revision_number']; ?>
                                    </td>
                                    <td data-th="Description">
                                        <?php echo $search_row['description']; ?>

                                    </td>
                                    <td data-th="Sector">
                                        <?php echo $search_row['sector']; ?>
                                    </td>
                                    <td data-th="File">
                                        <?php echo $search_row['file']; ?>
                                    </td>
                                    <td style='display:flex; flex-direction:row;' data-th="">
                                        <form action="file-view-only.php" method='POST' class="table-forms">
                                            <input type="hidden" name="filename" value="<?php echo $search_row['file']; ?>" />
                                            <button type="submit" class="update_details" name="view-pdf">View</button>
                                        </form>
                                        <?php if (trim($admin) == 'SuperAdmin' or trim($admin) == 'Admin') { ?>
                                            <form action="action.php" method='POST' class="table-forms">
                                                <input type="hidden" name="delete-pdf" value="<?php echo $search_row['file']; ?>" />
                                                <button type="submit" onclick="return confirm('Are you sure you want to Delete?')" class="update_details red" name="delete-pdf-btn">Delete</button>
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else { ?>
                            <tr id='display'>
                            </tr>
                            <?php
                        }
                    }
                }
                if (isset($_POST['filter']) == false) {
                    for ($i = 0; $i < $length; $i++) {
                        if ($sector == '') {
                            $sql = "SELECT * FROM software_model WHERE sector='$multi_sector[$i]' ORDER BY id DESC";
                            $result = mysqli_query($link, $sql);
                            unset($multi_sector[$i]);
                        }
                        if ($sector != '') {
                            $sql = "SELECT * FROM software_model WHERE sector='$sector' ORDER BY id DESC";
                            $result = mysqli_query($link, $sql);
                            unset($multi_sector[$i]);
                        }
                        if (mysqli_num_rows($result) > 0) {
                            $s_no = 1;
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr id='display'>
                                    <td data-th="S.No">
                                        <?php echo $s_no;
                                        $s_no += 1; ?>
                                    </td>
                                    <td data-th="Drawing Number">
                                        <?php echo $row['drawing_number']; ?>
                                    </td>
                                    <td data-th="Revision Number">
                                        <?php echo $row['revision_number']; ?>
                                    </td>
                                    <td data-th="Description">
                                        <?php echo $row['description']; ?>

                                    </td>
                                    <td data-th="Sector">
                                        <?php echo $row['sector']; ?>
                                    </td>
                                    <td data-th="File">
                                        <?php echo $row['file']; ?>
                                    </td>
                                    <td style='display:flex; flex-direction:row;' data-th="">
                                        <form action="file-view-only.php" method='POST' class="table-forms">
                                            <input type="hidden" name="filename" value="<?php echo $row['file']; ?>" />
                                            <button type="submit" class="update_details button" data-modal="modalOne" name="view-pdf">View</button>
                                        </form>
                                        <?php if (trim($admin) == 'SuperAdmin' or trim($admin) == 'Admin') { ?>
                                            <form action="action.php" method='POST' class="table-forms">
                                                <input type="hidden" name="delete-pdf" value="<?php echo $row['file']; ?>" />
                                                <button type="submit" onclick="return confirm('Are you sure you want to Delete?')" class="update_details red" name="delete-pdf-btn">Delete</button>
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr id='display'>

                            </tr>
                <?php
                        }
                    }
                } ?>
            </tbody>
        </table>
    </section>
</body>
<script src="./js/nav.js"></script>

</html>