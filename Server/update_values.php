<?php


$servername = "localhost";

// with your Database name
$dbname = "id15889682_arduino_hand_sanitizer";
// Database user
$username = "id15889682_arduino";
// Database password
$password = "!?}kun-0C/C3mLd{";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $level = ""; //initiate empty strings to take in url values

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $level = test_input($_POST["level"]);

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO liquid_level (level)
        VALUES ('" . $level . "');"; //Insert into table a new row
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided."; //catch error for debugging purpose
    }

}
else {
    echo "No data posted with HTTP POST.";  //catch error for debugging purpose
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);  // handle data
    return $data;
}

