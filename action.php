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
$sql = "SELECT * FROM student_details Where email IN ('$username')";

if (isset($_POST['submit'])) {
    $pname = $_FILES["file"]['name'];
    $tname = $_FILES["files"]["tmp_name"];
    $upload_dir = './uploads';
    move_uploaded_file($tname, $upload_dir . '/' . $pname);
    $d_no  = $_POST['d_no'];
    $r_no  = $_POST['r_no'];
    $desc  = $_POST['desc'];
    $sector  = $_POST['sector'];

    if (is_uploaded_file($_FILES["file"]["tmp_name"]) && ($_FILES["file"]["type"] == 'application/pdf')) {
        echo "file is valid";
        #retrieve file title
        $title = $_POST["title"];
        #file name with a random number so that similar dont get replaced
        $pname = $_FILES["file"]["name"];
        #temporary file name to store file
        $tname = $_FILES["file"]["tmp_name"];
        #upload directory path
        $uploads_dir = 'uploads';
        #TO move the uploaded file to specific location
        move_uploaded_file($tname, $uploads_dir . '/' . $pname);
        #sql query to insert into database
        $sql = "INSERT INTO software_model(drawing_number, revision_number, description, file, sector) VALUES ('$d_no', '$r_no', '$desc', '$pname', '$sector')";
        if (mysqli_query($link, $sql)) {
            setcookie("status", "Successfully Uploaded!", time() + (7), "/");
            echo "<center><p style='color:green';>Successfully Uploaded!</p></center>";
        } else {
            setcookie("status", "Upload Failed!", time() + (7), "/");
            echo "<center><p style='color:red';>Upload Failed!</p></center>";
        }
    } else {
        echo "file is not valid type";
    }
    header('Location: index.php');
}

if (isset($_POST['delete-user'])) {
    $emp_username = $_POST['emp_username'];
    $sql = "DELETE FROM users WHERE username = '$emp_username'";
    if (mysqli_query($link, $sql)) {
        setcookie("status", "Successfully Deleted the Details of user : $emp_username", time() + (7), "/");
        echo "<center><p style='color:green';>Successfully Deleted the Details of user : $emp_username</p></center>";
    } else {
        setcookie("status", "Deletion Failed for the user : $emp_username.", time() + (7), "/");
        echo "<center><p style='color:red';>Deletion Failed for the user : $emp_username.</p></center>";
    }
    header('Location: useraccess.php');
}
if (isset($_POST['update-details'])) {
    $emp_name = $_POST['emp_name'];
    $emp_number = $_POST['emp_number'];
    $sector = $_POST['sector'];
    $privilege = $_POST['privilege'];
    $emp_username = $_POST['emp_username'];

    if ($privilege != '') {
        $sql = "UPDATE `whale_enterprises`.`users` SET name = '$emp_name', phone_number = '$emp_number', sector = '$sector', designation = '$privilege' where username = '$emp_username'";
    } else {
        $sql = "UPDATE `whale_enterprises`.`users` SET name = '$emp_name', phone_number = '$emp_number', sector = '$sector' where username = '$emp_username'";
    }
    echo $sql;
    if (mysqli_query($link, $sql)) {
        setcookie("status", "Successfully Updated the Details of user : $emp_username", time() + (7), "/");
        echo "<center><p style='color:green';>Successfully Updated the Details of user : $emp_username</p></center>";
    } else {
        setcookie("status", "Update Failed for the user : $emp_username.", time() + (7), "/");
        echo "<center><p style='color:red';>Update Failed for the user : $emp_username.</p></center>";
    }
    header('Location: useraccess.php');
}
if (isset($_POST['profile-update-details'])) {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $sql = "UPDATE `whale_enterprises`.`users` SET name = '$name', phone_number = '$phone_number' where username = '$username'";
    echo $sql;
    if (mysqli_query($link, $sql)) {
        setcookie("profile_status", "Successfully Updated the Details of user : $emp_username", time() + (7), "/");
        echo "<center><p style='color:green';>Successfully Updated the Details.</p></center>";
    } else {
        setcookie("profile_status", "Update Failed for the user : $emp_username.", time() + (7), "/");
        echo "<center><p style='color:red';>Update Failed.</p></center>";
    }
    header('Location: profile.php');
}
if (isset($_POST['delete-pdf-btn'])) {
    $file_name = $_POST['delete-pdf'];
    echo $filename;
    $path = "./uploads/";
    $file = $path . $file_name;
    echo $file;
    $status = unlink($file);
    if ($status) {
        echo "File deleted successfully";
        $sql = "DELETE from software_model WHERE file = '$file_name'";
        echo $sql;
        if (mysqli_query($link, $sql)) {
            setcookie("delete_status", "Successfully removed the file : $file_name", time() + (7), "/");
            echo "<center><p style='color:green';>Successfully Removed the File.</p></center>";
        } else {
            setcookie("delete_status", "Failed to remove the file : $file_name.", time() + (7), "/");
            echo "<center><p style='color:red';>Failed to remove the file</p></center>";
        }
    } else {
        echo "Sorry!";
    }

    header('Location: view-only.php');
}
