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
    
    //Function to sanitize values received from the form. Prevents SQL injection
    function clean($str) {
global $conn;
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysqli_real_escape_string($conn,$str);
    }
    
    if(isset($_POST['Update'])){
        //define default values for flag_0 and flag_1
        $flag_0 = 0;
        $flag_1 = 1;
        
        //check whether their is an active currency
        $qry=mysqli_query($conn,"SELECT * FROM currencies WHERE flag='$flag_1'") or die("Something is wrong ... \n" . mysqli_error()); 
        if(mysqli_num_rows($qry)>0){
            $row=mysqli_fetch_assoc($qry);
            $currency_id=$row['currency_id'];
            // update the entry with a deactivation flag
            $result = mysqli_query($conn,"UPDATE currencies SET flag='$flag_0' WHERE currency_id='$currency_id'")
            or die("Something is wrong ... \n". mysqli_error());
            
                //Perform activation of another currency
                
                    //Sanitize the POST values
                    $currency_id = clean($_POST['currency']);
             
                 // update the entry with an activation flag
                 $result = mysqli_query($conn,"UPDATE currencies SET flag='$flag_1' WHERE currency_id='$currency_id'")
                 or die("Something is wrong ... \n". mysqli_error()); 
                 
                 //check if query executed
                 if($result) {
                 // redirect back to the options page
                 header("Location: options.php");
                 exit();
                 }
                 else
                 // Gives an error
                 {
                 die("activating a currency failed ..." . mysqli_error());
                 }
        }
            else{
                    //Sanitize the POST values
                    $currency_id = clean($_POST['currency']);
             
                 // update the entry with an activation flag
                 $result = mysqli_query($conn,"UPDATE currencies SET flag='$flag_1' WHERE currency_id='$currency_id'")
                 or die("Something is wrong ... \n". mysqli_error()); 
                 
                 //check if query executed
                 if($result) {
                     // redirect back to the options page
                     header("Location: options.php");
                     exit();
                 }
                 else
                 // Gives an error
                 {
                    die("activating a currency failed ..." . mysqli_error());
                 }
            }
    }
?>