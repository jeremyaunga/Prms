<?php
    //Start session
    session_start();
    
    //Include database connection details
    require_once('connection/config.php');
    
    //Connect to mysqli server
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error($conn));
    }
    
    //Function to sanitize values received from the form. Prevents SQL injection
    function clean($str, $conn) {
        $str = trim($str);
        return mysqli_real_escape_string($conn, $str);
    }
    
    //Sanitize the POST values
    $FirstName = clean($_POST['fName'], $conn);
    $LastName = clean($_POST['lName'], $conn);
    $StreetAddress = clean($_POST['sAddress'], $conn);
    $MobileNo = clean($_POST['mobile'], $conn);
    
    //Create INSERT query - use prepared statements for better security
    $qry = "INSERT INTO staff(firstname, lastname, Street_Address, Mobile_Tel) VALUES(?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $qry);
    
    if($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssss', $FirstName, $LastName, $StreetAddress, $MobileNo);
        $result = mysqli_stmt_execute($stmt);
        
        //Check whether the query was successful or not
        if($result) {
            echo "<html><script language='JavaScript'>alert('Staff information added successfully.'); window.location.href = 'allocation.php';</script></html>";
            exit();
        } else {
            die("Adding staff information failed ... " . mysqli_error($conn));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }
    
    mysqli_close($conn);
?>