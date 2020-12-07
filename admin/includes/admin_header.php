<?php ob_start();?>
<?php session_start();?>
<?php include "../includes/db.php";?>
<?php include "functions.php";?>
<?php 
//if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
//    header('Location: ../index.php');
//}
//if(!is_admin()){
//    header("Location: ../index.php");
//}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SB Admin - Bootstrap Admin Template</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/sb-admin.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/loader.css" rel="stylesheet">
        <!--        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

        <script src="js/jquery.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>
        
        <!--
<script src="../js/jquery.js"></script>
<script src="jquery-3.5.1.min.js"></script>
-->


    </head>
    <body>