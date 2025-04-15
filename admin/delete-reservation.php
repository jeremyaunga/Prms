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

 
     // check if the 'id' variable is set in URL
     if (isset($_GET['id']))
     {
     // get id value
     $id = $_GET['id'];
     
     // delete the entry
     $result = mysqli_query($conn,"DELETE FROM reservations_details WHERE ReservationID='$id'")
     or die("The reservation does not exist ... \n"); 
     
     // redirect back to the reservations 
     header("Location: reservations.php");
     }
     else
     // if id isn't set, redirect back to the reservations
     {
     header("Location: reservations.php");
     }
 
?>