<?php
//This line will make the page auto-refresh each 15 seconds
$page = $_SERVER['PHP_SELF'];
$sec = "15";
?>


<html>
<head>
<!--//I've used bootstrap for the tables, so I inport the CSS files for taht as well...-->
<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">		
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
	
<style>
table {
	border-collapse:collapse;
	width:90%;
	color:#3b5360;
	font-family: monospace;
	font-size: 25px;
	text-align:left;
}

th{
	background-color: #bee5d3;
}

tr:nth-child(even){
	background-color: #d6b0b1;
}

</style>
	
	
	
<body>    
<?php
include("database_connect.php"); //We include the database_connect.php which has the data for the connection to the database


// Check the connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//Again, we grab the table out of the database, name is ESPtable2 in this case
$sql = $conn,"SELECT * FROM liquid_level";//table select


		  
//Now we create the table with all the values from the database	  
echo "<table class='table' style='font-size: 30px;'>
	<thead>
		<tr>
		<th>Liquid Level</th>	
		</tr>
	</thead>
	
    <tbody>
      <tr class='active'>
        <td>ID</td>
        <td>Level</td>
        <td>Retrieved at </td>		
      </tr>  
		";
		  
//loop through the table and print the data into the table
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
		$row_sensor = $row["level"];
		$row_timestamp = $row["time_stamp"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_sensor . '</td> 
                <td>' . $row_timestamp. '</td> 
              </tr>';
    }
    $result->free();
}
 
$conn->close();
?>
		
		
		
		

		
		
		
		

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
    