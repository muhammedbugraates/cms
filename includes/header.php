<?php ob_start();?>
<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog Home - Start Bootstrap Template</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/blog-home.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <script src="js/jquery.js"></script>
        <style>
            p.loading, p.like_number, button.like_button1, button.like_button2{
                font-size: 22px !important;
            }
            div.testSize {
                height: 50px !important;
            }

        </style>   

        <style>
            .loader {
                position:relative;
                right: 30px;
                border: 5px solid #f3f3f3;
                border-radius: 50%;
                border-top: 5px solid blue;
                border-right: 5px solid green;
                border-bottom: 5px solid red;
                width: 45px;
                height: 45px;
                -webkit-animation: spin 1s linear infinite;
                animation: spin 1s linear infinite;
            }

            @-webkit-keyframes spin {
                0% { -webkit-transform: rotate(0deg); }
                100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>

    </head>

    <body>