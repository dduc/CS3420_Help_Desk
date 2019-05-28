<?php  
include("db.php");
session_start();
?>


<! DOCTYPE html>
<html lang = "en">
<head>
<!-----------JAVASCRIPT-------------->
<script>
</script>

<link rel = "icon" type = "type/x-icon" href = "ITStartUp.png">
<title> IT Support Start-Up</title>
<meta charset = "utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<!-- main css properties from Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

<!-- css from Jose -->
<link rel="stylesheet" href="/~dirk/itsupport/css/table.css">

<!-- my own css -->
<link rel="stylesheet" href="/~dirk/itsupport/css/custom.css">

<!-- personally made icon -->
<link rel = "icon" type = "type/x-icon" href = "ITStartUp.png">

<!-- two fonts that work well together, from google -->
<link href="http://fonts.googleapis.com/css?family=Meta Sans:bold" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Skolar" rel="stylesheet" type="text/css">


<!-- top Navbar/header of page -->
<nav class="navbar navbar-custom navbar-expand-md fixed-top">
<img src = "ITStartUp.png" alt = "logo" width = 50px height = 50px style = "padding-right: 10px;">
<a class="navbar-brand" href="#">IT Support Start-Up</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarsExampleDefault">
<ul class="navbar-nav ml-auto">
<li class="nav-item">
<a class="nav-link" href = "client.php">Home <span class="sr-only">(current)</span></a>
</li>
<li class="nav-item">
<a class="nav-link" href = "clientservices.php">Services</a>
</li>
<li class="nav-item">
<a class="nav-link" href = "clientmade.php">My Account</a>
</li>
<li class="nav-item active">
<a class="nav-link" href = "clientcontact.php">Contact Us</a>
</li>
</ul>
</div>
</nav>

<body>
<div class="main-container">
<main role="main" class="container">

</div>
</body>
</html>


