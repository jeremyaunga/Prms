<?php
    // Start session and check authentication
    session_start();
    if (!isset($_SESSION['SESS_MEMBER_ID'])) {
        header("Location: login.php");
        exit();
    }

    // Include database connection
    require_once('connection/config.php');
    
    // Create database connection
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    // Sanitize input function
    function sanitizeInput($data, $conn) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return mysqli_real_escape_string($conn, $data);
    }

    // Validate required fields
    $required = ['sAddress', 'box', 'city', 'mNumber'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            die("Error: Required field '$field' is missing.");
        }
    }

    // Sanitize inputs
    $StreetAddress = sanitizeInput($_POST['sAddress'], $conn);
    $BoxNo = sanitizeInput($_POST['box'], $conn);
    $City = sanitizeInput($_POST['city'], $conn);
    $MobileNo = sanitizeInput($_POST['mNumber'], $conn);
    $LandlineNo = isset($_POST['lNumber']) ? sanitizeInput($_POST['lNumber'], $conn) : null;

    // Get member ID from session
    $member_id = $_SESSION['SESS_MEMBER_ID'];
    
    // Get cart ID if provided
    $cart_id = isset($_GET['cart_id']) ? intval($_GET['cart_id']) : 0;

    // Check if billing info already exists
    $check_query = "SELECT * FROM billing_details WHERE member_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "i", $member_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Update existing record
        $query = "UPDATE billing_details SET 
                 Street_Address = ?,
                 P_O_Box_No = ?,
                 City = ?,
                 Mobile_No = ?,
                 Landline_No = ?
                 WHERE member_id = ?";
    } else {
        // Insert new record
        $query = "INSERT INTO billing_details 
                 (Street_Address, P_O_Box_No, City, Mobile_No, Landline_No, member_id)
                 VALUES (?, ?, ?, ?, ?, ?)";
    }
    mysqli_stmt_close($stmt);

    // Prepare and execute the query
    $stmt = mysqli_prepare($conn, $query);
    if ($LandlineNo !== null) {
        mysqli_stmt_bind_param($stmt, "sssssi", $StreetAddress, $BoxNo, $City, $MobileNo, $LandlineNo, $member_id);
    } else {
        mysqli_stmt_bind_param($stmt, "sssssi", $StreetAddress, $BoxNo, $City, $MobileNo, $LandlineNo, $member_id);
    }

    if (mysqli_stmt_execute($stmt)) {
        // Success - redirect to appropriate page
        if ($cart_id > 0) {
            header("Location: order-exec.php?cart_id=$cart_id");
        } else {
            header("Location: billing-success.php");
        }
        exit();
    } else {
        die("Database error: " . mysqli_error($conn));
    }

    // Close connections
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
?>