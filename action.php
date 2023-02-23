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

function myfunction($a, $b)
{
    if ($a === $b) {
        return 0;
    }
    return ($a > $b) ? 1 : -1;
}


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
        #sql query to insert into database
        $check_file_sql = "SELECT * FROM `software_model` WHERE drawing_number = '$d_no' and revision_number = '$r_no'";
        $check_file_result = mysqli_query($link, $check_file_sql);
        if (mysqli_num_rows($check_file_result) > 0) {
            $check_file_row = mysqli_fetch_assoc($check_file_result);
            $file_path_name = $check_file_row['file'];
            echo $file_path_name;
            $file_path = $uploads_dir . '/' . $file_path_name; // Replace with the actual file path
            echo $file_path;
            if (file_exists($file_path)) {
                if (unlink($file_path)) {
                    echo "File deleted successfully.";
                } else {
                    echo "Unable to delete the file.";
                }
            } else {
                echo "File not found.";
            }
            move_uploaded_file($tname, $uploads_dir . '/' . $pname);
            echo "<br/>";
            $sql = "UPDATE `whale_enterprises`.`software_model` SET sector = '$sector' WHERE drawing_number = '$d_no' and revision_number = '$r_no'";
            echo $sql;
            $result = mysqli_query($link, $sql);
            echo "<br/>";
            $sql = "UPDATE `whale_enterprises`.`software_model` SET `file` = '$pname' WHERE drawing_number = '$d_no' and revision_number = '$r_no'";
            echo $sql;
            echo "<br/>";
            $result = mysqli_query($link, $sql);
            $sql = "UPDATE `whale_enterprises`.`software_model` SET `description` = '$desc' WHERE drawing_number = '$d_no' and revision_number = '$r_no'";
            echo $sql;
            if (mysqli_query($link, $sql)) {
                setcookie("status", "Successfully Updated!", time() + (7), "/");
                echo "<center><p style='color:green';>Successfully Updated!</p></center>";
            } else {
                setcookie("status", "Update Failed!", time() + (7), "/");
                echo "<center><p style='color:red';>Update Failed!</p></center>";
            }
        } else {
            $sql = "INSERT INTO software_model(drawing_number, revision_number, 'description', `file`, sector) VALUES ('$d_no', '$r_no', '$desc', '$pname', '$sector')";
            echo $sql;
            if (mysqli_query($link, $sql)) {
                setcookie("status", "Successfully Uploaded!", time() + (7), "/");
                echo "<center><p style='color:green';>Successfully Uploaded!</p></center>";
            } else {
                setcookie("status", "Upload Failed!", time() + (7), "/");
                echo "<center><p style='color:red';>Upload Failed!</p></center>";
            }
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
    $privilege = trim($_POST['privilege']);
    $emp_username = $_POST['emp_username'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // retrieve the selected values from the form data
        $selectedOptions = $_POST['selectedOptions'];
        // process the selected values as needed
        var_dump($selectedOptions);

        $length = count($selectedOptions);
    }

    $sector_sql = "DELETE FROM `sectors` WHERE username = '$emp_username'";
    echo $sector_sql;
    $sector_result = mysqli_query($link, $sector_sql);
    for ($i = 0; $i < $length; $i++) {
        $sql = "INSERT INTO `sectors` (username, sector) VALUES ('$emp_username', '$selectedOptions[$i]')";
        mysqli_query($link, $sql);
    }

    if ($privilege != '') {
        $update_sql = "UPDATE `whale_enterprises`.`users` SET name = '$emp_name', phone_number = '$emp_number', designation = '$privilege' where username = '$emp_username'";
    } else {
        $update_sql = "UPDATE `whale_enterprises`.`users` SET name = '$emp_name', phone_number = '$emp_number' where username = '$emp_username'";
    }
    echo $update_sql;
    if (mysqli_query($link, $update_sql)) {
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
