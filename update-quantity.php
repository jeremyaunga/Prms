<?php
    // Start session and check authentication
    session_start();
    require_once('auth.php');
    
    // Include database connection
    require_once('connection/config.php');
    
    // Connect to database
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }

    // Check if required POST values exist
    if(!isset($_POST['quantity']) || !isset($_POST['item'])) {
        $_SESSION['error'] = "Please select both an item and quantity.";
        header("Location: cart.php");
        exit();
    }

    // Sanitize inputs
    $quantity_id = intval($_POST['quantity']);
    $cart_id = intval($_POST['item']);
    $member_id = $_SESSION['SESS_MEMBER_ID'];

    try {
        // Get the quantity value
        $qry_select = mysqli_query($conn, "SELECT quantity_value FROM quantities WHERE quantity_id='$quantity_id'");
        if(!$qry_select || mysqli_num_rows($qry_select) == 0) {
            throw new Exception("Invalid quantity selected.");
        }
        
        $row = mysqli_fetch_assoc($qry_select);
        $quantity_value = $row['quantity_value'];

        // Get cart item details
        $cdq = mysqli_query($conn, "SELECT * FROM cart_details WHERE cart_id='$cart_id' AND member_id='$member_id'");
        if(!$cdq || mysqli_num_rows($cdq) == 0) {
            throw new Exception("Cart item not found.");
        }
        
        $res = mysqli_fetch_assoc($cdq);
        $lt = $res['lt'];
        $food_id = $res['food_id'];

        // Get food price
        $table = ($lt == 'food') ? 'food_details' : 'specials';
        $price_field = $lt . '_price';
        $result = mysqli_query($conn, "SELECT $price_field FROM $table WHERE {$lt}_id='$food_id'");
        
        if(!$result || mysqli_num_rows($result) == 0) {
            throw new Exception("Food item not found.");
        }
        
        $row = mysqli_fetch_assoc($result);
        $food_price = $row[$price_field];

        // Calculate total
        $total = $quantity_value * $food_price;

        // Update cart
        $qry_update = "UPDATE cart_details SET quantity_id='$quantity_id', total='$total' WHERE cart_id='$cart_id' AND member_id='$member_id'";
        if(mysqli_query($conn, $qry_update)) {
            $_SESSION['success'] = "Quantity updated successfully!";
        } else {
            throw new Exception("Failed to update cart. Please try again.");
        }

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    // Redirect back to cart
    header("Location: cart.php");
    exit();
?>