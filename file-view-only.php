<?php

include 'config.php';
require 'front-controller.php';

session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["whale_enterprises_loggedin"]) || $_SESSION["whale_enterprises_loggedin"] !== true) {
    header("location: login");
    exit;
}
$username = $_SESSION["username"];

error_reporting(0); // For not showing any error
$sql = "SELECT * FROM users Where username IN ('$username')";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$admin = trim($row['designation']);
$pdf = $_POST['filename'];
$path = "./uploads/";
$file = $path . $pdf;
$sector_filter = $_POST['sector'];

?>
<!DOCTYPE html>
<html lang="en">
<script>
    window.console = window.console || function(t) {};
</script>
<script>
    if (document.location.search.match(/type=embed/gi)) {
        window.parent.postMessage("resize", "*");
    }
</script>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whale Enterprises Pvt Ltd</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="icon" type="image/x-icon" href="./assets/logo.png">
    <script>
        alert("Do not take screenshot of this page");
    </script>
</head>
<style>
    body {
        background-color: #525659;
        color: #fff;
    }

    /* We are stopping user from
         printing our webpage */
    @media print {

        html,
        body {

            /* Hide the whole page */
            display: none !important;
        }

        .noprint {
            visibility: hidden !important;
        }
    }

    #element {
        display: block;
    }
</style>

<body class="noprint" oncontextmenu="return false;">
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
                <li><a href="index">Home</a></li>
                <li><a href="view-only" style="color:#fff" class="active">Documents</a></li>
                <li><a href="useraccess">User Details</a></li>
                <li><a href="profile">Profile</a></li>
                <li><a href="logout" class="join-button">Logout</a></li>
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
                <li><a href="index">Home</a></li>
                <li><a href="view-only" style="color:#fff" class="active">Documents</a></li>
                <li><a href="profile">Profile</a></li>
                <li><a href="logout" class="join-button">Logout</a></li>
            </ul>
        </nav>
    <?php } ?>
    <div id="element" class="view-pdf-overall">
        <?php
        $sql = "SELECT * FROM software_model WHERE file = '$pdf'";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <div style="padding-top:10vh;" class="flex-row column">
                    <div class="flex-row">
                        <p>Drawing Number: &nbsp;</p>
                        <p class="view-pdf-overall-db-content"><?php echo $row['drawing_number'] ?> &nbsp; &nbsp; &nbsp; &nbsp;</p>
                    </div>
                    <div class="flex-row">
                        <p>Revision Number: &nbsp; </p>
                        <p class="view-pdf-overall-db-content"><?php echo $row['revision_number'] ?> &nbsp; &nbsp; &nbsp; &nbsp;</p>
                    </div>
                    <div class="flex-row">
                        <p>Sector: &nbsp; </p>
                        <p class="view-pdf-overall-db-content"><?php echo $row['sector'] ?> &nbsp; &nbsp; &nbsp; &nbsp;</p>
                    </div>
                </div>
                <div class="flex-row">
                    <p>Description: &nbsp; </p>
                    <p class="view-pdf-overall-db-content"><?php echo $row['description'] ?></p>
                </div>
        <?php }
        } ?>

        <div class="wrapper">
            <iframe style="margin-top: 2vh;" src="<?php echo $file ?>#toolbar=0&amp;navpanes=0&amp;statusbar=0&readonly=true; disableprint=true;" width="100%" height="1500" frameborder="0"></iframe>
            <div class="embed-cover"></div>
        </div>
    </div>

    <script language="javascript">
        var noPrint = true;
        var noCopy = true;
        var noScreenshot = true;
        var autoBlur = false;
    </script>
    <script>
        document.onkeydown = function(e) {
            if (e.key === "Windows") {
                e.preventDefault();
            }
        };
        document.onkeydown = function(e) {
            if (e.key === "PrintScreen") {
                e.preventDefault();
            }
        };
        document.addEventListener("keydown", function(event) {
            if (event.key === "Meta" || event.key === "Win") {
                event.preventDefault();
            }
        });
        document.addEventListener("keydown", function(event) {
            if (event.key === "PrintScreen") {
                event.preventDefault();
            }
        });
        document.addEventListener("keydown", function() {
            document.getElementById("element").style.display = "none";
        });
        document.addEventListener("click", function() {
            document.getElementById("element").style.display = "block";
        });
    </script>
    <script>
        document.addEventListener("keyup", function(e) {
            var keyCode = e.keyCode ? e.keyCode : e.which;
            if (keyCode == 44) {
                stopPrntScr();
            }
        });

        function stopPrntScr() {

            var inpFld = document.createElement("input");
            inpFld.setAttribute("value", ".");
            inpFld.setAttribute("width", "0");
            inpFld.style.height = "0px";
            inpFld.style.width = "0px";
            inpFld.style.border = "0px";
            document.body.appendChild(inpFld);
            inpFld.select();
            document.execCommand("copy");
            inpFld.remove(inpFld);
        }

        function AccessClipboardData() {
            try {
                window.clipboardData.setData('text', "Access   Restricted");
            } catch (err) {}
        }
        setInterval("AccessClipboardData()", 300);
    </script>
    <script>
        // Get a reference to the element with the ID "element"
        const element = document.getElementById('element');

        // Add an event listener to the element to detect when the mouse leaves the element
        element.addEventListener('mouseleave', () => {
            // Blur the element's content
            element.style.filter = 'blur(12px)';
        });
        document.body.addEventListener('click', () => {
            // Remove the blur effect from the element's content
            element.style.filter = 'none';
        });
        // Get the element where you want to disable long press

        // Set the minimum duration of the key press in milliseconds
        var longPressDuration = 1000;

        // Create a variable to store the start time of the key press
        var pressStartTime;

        // Add a keydown event listener to the element
        element.addEventListener("keydown", function(event) {
            // Get the current time
            var currentTime = new Date().getTime();

            // If this is the first keydown event or the key has been released and pressed again
            if (!pressStartTime || (currentTime - pressStartTime) > longPressDuration) {
                // Set the press start time to the current time
                pressStartTime = currentTime;
            }
            // If the key has been held down for more than the long press duration
            else if ((currentTime - pressStartTime) > longPressDuration) {
                // Prevent the default behavior of the event
                event.preventDefault();
            }
        });
        // Add a keydown event listener to the document
        document.addEventListener('keydown', function(event) {
            // Check if the pressed key is the print screen key (keyCode 44)
            if (event.keyCode === 44) {
                // Prevent the default behavior of the key
                event.preventDefault();
                // Add a keyup event listener to the document
                document.addEventListener('keyup', function(event) {
                    // Check if the released key is the print screen key (keyCode 44)
                    if (event.keyCode === 44) {
                        // Remove the keyup event listener
                        document.removeEventListener('keyup', arguments.callee);
                    }
                });
            }
        });
        var timeoutId;

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                timeoutId = setTimeout(function() {
                    element.style.filter = 'blur(12px)';
                }, 1000); // Set a timeout of 1 second (1000 milliseconds)
            }
        });

        document.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                clearTimeout(timeoutId);
            }
        });
    </script>
    <script src="./js/nav.js"></script>
    <script type="text/javascript" src="https://pdfanticopy.com/noprint.js"></script>

</body>

</html>