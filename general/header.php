<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['msg']))
    {
        echo '<h5 class="text-center bg-success">' . $_SESSION['msg'] . '</h5>';
        unset($_SESSION['msg']);
    }
    $htmlspecialchars = 'htmlspecialchars';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="shortcut icon" type="image/jpg" href="images/book-icon.jpg">
    <title><?php
            if (defined('TITLE')) {
                echo TITLE;
            } else {
                echo 'Book Land';
            }
            ?></title>
</head>