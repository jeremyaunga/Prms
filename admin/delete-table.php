<?php
    //Start session
    session_start();
    
    //checking connection and connecting to a database
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
    
    // check if Delete is set in POST
     if (isset($_POST['Delete'])){
         // get id value of table and Sanitize the POST value
         $table_id = clean($_POST['table']);
         
         // delete the entry
         $result = mysqli_query($conn,"DELETE FROM tables WHERE table_id='$table_id'")
         or die("There was a problem while deleting the table ... \n" . mysqli_error()); 
         
         // redirect back to options
         header("Location: options.php");
     }
     
         else
            // if id isn't set, redirect back to options
         {
            header("Location: options.php");
         }
?>