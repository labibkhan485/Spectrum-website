<?php
session_start();        // start session
session_unset();        // remove all session variables
session_destroy();      // destroy the session completely

// redirect to login page
header("Location: LogIn.php");
exit;
?>
