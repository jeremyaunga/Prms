<?php
    //Start session
    session_start();
    
    //Include database connection details
    require_once('connection/config.php');
    
    //Connect to mysqli server
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }
    
   
    
    // Function to sanitize values received from the form to prevent SQL injection
function clean($str) {
    global $conn; // Access the global database connection
    $str = trim($str); // Trim whitespace from the input

    // Escape the string for safe SQL usage
    return mysqli_real_escape_string($conn, $str);
}
    
    //Sanitize the POST values
    $name = clean($_POST['name']);
    
    //define a default value for flag
    $flag_0 = 0;

    //Create INSERT query
    $qry = "INSERT INTO currencies(currency_symbol,flag) VALUES('$name','$flag_0')";
    $result = @mysqli_query($conn,$qry);
    
    //Check whether the query was successful or not
    if($result) {
        header("location: options.php");
        exit();
    }else {
        die("Query failed " . mysqli_error());
    }
 ?>