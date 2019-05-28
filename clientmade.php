<?php  
//Resume session from Home and connect to Database
include("db.php");
session_start();


$_SESSION['print'] = $probId;

// Check if Save Changes button has been clicked, along with validation of forms
if (isset($_POST['save']))
{
	$cid = htmlspecialchars($_GET["cid"]);
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $zip = $_POST['zip'];
                $phone = $_POST['phone'];
                $business_name = $_POST['business_name'];
                $fax = $_POST['fax'];
                $email = $_POST['email'];
        $save = "UPDATE client set fname='$fname', lname='$lname', address='$address', city='$city', state='$state', zip='$zip', phone='$phone', business_name='$business_name', fax='$fax', email='$email' where client_id = $cid";
	pg_query($save) or die('Query failed : ' . pg_last_error());


}

// Check if submit another problem button has been clicked, along with validation of forms
if (isset($_POST['dbinsert']))
{
	$cid = htmlspecialchars($_GET["cid"]);

	// make client_id for foreign key constraints for problem
	$probandcat = "INSERT INTO problem (client_id, category, description) VALUES ('$cid','$_POST[category]','$_POST[problem]')"; 
	$pandc = pg_query($probandcat) or die('Query failed : ' . pg_last_error());
        
	// Make problem status for problem, set solved to null
        $ps = "INSERT INTO problem_status (solved) VALUES (NULL)";
	pg_query($ps) or die('Query failed : ' . pg_last_error());
        
        $problem = "SELECT max(problem_id) from problem"; 
	$pr = pg_query($problem) or die('Query failed : ' . pg_last_error());
        $probid = pg_fetch_result($pr,0,0);
        
        $clientHasAProb = "INSERT INTO client_hasa_problem (client_id,problem_id,s_date,e_date) VALUES ('$cid','$probid',CURRENT_DATE-integer '1', NULL)";
	pg_query($clientHasAProb) or die('Query failed : ' . pg_last_error());

}


/* Professor said there should not be a delete option on the page....
if(isset($_POST['delete']))
{
$deleteProb = "DELETE from problem where problem_id = $_POST[delete]";
pg_query($deleteProb) or die('Query failed : ' . pg_last_error());
}
*/

if(isset($_POST['print']))
{
$probId = $_POST['print'];
$cid = htmlspecialchars($_GET["cid"]);
header("Location: probreceipt.php?cid=" . $cid);
}
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

<!-- more Boostrap css -->
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<!-- css from Jose -->
<link rel="stylesheet" href="/~dirk/itsupport/css/table.css">

<!-- my own css -->
<link rel="stylesheet" href="/~dirk/itsupport/css/custom.css">

<!-- personally made icon -->
<link rel = "icon" type = "type/x-icon" href = "ITStartUp.png">

<!-- two fonts that work well together, from google -->
<link href="http://fonts.googleapis.com/css?family=Meta Sans:bold" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Skolar" rel="stylesheet" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

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
<li class="nav-item active">
<a class="nav-link" href = "clientmade.php">My Account</a>
</li>
<li class="nav-item">
<a class="nav-link" href = "clientcontact.php">Contact Us</a>
</li>
</ul>
</div>
</nav> 
</head>
</div>

<body>
<div class="main-container" id = "acc">
<main role="main" class="container">

<br>

<?php 

//If client hasnt logged in or created a problem
if (htmlspecialchars($_GET["cid"]) == NULL)
{
   echo "<h4>You have not created an account yet!<br><br>Please visit the home page by clicking on the home link above to submit a problem</h4>";
   exit;
}

// get basic client information
$clientid = htmlspecialchars($_GET["cid"]);
$displayclient = "SELECT * FROM client WHERE client_id = $clientid";
$result = pg_query($displayclient) or die('Query failed : ' . pg_last_error());
$resultArr = pg_fetch_all($result);
?>

<br><br>

<?php
$checktickets = "select count(*) from client c, ticket t, problem p where c.client_id = $clientid and t.problem_id = p.problem_id and c.client_id = p.client_id";
$checkticks = pg_query($checktickets); 
$numticks = pg_fetch_result($checkticks, 0);

//Check here if client already has no tickets assigned to them, if so, print out first
// welcome message below...
if ($numticks == 0)
{
?>

<h5>Welcome 
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
?>, which you can use to login and view all of your information. Your information is listed below.
</h5>

<?php
}
else
{
?>
<h2>Welcome 
<!-- Display First Name -->
<?php $first = "select fname from client where client_id = $clientid"; 
$res = pg_query($first); 
$string = pg_fetch_result($res, 0); 
$fname = str_replace(' ', '', $string); echo 
$fname;
?>! 
</h2>

<?php
}
?>

<br><br>

<!-- Display all clients info from database -->
<hr>

<?php if (!isset($_POST['edit']))
{ ?>
<div class = "container" id = "c1" >

<form method= "post">
<div class = "row">
<div class = "col-md-4">
<h6><u><b> Personal Information: </b></u></h6>
</div>
<div class = "col-md-8" style = "text-align: right;">
<input type = "submit" name = "edit" class = "btn btn-outline-primary" value = "Edit">
</div>
</div>
</form>

<table id "t1">
<tr id = "personal">
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

<tr id = "personal">
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
</div>

<?php
}
else
{
//Edit button code below
?>

<div class = "container" id = "c2">
<form method= "post">
<div class = "row">
<div class = "col-md-4">
<h6><u><b> Personal Information: </b></u></h6>
</div>
<div class = "col-md-6" style = "text-align: right;">
<input type = "submit" name = "save" class = "btn btn-outline-primary" value = "Save Changes">
</div>
<div class = "col-md-2" style = "text-align: right;">
<a href="./clientmade.php?cid=<?php echo htmlspecialchars($_GET['cid']);?>" name = "cancel" class="cancelbtn" style = "height: 39px; padding: 5px 20px;">Cancel</a>
</div>
</div>

<table width = "100%">
<tr id = "personal">
 <td>First Name</td>
 <td>Last Name</td>
 <td>Address</td>
 <td>City</td>
 <td>State</td>
</tr>
<?php foreach ($resultArr as $array)
{
   echo '<tr>
           <td>';?>
           <input class = "form-control" name = "fname" type = "text" pattern = "[A-Za-z]{1,15}" value = "<?php $array['fname'] = preg_replace('/\s+/','',$array['fname']); echo $array['fname'];?>" required><?php echo '</td>
           <td>';?>
           <input class = "form-control" name = "lname" type = "text" pattern = "[A-Za-z]{1,15}" value = "<?php $array['lname'] = preg_replace('/\s+/','',$array['lname']); echo $array['lname'];?>" required><?php echo '</td>
           <td>';?>
           <input class = "form-control" name = "address" type = "text" pattern = "[A-Za-z0-9'\.\-\s\,]{1,30}" value = "<?php echo $array['address'];?>" required><?php echo '</td>
           <td>';?>
           <input class = "form-control" name = "city" type = "text" pattern = "[A-Za-z0-9\s]{1,20}" value = "<?php $array['city'] = preg_replace('/\s+/','',$array['city']); echo $array['city'];?>" required><?php echo '</td>
           <td>
           <select class = "form-control" name = "state">
           <option value = "'. $array['state'].'">'. $array['state'].'</option>
           <option value="AL">AL</option>
           <option value="AK">AK</option>
           <option value="AZ">AZ</option>
           <option value="AR">AR</option>
           <option value="CA">CA</option>
           <option value="CO">CO</option>
           <option value="CT">CT</option>
           <option value="DE">DE</option>
           <option value="FL">FL</option>
           <option value="GA">GA</option>
           <option value="HI">HI</option>
           <option value="ID">ID</option>
           <option value="IL">IL</option>
           <option value="IN">IN</option>
           <option value="IA">IA</option>
           <option value="KS">KS</option>
           <option value="KY">KY</option>
           <option value="LA">LA</option>
           <option value="ME">ME</option>
           <option value="MD">MD</option>
           <option value="MA">MA</option>
           <option value="MI">MI</option>
           <option value="MN">MN</option>
           <option value="MS">MS</option>
           <option value="MO">MO</option>
           <option value="MT">MT</option>
           <option value="NE">NE</option>
           <option value="NV">NV</option>
           <option value="NH">NH</option>
           <option value="NJ">NJ</option>
           <option value="NM">NM</option>
           <option value="NY">NY</option>
           <option value="NC">NC</option>
           <option value="ND">ND</option>
           <option value="OH">OH</option>
           <option value="OK">OK</option>
           <option value="OR">OR</option>
           <option value="PA">PA</option>
           <option value="RI">RI</option>
           <option value="SC">SC</option>
           <option value="SD">SD</option>
           <option value="TN">TN</option>
           <option value="TX">TX</option>
           <option value="UT">UT</option>
           <option value="VT">VT</option>
           <option value="VA">VA</option>
           <option value="WA">WA</option>
           <option value="WV">WV</option>
           <option value="WI">WI</option>
           <option value="WY">WY</option>           
           </select>
           </td>
         </tr>'; 
}
?>
</table>

<br>

<table width = "100%">
<tr id = "personal">
 <td>Zip</td>
 <td>Phone</td>
 <td>Business</td>
 <td>Fax</td>
 <td>Email</td>
</tr>
<?php foreach ($resultArr as $array)
{
   echo '<tr>
           <td>'?><input class = "form-control" type = "text" name = "zip" maxlength = 5 pattern = "[0-9]{1,5}" value = "<?php echo $array['zip'];?>" required><?php echo '</td>
           <td>'?><input class = "form-control" type = "tel" name = "phone" maxlength = 12 placeholder = "123-456-7890" pattern = "\d{3}-\d{3}-\d{4}$" value = "<?php echo $array['phone'];?>" required><?php echo '</td>
           <td>'?><input class = "form-control" type = "text" name = "business_name" value = "<?php $array['business_name'] = preg_replace('/\s+/','',$array['business_name']); echo $array['business_name'];?>"><?php echo '</td>
           <td><input class = "form-control" type = "text" name = "fax" maxlength = 13 placeholder = "1-234-5678901" pattern = "\d{1}-\d{3}-\d{7}" value = "' . $array['fax'] .'"></td>
           <td>'?><input class = "form-control" type = "email" name = "email" placeholder = "me@email.com" pattern = "[a-zA-Z0-9!#$%&amp;'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*" value = "<?php $array['email'] = preg_replace('/\s+/','',$array['email']);
echo $array['email'];?>" required><?php echo '</td>
         </tr>';
}
?>
</table>
</form>
</div>

<?php
}
?>

<hr>

<?php if (!isset($_POST['submitProb']))
{ ?>
<div class = "container" id = "c3">
<form method= "post">
<div class = "row">
<div class = "col-md-4">
<h3><u><b> Problems:</b></u></h3>
<h6><i> Simply click a problem below to view its tickets </i></h6>
</div>
<div class = "col-md-8" style = "text-align: right;">
<input type = "submit" name = "submitProb" class = "btn btn-outline-primary" value = "Submit Another Problem">
</div>
</div>
</form>

<!-- Display all clients problems that they have submitted -->
<table class="table sortable">
  <thead class = "thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Category</th>
      <th scope="col">Description</th>
      <th scope="col">Status</th>
      <th scope="col">Start Date</th>
      <th scope="col">End Date</th>
      <th scope = "col">Print Receipt</th>
      </tr>
  </thead>
</table>

<hr>

<div class="pre-scrollable">
<div class = "container" id = "c4">
<?php

$clientproblem = "SELECT * FROM problem WHERE client_ID = $clientid order by problem_id asc";
$problem = pg_query($clientproblem);
if (!$problem)
{
  echo "You have not created an account yet.\n";
}
$probArr = pg_fetch_all($problem);
$pcounter = 0;

$probStatus = "SELECT solved from client, problem_status ps where client_id = $clientid and ps.ps_id = $clientid"; 
$problemStat = pg_query($probStatus);

$probStartDate = "SELECT s_date from client_hasa_problem chp, client c, problem p where c.client_id = $clientid and c.client_id = chp.client_id and p.problem_id = chp.problem_id order by p.problem_id asc"; 
$probStartD = pg_query($probStartDate); 

$probEndDate = "SELECT e_date from client_hasa_problem chp, client c, problem p where c.client_id = $clientid and c.client_id = chp.client_id and p.problem_id = chp.problem_id order by p.problem_id asc"; 
$probEndD = pg_query($probEndDate); 

foreach($probED as $array2)
{
if($array2['e_date'] == NULL)
{
$t = 0;
goto unsolved;
}

else
{
$t = 1;
}
}

unsolved:
?>

<?php
foreach ($probArr as $array)
{
?>

<?php
$probSD = pg_fetch_result($probStartD,$i,0);
$probED = pg_fetch_result($probEndD,$i,0);
$probS = pg_fetch_result($problemStat, 0, $i);

echo  '<table class = "table table-hover" text-align = "left">
        <tbody>
        <tr class = "table-row">
        <th scope = "row">'?><?php echo ++$pcounter; echo'</th>
        <td>'. $array['category'].'</td>
        <td>'. $array['description'].'</td>
        <td>'; if($probS == NULL && $probED == NULL){echo "In Progress";} else{echo "Solved";} echo '</td>
        <td>'; echo $probSD; echo '</td>
        <td>'; echo $probED; echo '</td>
        <td>'; if($probS != NULL || $probED != NULL){ echo '<td><form method = "post" name = "print"><button type = "submit" class = "btn btn-primary" value = "' . $array['problem_id'].'" name = "print">Print</button></form></td></tr></tbody></table>';} else{echo'<td></td>  
       </tr>
       </tbody>
       </table>';}
$i++;
?>

<br><br>
<?php
}
?>
</div>
</div>

<?php
}
else
{
?>

<div class = "container" id = "c3">
<h3><u><b> Problems</b></u></h3>

<form method = "post">
<div class="form-row">
<div class="form-group col-md-4">
<label for="inputProblemCat">Problem Category</label>
<select id="inputState" class="form-control" name = "category" required>
<option selected></option>
<option value="Hardware">Hardware</option>
<option value="Software">Software</option>
<option value="Security">Security</option>
<option value="Network">Network</option>
</select>
</div>
</div>

<div class="form-row">
<div class="form-group">
<label for="inputProblemDes">Problem Description</label>
<textarea class = "form-control" rows = "5" maxlength = 150 id="inputProblemDes" placeholder = "Summarize your issues here..." name = "problem" required></textarea>
</div>
</div>

<div class = "row">
<div class = "col-md-2">
<input type ="submit" class = "btn btn-primary" name = "dbinsert" value = "Submit Problem">
</div>
<div class = "col-md-2" style = "text-align: right;">
<a href="./clientmade.php?cid=<?php echo htmlspecialchars($_GET['cid']);?>" name = "cancel" class="cancelbtn" style = "padding: 8px 10px 5px; margin: 15px;">Cancel</a>
</div>
</div>

</form>

<?php
}
?>

<hr>

<br>

<!-- Display each problem's tickets, either one or greater, along with its basic info -->
<h3><u><b> Tickets: </b></u></h3>
<br>

<table class="table sortable" text-align = "left">
  <thead class = "thead-dark">
    <tr>
      <th scope ="col" style = "width: 90px;" id = "c6"></th>
     </tr>
   <tr>
      <th scope="col">Ticket #</th>
      <th scope="col">Priority</th>
      <th scope="col">Solution</th>
      <th scope="col">Status</th>
      </tr>
  </thead>
</table>


<div class="pre-scrollable">
<div class = "container" id = "c5">


<?php 
//Start counters for loops
$counter = 1;
$probcounter = 0;
?>
</div>
</div>


<script type="text/javascript">
$(document).ready(function($) {
    $("tr.table-row").click(function() {
    var tableData = $(this).children("th").map(function()
    { return $(this).text();}).get(); 
    
    tableData--;
    
    tableData.toString();
    
    document.getElementById('c6').innerHTML = "Problem #" + (tableData+1);
<?php
    $clientprobs = "SELECT problem_id from problem p where p.client_id = $clientid order by p.problem_id asc"; 
    $cprobs = pg_query($clientprobs) or die ("Query failed");     
    
    $numofprobs = "SELECT count(*) from problem p where p.client_id = $clientid";
    $nprobs = pg_query($numofprobs);
    $res = pg_fetch_result($nprobs, 0);
    
    for($i = 0; $i < $res; $i++)
    {
    $cpro = (int)pg_fetch_result($cprobs,$i,0);
 ?>
 if(tableData == <?php echo $i;?>)
    {   
   <?php 
    $specifictick = "SELECT ticket_id from ticket t, problem p where t.problem_id = p.problem_id and p.client_id = $clientid and t.problem_id = $cpro";
    $spectick = pg_query($specifictick) or die ("Query failed:");
    $tick = (int)pg_fetch_result($spectick, 0,0);
    $tick2 = pg_fetch_result($spectick, 0,0);

    if ($tick == 0)
    { ?>
    document.getElementById('c5').innerHTML = "No ticket(s) currently assigned to this problem";

    <?php
    }
    else
    {
    //Code here below to display tickets of problems they individually click on...
    $ticketInfo = "SELECT * from ticket t,client c where c.client_id = $clientid and t.problem_id = $cpro";
    $tickIn = pg_query($ticketInfo) or die ("Query failed.."); 
    $tAll = pg_fetch_all($tickIn);
    $tcounter = 1;
    
    $tickIn = pg_query($ticketInfo) or die ("Query failed.."); 
    $tAll = pg_fetch_all($tickIn);
    $tcounter = 1;
    $ticketStatus = "SELECT status from ticket_status ts,ticket t, problem p where ts.ticket_id = t.ticket_id and p.problem_id = $cpro and t.problem_id = p.problem_id";
    $tickStat = pg_query($ticketStatus) or die ("Query failed.."); 
    $tickS = pg_fetch_result($tickStat, 0,0);
    ?>
    document.getElementById('c5').innerHTML = "<?php foreach($tAll as $array){ echo '<div class =\"row\"><div class = \"col-md-12\"><div class = \"form-group\"><table class = \"table\"><tr class = \"table-row\"><th class = \"col-md-2\" scope = \"row\">'; echo $tcounter++; echo '</th><td class = \"col-md-3\">'; echo $array['priority']; echo '</td><td class =\"col-md-4\">'; if($array['solution'] == NULL){echo "No solution";} else {echo $array['solution'];} echo '</td><td class = \"col-md-10\">'; echo $tickS; echo ' </td></tr></table></div></div></div>'; 
     
    } 

    ?>";
    
    <?php
    }
    ?>
    }
    
    <?php
    }
    ?>

   });
});

</script>

</div>

</body>
<?php
/*
-------------------BELOW IS SOME OLD CODE, KEEP FOR RECORDS-------------------------


This query below gets all probs associated with tickets,
but only the unique ones (i.e., the first ticket of each
problem) 

 
$tickprobs = "select distinct on (p.problem_id) p.problem_id, priority, solution from ticket t, problem p where client_id = $clientid and t.problem_id = p.problem_id order by p.problem_id asc";
$tprobs = pg_query($tickprobs);
$tirow = pg_fetch_row($tprobs, 0);

// If not tickets are assigned to problems of  client
if ($tirow == NULL)
{
     echo "No tickets currently assigned";
     echo "<br><br><br><br><br>";
     exit;
}
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
              //Display for no solution on ticket  
              if ($row[2] == NULL)
              {
              echo '<tr>
              <td>'. $counter . '. ' . $row[1].'</td>
              <td>'. $counter++ . '.No solution yet' .'</td>
              </tr>';

              
              $counter = 1;
              }
              //Display for solution on ticket 
              else
              {
              echo '<tr>
              <td>'. $counter . '. ' . $row[1].'</td>
              <td>'. $counter++ . '. ' . $row[2].'</td>
              </tr>';
              

               // Increment problem num 
              $counter = 1;
              }
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
                $mtickprob = "select * from ticket t, problem p where p.problem_id = $mtick and t.problem_id = $mtick and client_id = $clientid order by ticket_id asc";
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
                //Display for no solution on ticket  
                if ($mrow[2] == NULL)
                  {
                  echo '<tr>
                  <td>'. $counter . '. ' . $mrow[1].'</td>
                  <td>'. $counter++ . '.No solution yet' .'</td>
                  </tr>';
                  }
                //Display for solution on ticket 
                else
                 { 
                 echo '<tr>
                <td>'. $counter . '. ' . $mrow[1].'</td>
                <td>'. $counter++ . '. ' . $mrow[2].'</td>
                </tr>';
                 }
               }
               // Increment ticket num 
               $counter = 1;
              }
?>
               </table>
               <br><br>
<?php

}


<div class="pre-scrollable">
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
</div>
</div>
*/?>
</html>
