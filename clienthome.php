<?php  
include("db.php");
?>


<! DOCTYPE html>
<html lang = "en">
<head>

<script>

function dropdown()
{

var x = document.getElementById("mynavbar");

if (x.className === "navbar")
{
x.className += "responsive";
}

else
{
x.className = "navbar";
}

}

</script>

<link rel = "icon" type = "type/x-icon" href = "ITStartUp.png">
<link rel = "stylesheet" type = "text/css" href = "css/custom.css">
<title> IT Support Start-Up</title>
<meta charset = "utf-8">
<meta name ="viewport" content = "width=device-width, initial-scale=1"> 
<div id = "top">

<img src = "ITStartUp.png" alt = "logo" style = "float:left;width:50px;height:50px;"> 
<h1> IT Support Start-Up</h1> 

<div class = "navbar" id = "mynavbar">

<a  class = "active" href ="clienthome.php">Home</a>
<a  href ="clientservices.php">Services</a>
<a  href ="client.php">Submit Problem</a>
<a  href ="clientmade.php">My Account</a>
<a  href ="javascript:void(0);" class = "icon" onclick = "dropdown()">&#9776;</a>

</div>

</div>

<div id = "wrapper">
<div class = "main">
<body>

</div>
</div>
</body>
</html>


