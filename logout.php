<?php
// Initialize the session
session_start();
require 'front-controller.php';
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: index");
exit;
