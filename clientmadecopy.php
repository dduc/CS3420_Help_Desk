<?php  
include("db.php");
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
<title> My Account </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<link rel="stylesheet" href="/~jose/itsupport/css/table.css">
<link rel="stylesheet" href="/~dirk/itsupport/css/custom.css">
<link rel = "icon" type = "type/x-icon" href = "ITStartUp.png">
</head>

<body>


<div class="main-container">
<main role="main" class="container">
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
<a class="navbar-brand" href="#">IT Support Start-Up</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarsExampleDefault">
<ul class="navbar-nav mr-auto">
<li class="nav-item active">
<a class="nav-link" href="client.php">Home</a>
</li>
<li class="nav-item">
<a class="nav-link" href="clientservices.php">Services</a>
</li>
<li class="nav-item">
<a class="nav-link" href="clientmade.php">My Account<span class = "sr-only">(current)</span></a>
</li>
<li class="nav-item">
<a class="nav-link" href="#">Contact Us</a>
</li>
</ul>
</div>
</nav>

<?php 

if (htmlspecialchars($_GET["cid"]) == NULL)
{
   echo "<h1>You have not created an account yet!\n</h1>";
   exit;
}

// get basic client information
$clientid = htmlspecialchars($_GET["cid"]);
$displayclient = "SELECT * FROM client WHERE client_id = $clientid";
$result = pg_query($displayclient) or die('Query failed : ' . pg_last_error());
$resultArr = pg_fetch_all($result);
?>

<br><br>
<h3>Welcome 
<!-- Display First Name -->
<?php $first = "select fname from client where client_id = $clientid"; 
$res = pg_query($first); 
$string = pg_fetch_result($res, 0); 
$fname = str_replace(' ', '', $string); echo 
$fname;
?>! Your problem has been submitted. Your email is
<!-- Display Email for Login --> 
<?php $email = "select email from client where client_id = $clientid"; 
$res2 = pg_query($email); 
$val2 = pg_fetch_result($res2, 0); 
echo $val2;
?>, which you can use to login and view all of your information, which is already listed below.
</h3>

<br><br>

<!-- Display all clients info from database -->
<h3><u> Personal Information </u><h3>
<br>
<table>
<div>
<tr>
 <td>First Name</td>
 <td>Last Name</td>
 <td>Address</td>
 <td>City</td>
 <td>State</td>
</tr>
<?php foreach ($resultArr as $array)
{
   echo '<tr>
           <td>'. $array['fname'].'</td>
           <td>'. $array['lname'].'</td>
           <td>'. $array['address'].'</td>
           <td>'. $array['city'].'</td>
           <td>'. $array['state'].'</td>
         </tr>'; 
}
?>
</table>

<br><br>

<table>
<tr>
 <td>Zip</td>
 <td>Phone</td>
 <td>Business</td>
 <td>Fax</td>
 <td>Email</td>
</tr>
<?php foreach ($resultArr as $array)
{
   echo '<tr>
           <td>'. $array['zip'].'</td>
           <td>'. $array['phone'].'</td>
           <td>'. $array['business_name'].'</td>
           <td>'. $array['fax'].'</td>
           <td>'. $array['email'].'</td>
         </tr>';
}
?>
</table>

<br><br><br>


<!-- Display all clients problems that they have submitted -->
<h3><u> Problems Submitted: </u></h3>
<br>
<?php

$clientproblem = "SELECT * FROM problem WHERE client_ID = $clientid order by problem_id asc";
$problem = pg_query($clientproblem);
if (!$problem)
{
  echo "You have not created an account yet.\n";
}
$probArr = pg_fetch_all($problem);
$pcounter = 0;
foreach ($probArr as $array)
{
?>

<p>Problem <?php echo '#' . ++$pcounter; ?></p>

<table>
<tr>
  <td>Category</td>
  <br>
  <td>Description</td>
</tr>

<?php
echo  '<tr>
        <td>'. $array['category'].'</td>
        <td>'. $array['description'].'</td>
       </tr>';

?>

</table>
<br><br>
<?php
}
?>

<br><br><br>


<!-- Display each problem's tickets, either one or greater, along with its basic info -->
<h3><u> Ticket Status/Info on Problems </u></h3>
<br>

<?php

//Start counters for loops
$counter = 1;
$probcounter = 0;

/* 

This query below gets all probs associated with tickets,
but only the unique ones (i.e., the first ticket of each
problem) 

*/
 
$tickprobs = "select distinct on (p.problem_id) p.problem_id, priority, solution from ticket t, problem p where client_id = $clientid and t.problem_id = p.problem_id order by p.problem_id asc";
$tprobs = pg_query($tickprobs);
$tirow = pg_fetch_row($tprobs, 0);

// Display each problems tickets (first one)
for ($i = 0, $tnum = 0; $i < $pcounter; $i++, $tnum++)
{
  
    $row = pg_fetch_row($tprobs,$tnum);

            //This query checks which problem_id occurs twice, hence more than one ticket
            $moretickets = "select * from problem p where (select count(*) from ticket t where t.problem_id = p.problem_id) > 1 and client_id = $clientid";
            $mticket = pg_query($moretickets) or die ("Query Failed");
            // variable $k added here to go through each problem_id that has more than one ticket
            $mtick = pg_fetch_result($mticket,$k,0);
           
            // If problem has one ticket, do layout below....
            if ($mtick != $row[0])
            {
             ?>
             
             <p>Problem <?php echo '#' .++$probcounter; ?></p>
             <table>
             <tr>
             <td>Priority</td>
             <br>
             <td>Solution</td>
             </tr>
             <?php
              echo '<tr>
              <td>'. $counter . '. ' . $row[1].'</td>
              <td>'. $counter++ . '. ' . $row[2].'</td>
              </tr>';

              $counter = 1;
             
             ?>
             </table>
             <br><br>
             <?php
            }

            // If prob has more than one ticket, do layout below....
            else
               {
                // Variable $k incremented for next pass to mark which problem_id to print all the tickets
                $k++;
                $mtickprob = "select * from ticket t, problem p where p.problem_id = $mtick and t.problem_id = $mtick and client_id = $clientid";
                $mtp = pg_query($mtickprob);
                
                // Prepare to fetch each row with $j
                $j = 0;
                $mrow = pg_fetch_row($mtp, $j);
                
                //Get loop count for displaying how many tickets each problem has 
                $howmanytickets = "select count(*) from ticket t where problem_id = $mrow[4]";
                $howmanyt = pg_query($howmanytickets);
                $tcount = pg_fetch_result($howmanyt,0);
             ?>
             
                <p>Problem <?php echo '#' .++$probcounter; ?></p>
                <table>
                <tr>
                <td>Priority</td>
                <br>
                <td>Solution</td>
                </tr>
                <?php
                //Here, loop through each ticket and print out each one.... 
                for($l = 0; $l < $tcount; $l++)
                {  
                //increment to pull each row out for displaying each ticket, i.e. $j++
                $mrow = pg_fetch_row($mtp, $j++);
                echo '<tr>
                <td>'. $counter . '. ' . $mrow[1].'</td>
                <td>'. $counter++ . '. ' . $mrow[2].'</td>
                </tr>';
                }
                $counter = 1;
               }
?>
               </table>
               <br><br>
<?php

}
?>

<br><br><br>

</div>
</body>
</html>
