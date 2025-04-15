<?php
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
	
	//Sanitize the POST values
	$ReservationID = clean($_POST['reservationid']);
	$StaffID = clean($_POST['staffid']);
	
    //define a default value for flag
    $flag_1 = 1;
 
     // update the entry
     $result = mysqli_query($conn,"UPDATE reservations_details SET StaffID='$StaffID', flag='$flag_1' WHERE ReservationID='$ReservationID'")
     or die("The reservation or staff does not exist ... \n" . mysqli_error()); 
     
     //check if query executed
     if($result) {
     // redirect back to the allocation page
     header("Location: allocation.php");
     exit();
     }
     else
     // Gives an error
     {
     die("reservation allocation failed ..." . mysqli_error());
     }
 
?>