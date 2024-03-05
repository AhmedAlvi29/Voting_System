<?php
session_start();
require 'config.php';
if($_SESSION['key'] != "AdminKey")
{
    echo "<script> location.assign('logout.php'); </script>";
    die;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Panel</title>
    <link rel="stylesheet" href="../asset/css/style.css">
	<link rel="stylesheet" href="../asset/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
       <div class="row bg-color text-white">
       <div class="col-1">
             <img src="../asset/img/logo.png" alt="" width="80px">
            </div>
            <div class="col-11 my-auto">
                <h3>Online Voting System - <small>Welcome <?php echo strtoupper($_SESSION['username']); ?></small></h3>
            </div>
       </div> 
   
