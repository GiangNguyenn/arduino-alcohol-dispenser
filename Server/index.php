<?php
//This line will make the page auto-refresh each 15 seconds
$page = $_SERVER['PHP_SELF'];
$sec = "60";
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
	margin:50px 25px 50px 25px;
	justify-content:space-around ;
	padding:20px;
	/*box-shadow: 0 0 20px rgba(0,0,0,0.1);*/
background-color: rgba(100,200, 0, 0.5); 
border: 1px solid;
  box-shadow: 5px 10px;
}
h2{ color: #ffffff; font-family: 'Raleway',sans-serif; font-size: 62px; font-weight: 800; line-height: 72px; margin: 0 0 24px; text-align: center; text-transform: uppercase;}

h2:hover{
    color:#df7861;
}

tr:nth-child(even){
	background-color: #ecb390;
}

tr:nth-child(odd){
	background-color: #d4e2d4;
}


body {
	height: 100%;
}

body {
	margin: 0;
	background: linear-gradient(45deg, #49a09d, #5f2c82);
	font-family: sans-serif;
	font-weight: 100;
}

.container {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}
</style>

<body>    
<?php
if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }

    $no_of_records_per_page = 5;
    $offset = ($pageno-1) * $no_of_records_per_page;
        
include("database_connect.php"); //We include the database_connect.php which has the data for the connection to the database


// Check the connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "SELECT * FROM liquid_level";//table select

$total_pages_sql = "SELECT COUNT(*) FROM liquid_level";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT * FROM 
        (SELECT * FROM liquid_level ORDER BY id DESC LIMIT $offset, $no_of_records_per_page)
        sub ORDER BY id DESC";
        $res_data = mysqli_query($conn,$sql);
		  
//Now we create the table with all the values from the database	  
echo "<div class='container'>";
echo "
    <table class='table'>
    	<thead>
    	<h2>Liquid Level</h2>	
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
		$row_timestamp = date("Y-m-d H:i:s", strtotime("$row_timestamp + 7 hours"));      
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_sensor . '</td> 
                <td>' . $row_timestamp . '</td> 
              </tr>';
    }
    $result->free();
}

$conn->close();
?>

		
<ul class="pagination" >
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>';