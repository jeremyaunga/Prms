<?php
require_once('connection/config.php');
require_once('auth.php');

// Connect to database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if(!$conn) {
    die('Failed to connect to server: ' . mysqli_error());
}

// Check if user is admin/staff (add your own authorization logic)
if (!isset($_SESSION['SESS_MEMBER_ID']) || $_SESSION['SESS_ROLE'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = $_GET['id'];
    $status = $_GET['status'];
    
    // Validate and sanitize input
    $order_id = mysqli_real_escape_string($conn, $order_id);
    $status = mysqli_real_escape_string($conn, $status);
    
    if ($status == 'complete') {
        $query = "UPDATE orders_details SET flag = 1 WHERE order_id = '$order_id'";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            $_SESSION['success'] = "Order marked as completed successfully!";
        } else {
            $_SESSION['error'] = "Error updating order status: " . mysqli_error($conn);
        }
    }
    
    // Redirect back to orders page
    header("Location: orders.php");
    exit();
} else {
    header("Location: orders.php");
    exit();
}
?>