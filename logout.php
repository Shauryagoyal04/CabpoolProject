<?php
session_start();

// Check if the session is active before destroying it
if (session_status() === PHP_SESSION_ACTIVE) {
    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: login.php");
    exit();
} else {
    echo "Session is not active. Unable to log out.";
    exit();
}