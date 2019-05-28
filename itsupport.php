<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="css/custom.css">
<head>
<title> IT Support Example </title>
</head>
<body>
<?php 
    echo "<p> Web page for Employees for IT Support Database </p>"; 
$db_connection = pg_connect("host=localhost dbname=itsupport user=itsupport password=jrdd3420");
$query = 'SELECT * FROM client';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	echo "<div class='container'>\n";
	echo "<table border='1'>\n";
    echo "\t<tr>\n";
    for ($i = 0; $i <= 11; $i++) {
    	$fieldname = pg_field_name($result, $i);
    	echo "\t\t<th>$fieldname</th>";
    }
    echo "\t</tr>\n";
	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    	echo "\t<tr>\n";
    	foreach ($line as $col_value) {
        	echo "\t\t<td>$col_value</td>\n";
    	}
    	echo "\t</tr>\n";
	}
	echo "</table>\n";
	echo "</div>\n";
pg_free_result($result);
pg_close($db_connection);

?>
</body>
<!-- js -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</html>

