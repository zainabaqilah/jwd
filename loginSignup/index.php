<?php
session_start();

// cek jika ada user yang aktif, arah ke login.php
if(!isset($_SESSION['user'])) {
  header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    HALO UDAH LOGIN YA, CIE <br>
    <a href="logout.php">Logout disini ya</a>
</body>
</html>