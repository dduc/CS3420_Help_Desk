<?php
include("db.php");
session_start();
       
$id = htmlspecialchars($_GET['cid']);
       

       //ALL CLIENT INFO
       $client = "SELECT * from client where client_id = $id";
       $cli= pg_query($client) or die('Query failed: ' . pg_last_error());
      
       //ASSOCIATED PROBLEM
       $prob = "SELECT * from problem p where client_id = $id order by p.problem_id asc";
       $pr = pg_query($prob) or die('Query failed: ' . pg_last_error());
  
       //ASSOCIATED SERVICE
       $serv = "SELECT * from service s where client_id = $id";
       $si = pg_query($serv) or die('Query failed: ' . pg_last_error());
  

      date_default_timezone_set('America/Los_Angeles');
  ?>
  <!DOCTYPE html>
  <html lang="en">
      <head>
          <meta charset="utf-8">
          <title>Problem Receipt</title>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpB    fshb" crossorigin="anonymous">
          <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
          <link rel="stylesheet" href="/~jose/itsupport/css/report.css">
      </head>
      <body>
      <!-- page content -->
      <div class="main-container">
          <main role="main" class="container">
              <div class="row">
                  <div class="col col-md-auto">
 
                      <p id="header">
                      <img src="ITStartUp.png" width="100px" height="100px">
 <strong>IT Support Start-Up</strong>
</p>
                  </div>
              </div>
              <div class="row">
              </div>
              <div class="row text-right">
                  <div class="col text-right">
                      <h6 class="dated">Receipt Generated on: <?php echo date('l jS \of F Y h:i A    '); ?></h6>
                 </div>
              </div>
     <hr>
              <div class="row">
                  <div class="col-5">
                      <?php $ci = pg_fetch_array($cli, null, PGSQL_NUM); ?>
                      <?php
                          echo "<p>";
                          echo "Full Name: " . $ci[1] . " " . $ci[2] . "</br>";
                          echo "<p>Address: " . $ci[3] . ", " . $ci[4]. " " . $ci[5] . ", " . $ci[6] . ""; 
                          echo "</p>";
 
                          echo "<p>";
                          echo "Primary Phone: " . $ci[7] . "</br></p>";
                          echo "<p>Email: " . $ci[10] . "</br></p>";

                          echo "<p>";
                          echo "Business Name: " . $emp[8] . "</p>";
                          echo "<p>Fax: " . $emp[9] . "</br>";
 
                          echo "</p>";
                      ?>
             </div>
     <hr>
             <div class="row justify-content-center">
                 <div class="col">
                     <h2>Problem</h2>
                      <?php $p = pg_fetch_array($pr, null, PGSQL_NUM); ?>
                      <?php
                          echo "<p><b>";
                          echo "Category:</b> " . $p[1] . "</br>";
                          echo "<p><b>Description</b>: " . $p[2] . ""; 
                          echo "</p>";
 
                      ?>
                 </div>
             </div>
     <hr>
     <div class="row justify-content-center">
	 <div class="col">
	     <h2>Service Info</h2>
                      <?php $s = pg_fetch_array($si, null, PGSQL_NUM); ?>
                      <?php
                          echo "<p>";
                          echo "Service Cost: " . $s[2] . "</p>";
                          echo "<p><b>Subtotal: " . $s[3] . ""; 
                          echo "</b></p>";
 
                      ?>
                 </div>
</div>
     </div>
         </main>
     </div>
     <script type="text/javascript">

     </script>
         <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si    04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.j    s" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crosso    rigin="anonymous"></script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.    js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" cross    origin="anonymous"></script>
         <!--<script type="text/javascript"
     src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>-->
         <script src="/~jose/itsupport/js/jquery_cookie/jquery.cookie.js"></script>
         <!--DATATABLES-->
         <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jq    uery.dataTables.js"></script>
     </body>
 </html>

