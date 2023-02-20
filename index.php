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
$personal_name = $row['name'];
$personal_number = $row['phone_number'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whale Enterprises Pvt Ltd</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/profile.css">
    <link rel="icon" type="image/x-icon" href="./assets/logo.png">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
</head>
<style>
    .container {
        display: none;
        position: fixed;
        z-index: 8;
        left: 0;
        top: -25vh;
        width: 100vw;
        height: 119vh;
        overflow: hidden;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        color: #171717;
        padding-top: 38vh;
        overflow-x: hidden;
    }

    .form-group label {
        background-color: indigo;
        color: white;
        padding: 0.5rem;
        font-family: sans-serif;
        border-radius: 0.3rem;
        cursor: pointer;
        margin-top: 1rem;
        color: #fff;
    }

    @media only screen and (max-width: 500px) {
        .contact-form {
            max-width: 80vw;
            margin: auto;
        }

    }
</style>

<body>
    <!-- partial:index.partial.html -->
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
                <li><a href="#home" style="color:#fff" class="active">Home</a></li>
                <li><a href="view-only.php">Documents</a></li>
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
                <li><a href="#home" style="color:#fff" class="active">Home</a></li>
                <li><a href="view-only.php">Documents</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php" class="join-button">Logout</a></li>
            </ul>
        </nav>
    <?php } ?>
    <section id="home" class="section">
        <h3 class="admin-sectors-title">Sectors for You</h3>
        <div class="overall">
            <form action="view-only.php" method="POST">
                <input type="hidden" name="sector-1" value="Parts">
                <button name="parts-btn">
                    <div class="main blue-border">
                        <div id="parts" class="out_body"></div>
                        <p>Parts</p>
                    </div>
                </button>
            </form>
            <form action="view-only.php" method="POST">
                <input type="hidden" name="sector-2" value="Fabrication">
                <button name="tankers-btn">
                    <div class="main green-border">
                        <div id="tankers" class="out_body"></div>
                        <p>Fabrication</p>
                    </div>
                </button>
            </form>

            <form action="view-only.php" method="POST">
                <input type="hidden" name="sector-3" value="New Product Development">
                <button name="npd-btn">
                    <div class="main violet-border">
                        <div id="npd" class="out_body"></div>
                        <p>New Product Development</p>
                    </div>
                </button>
            </form>

            <form action="view-only.php" method="POST">
                <input type="hidden" name="sector-4" value="Machine Shop">
                <button name="machine-btn">
                    <div class="main light-blue-border">
                        <div id="machine" class="out_body"></div>
                        <p>Machine Shop</p>
                    </div>
                </button>
            </form>
        </div>
        <?php
        if (trim($admin) != 'User') { ?>
            <button class="admin-upload-documents button" data-modal="modalOne"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp; Upload New Documents</button>
        <?php }
        if ($personal_number == null or $personal_name == null) { ?>
            <p style='margin:10vh 0vh 10vh 0vh;font-family:Montserrat;text-align:center; color:red; border-image:none;border:none;'>Kindly fill your details in <a style="font-family: Montserrat;" href='./profile.php'>profile</a></p>
        <?php } ?>
        <div id="modalOne" class="container">
            <div class="modal-content">
                <div class="contact-form">
                    <a class="close">&times;</a>
                    <form action="action.php" method="post" enctype="multipart/form-data">
                        <h1>Upload Documents</h1>
                        <div class="form-input py-2">
                            <div class="form-group">
                                <input type="text" class="form-control" name="d_no" placeholder="Enter Drawing Number" required>
                            </div>
                            <br />
                            <div class="form-group">
                                <input type="text" class="form-control" name="r_no" placeholder="Enter Revision Number" required>
                            </div>
                            <br />

                            <div class="form-group">
                                <input type="text" class="form-control" name="desc" placeholder="Description" required>
                            </div>
                            <br />

                            <div class="form-group">
                                <select class="form-control" name="sector" id="sector" required>
                                    <option value="Not Selected">-- SELECT --</option>
                                    <?php
                                    $sector_sql = "SELECT * FROM `sectors` WHERE username = '$username'";
                                    $sector_result = mysqli_query($link, $sector_sql);
                                    $multi_sector = array();
                                    while ($sector_row = mysqli_fetch_assoc($sector_result)) {
                                        $sector = array_push($multi_sector, $sector_row['sector']);
                                    }
                                    $length = count($multi_sector);
                                    for ($i = 0; $i < $length; $i++) {
                                    ?>
                                        <option value="<?php echo $multi_sector[$i] ?>"><?php echo $multi_sector[$i] ?></option>
                                    <?php
                                        unset($multi_sector[$i]);
                                    } ?>
                                </select>
                            </div>
                            <br />
                            <div class="form-group">
                                <input type="file" name="file" class="form-control" title="Upload PDF" id="actual-btn" hidden required />
                                <label for="actual-btn">Choose File</label>
                                <span id="file-chosen">No file chosen</span>
                            </div>
                            <br />

                            <div style="display:flex;align-items:center; justify-content:center;" class="form-group">
                                <input type="submit" class="btnRegister" name="submit" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if (isset($_COOKIE['status'])) {
            printf("<center><p style='color:green;'>" . $_COOKIE['status'] . "</p></center>");
        }
        ?>
    </section>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/ScrollTrigger.min.js"></script>

    <script type="text/javascript">
        gsap.to(".filled-text, .outline-text", {
            scrollTrigger: {
                trigger: ".filled-text, .outline-text",
                start: "top bottom",
                end: "bottom top",
                scrub: 1
            },
            x: 200
        })

        gsap.to(".scroll-image", {
            scrollTrigger: {
                trigger: ".scroll-image",
                start: "top bottom",
                end: "bottom top",
                scrub: 1,
            },
            x: -250,
        })
    </script>
    <script>
        let modalBtns = [...document.querySelectorAll(".button")];
        modalBtns.forEach(function(btn) {
            btn.onclick = function() {
                let modal = btn.getAttribute("data-modal");
                document.getElementById(modal).style.display = "block";
            };
        });
        let closeBtns = [...document.querySelectorAll(".close")];
        closeBtns.forEach(function(btn) {
            btn.onclick = function() {
                let modal = btn.closest(".container");
                modal.style.display = "none";
            };
        });
        window.onclick = function(event) {
            if (event.target.className === "container") {
                event.target.style.display = "none";
            }
        };
    </script>
    <!-- partial -->
    <script src="./js/script.js"></script>
    <script src="./js/nav.js"></script>

    <script language="javascript">
        var noPrint = true;
        var noCopy = true;
        var noScreenshot = true;
        var autoBlur = false;

        const actualBtn = document.getElementById('actual-btn');

        const fileChosen = document.getElementById('file-chosen');

        actualBtn.addEventListener('change', function() {
            fileChosen.textContent = this.files[0].name
        })
    </script>
    <script type="text/javascript" src="https://pdfanticopy.com/noprint.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</body>