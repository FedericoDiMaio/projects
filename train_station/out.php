<?php
    session_start();
    session_destroy();
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires:0');
    header('location: ./landing.php');
    exit();
?>