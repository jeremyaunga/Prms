<?php
    require_once('auth.php');
    require_once('connection/config.php');
    
    //Connect to mysqli server
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
    if(isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
        unset($_SESSION['success']);
    }
    if(isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
        unset($_SESSION['error']);
    }
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }
    
    //get member_id from session
    $member_id = $_SESSION['SESS_MEMBER_ID'];
    $flag_0 = 0;
    
    // Get food items in cart
    $result1=mysqli_query($conn,"SELECT food_name,food_description,food_price,food_photo,cart_id,quantity_value,total,flag,category_name,lt FROM food_details,cart_details,categories,quantities WHERE cart_details.member_id='$member_id' AND cart_details.flag='$flag_0' AND cart_details.food_id=food_details.food_id AND food_details.food_category=categories.category_id AND cart_details.quantity_id=quantities.quantity_id AND cart_details.lt ='food'")
    or die("There was a problem loading your cart items. Please try again later."); 
    
    $result = array();
    while($row = mysqli_fetch_assoc($result1)){
        $result[]=$row;
    }
    
    // Get special deals in cart
    $result2=mysqli_query($conn,"SELECT * FROM cart_details c inner join specials s on s.special_id = c.food_id inner join quantities q on q.quantity_id = c.quantity_id WHERE c.lt = 'special' and c.member_id ='$member_id' ")
    or die("There was a problem loading your special deals. Please try again later.");
    
    while($row = mysqli_fetch_assoc($result2)){
        $result[]=$row;
    }
    
    // Get quantities for dropdown
    $quantities=mysqli_query($conn,"SELECT * FROM quantities")
    or die("Could not load quantity options."); 
    
    // Get cart items for dropdown
    $items=mysqli_query($conn,"SELECT * FROM cart_details WHERE member_id='$member_id' AND flag='$flag_0'")
    or die("Could not load your cart items."); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME ?>: Shopping Cart</title>
    <style>
        /* Base Styles */
        :root {
            --primary-color: #bd6f2f;
            --primary-dark: #8a4f1a;
            --primary-light: #e8a35a;
            --text-dark: #333;
            --text-light: #777;
            --bg-light: #f9f5f0;
            --bg-white: #ffffff;
            --shadow: 0 10px 30px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
        }
        
        a {
            text-decoration: none;
            color: var(--primary-color);
            transition: var(--transition);
        }
        
        a:hover {
            color: var(--primary-dark);
        }
        
        /* Layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: var(--bg-white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        /* Header */
        .page-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(189, 111, 47, 0.2);
        }
        
        .page-header h1 {
            color: var(--primary-color);
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            font-family: 'Playfair Display', serif;
        }
        
        .continue-shopping {
            display: inline-block;
            padding: 12px 25px;
            background: var(--primary-color);
            color: white;
            border-radius: 30px;
            font-weight: 500;
            transition: var(--transition);
            margin-bottom: 20px;
        }
        
        .continue-shopping:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        /* Alerts */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }
        
        /* Quantity Form */
        .quantity-form {
            background: var(--bg-light);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .quantity-form table {
            width: 100%;
        }
        
        .quantity-form select, 
        .quantity-form input[type="submit"] {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: var(--transition);
        }
        
        .quantity-form select {
            width: 100%;
            background-color: var(--bg-white);
        }
        
        .quantity-form select:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(189, 111, 47, 0.2);
        }
        
        .quantity-form input[type="submit"] {
            background: var(--primary-color);
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 500;
            padding: 12px 25px;
        }
        
        .quantity-form input[type="submit"]:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        /* Cart Table */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .cart-table th {
            background: var(--bg-light);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--primary-dark);
            border-bottom: 2px solid rgba(189, 111, 47, 0.3);
        }
        
        .cart-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(189, 111, 47, 0.1);
            vertical-align: middle;
        }
        
        .cart-table tr:hover {
            background: rgba(189, 111, 47, 0.03);
        }
        
        .food-img {
            width: 80px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
            transition: var(--transition);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .food-img:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .place-order-btn {
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border-radius: 30px;
            font-weight: 500;
            transition: var(--transition);
            display: inline-block;
            border: none;
            cursor: pointer;
        }
        
        .place-order-btn:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .empty-cart {
            text-align: center;
            padding: 40px;
            color: var(--text-light);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .cart-table {
                display: block;
                overflow-x: auto;
            }
            
            .quantity-form table {
                display: block;
            }
            
            .quantity-form tr {
                display: flex;
                flex-direction: column;
                margin-bottom: 15px;
            }
            
            .quantity-form td {
                padding: 8px 0;
            }
            
            .page-header h1 {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            
            .food-img {
                width: 60px;
                height: 50px;
            }
            
            .cart-table th, 
            .cart-table td {
                padding: 10px 8px;
                font-size: 0.9rem;
            }
        }
    </style>
    <script language="JavaScript" src="validation/user.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>MY SHOPPING CART</h1>
            <a href="foodzone.php" class="continue-shopping">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Continue Shopping
            </a>
        </div>
        
        <?php if(empty($result)): ?>
            <div class="empty-cart">
                <h3>Your cart is empty</h3>
                <p>Start adding some delicious items to your cart!</p>
                <a href="foodzone.php" class="continue-shopping" style="margin-top: 20px;">Browse Menu</a>
            </div>
        <?php else: ?>
            <form name="quantityForm" id="quantityForm" method="post" action="update-quantity.php" onsubmit="return updateQuantity(this)" class="quantity-form">
                <table>
                    <tr>
                        <td><strong>Item ID</strong></td>
                        <td>
                            <select name="item" id="item" class="form-select">
                                <option value="select">- select item -
                                <?php 
                                mysqli_data_seek($items, 0);
                                while ($row=mysqli_fetch_array($items)){
                                    echo "<option value=$row[cart_id]>$row[cart_id]"; 
                                }
                                ?>
                            </select>
                        </td>
                        <td><strong>Quantity</strong></td>
                        <td>
                            <select name="quantity" id="quantity" class="form-select">
                                <option value="select">- select quantity -
                                <?php
                                mysqli_data_seek($quantities, 0);
                                while ($row=mysqli_fetch_assoc($quantities)){
                                    echo "<option value=$row[quantity_id]>$row[quantity_value]"; 
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type="submit" name="Submit" value="Update Quantity" /></td>
                    </tr>
                </table>
            </form>
            
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Food Photo</th>
                        <th>Food Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row): 
                        $lt = $row['lt'];
                    ?>
                    <tr>
                        <td><?php echo $row['cart_id']; ?></td>
                        <td>
                            <a href="images/<?php echo $row[$lt.'_photo']; ?>" target="_blank">
                                <img src="images/<?php echo $row[$lt.'_photo']; ?>" class="food-img" alt="<?php echo $row[$lt.'_name']; ?>">
                            </a>
                        </td>
                        <td><?php echo $row[$lt.'_name']; ?></td>
                        <td><?php echo $row[$lt.'_description']; ?></td>
                        <td><?php echo ($lt == 'food' ? $row['category_name'] : 'SPECIAL DEALS'); ?></td>
                        <td>KSh <?php echo number_format($row[$lt.'_price'], 2); ?></td>
                        <td><?php echo $row['quantity_value']; ?></td>
                        <td>KSh <?php echo number_format($row['total'], 2); ?></td>
                        <td>
                            <button onclick="placeOrder(<?php echo $row['cart_id']; ?>)" class="place-order-btn">
                                <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i> Place Order
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
    
    <script>
    // Function to handle order placement with confirmation
    function placeOrder(cartId) {
        Swal.fire({
            title: 'Confirm Order',
            text: 'Are you sure you want to place this order?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, place order!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading indicator
                Swal.fire({
                    title: 'Processing Order',
                    html: 'Please wait while we process your order...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit the order via AJAX
                fetch(`order-exec.php?id=${cartId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        // Remove the ordered item from display
                        const row = document.querySelector(`tr[data-cart-id="${cartId}"]`);
                        if (row) {
                            row.style.transition = 'all 0.3s ease';
                            row.style.opacity = '0';
                            setTimeout(() => {
                                row.remove();
                                
                                // Check if cart is now empty
                                if (document.querySelectorAll('.cart-table tbody tr').length === 0) {
                                    // Show empty cart message
                                    const emptyCartHTML = `
                                        <tr class="empty-cart-row">
                                            <td colspan="9" style="text-align: center; padding: 40px;">
                                                <h3>Your cart is empty</h3>
                                                <p>Start adding some delicious items to your cart!</p>
                                                <a href="foodzone.php" class="btn" style="margin-top: 20px;">
                                                    <i class="fas fa-utensils"></i> Browse Menu
                                                </a>
                                            </td>
                                        </tr>
                                    `;
                                    document.querySelector('.cart-table tbody').innerHTML = emptyCartHTML;
                                }
                            }, 300);
                        }

                        // Show success message
                        Swal.fire({
                            title: 'Order Placed!',
                            text: 'Your order has been placed successfully.',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was a problem placing your order. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    });
            }
        });
    }

    // Add data-cart-id attribute to each row when page loads
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.cart-table tbody tr');
        rows.forEach(row => {
            const cartId = row.cells[0].textContent;
            row.setAttribute('data-cart-id', cartId);
        });
    });

    // Function to update quantity (existing from your user.js)
    function updateQuantity(form) {
        // Your existing validation logic here
        return true;
    }
</script>
</body>
</html>