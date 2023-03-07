<?php

include 'config.php';
require 'front-controller.php';

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

    #canvas_container {
        text-align: center;
        margin-top: 2vh;
    }

    .pdf-controls {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }

    .pdf-controls button {
        width: fit-content;
        padding: 5px;
        height: 30px;
        background-color: #fff;
        color: #000;
        margin: 5px;
        border-color: 0px;
        border-radius: 5px;
        cursor: pointer;
    }

    body {
        position: relative;
    }

    body::after {
        content: "<?php echo $username ?>";
        font-size: 5em;
        font-weight: bold;
        color: #ccc;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        pointer-events: none;
        z-index: 2;
        opacity: 0.2;
    }

    @media screen and (max-width: 960px) {
        body::after {
            top: 65%;
            font-size: 2em;
        }
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
                <li><a href="index.php">Home</a></li>
                <li><a href="view-only.php" style="color:#fff" class="active">Documents</a></li>
                <li><a href="useraccess.php">User Details</a></li>
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
                <li><a href="view-only.php" style="color:#fff" class="active">Documents</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php" class="join-button">Logout</a></li>
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
        <div id="my_pdf_viewer">
            <div id="canvas_container">
                <canvas id="pdf_renderer"></canvas>
            </div>
            <div class="pdf-controls" id="navigation_controls">
                <button id="go_previous">Previous</button>
                <button id="go_next">Next</button>
                <div id="zoom_controls">
                    <button id="zoom_in">Zoom In</button>
                    <button id="zoom_out">Zoom Out</button>
                </div>
                <input id="current_page" value="1" type="hidden" />
            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
<script>
    var myState = {
        pdf: null,
        currentPage: 1,
        zoom: 1.2
    }

    pdfjsLib.getDocument('<?php echo $file ?>').then((pdf) => {

        myState.pdf = pdf;
        render();

    });

    function render() {
        myState.pdf.getPage(myState.currentPage).then((page) => {

            var canvas = document.getElementById("pdf_renderer");
            var ctx = canvas.getContext('2d');

            var viewport = page.getViewport(myState.zoom);
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            page.render({
                canvasContext: ctx,
                viewport: viewport
            });
        });
    }

    document.getElementById('go_previous')
        .addEventListener('click', (e) => {
            if (myState.pdf == null || myState.currentPage == 1)
                return;

            myState.currentPage -= 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
        });
    document.getElementById('go_next')
        .addEventListener('click', (e) => {
            if (myState.pdf == null || myState.currentPage > myState.pdf._pdfInfo.numPages)
                return;

            myState.currentPage += 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
        });
    document.getElementById('current_page')
        .addEventListener('keypress', (e) => {
            if (myState.pdf == null) return;

            // Get key code
            var code = (e.keyCode ? e.keyCode : e.which);

            // If key code matches that of the Enter key
            if (code == 13) {
                var desiredPage = document.getElementById('current_page').valueAsNumber;

                if (desiredPage >= 1 && desiredPage <= myState.pdf._pdfInfo.numPages) {
                    myState.currentPage = desiredPage;
                    document.getElementById("current_page").value = desiredPage;
                    render();
                }
            }
        });
    document.getElementById('zoom_in')
        .addEventListener('click', (e) => {
            if (myState.pdf == null) return;
            myState.zoom += 0.5;
            render();
        });
    document.getElementById('zoom_out')
        .addEventListener('click', (e) => {
            if (myState.pdf == null) return;
            myState.zoom -= 0.5;

            render();
        });
</script>



</html>