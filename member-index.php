<?php
    require_once('auth.php');
    require_once('connection/config.php');
    
    //Connect to mysqli server
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }
    
    //get member id from session
    $memberId=$_SESSION['SESS_MEMBER_ID'];

    //selecting all records from the orders_details table
    $result=mysqli_query($conn,"SELECT * FROM orders_details o inner join cart_details c on c.cart_id = o.cart_id inner join quantities q on q.quantity_id = c.quantity_id WHERE o.member_id='$memberId' ")
    or die("There are no records to display ... \n" . mysqli_error()); 
    
    //retrieving all rows from the cart_details table based on flag=0
    $flag_0 = 0;
    $items=mysqli_query($conn,"SELECT * FROM cart_details WHERE member_id='$memberId' AND flag='$flag_0'")
    or die("Something is wrong ... \n" . mysqli_error()); 
    $num_items = mysqli_num_rows($items);
    
    //retrieving all rows from the messages table
    $messages=mysqli_query($conn,"SELECT * FROM messages")
    or die("Something is wrong ... \n" . mysqli_error()); 
    $num_messages = mysqli_num_rows($messages);
    
    //set currency symbol to KSH
    $currency_symbol = 'KSH';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?>: Member Home</title>
    <style>
        /* Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        
        a {
            text-decoration: none;
            color: #bd6f2f;
            transition: color 0.3s;
        }
        
        a:hover {
            color: #8a4f1a;
        }
        
        /* Layout */
        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .welcome-header {
            background: linear-gradient(135deg, #bd6f2f, #8a4f1a);
            color: white;
            padding: 30px 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .welcome-header h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        
        /* Quick Links */
        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .quick-links a {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            background: #f8f8f8;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .quick-links a:hover {
            background: #e8e8e8;
        }
        
        .badge {
            margin-left: 8px;
            background: #bd6f2f;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
        }
        
        /* Order History */
        .order-history {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            overflow-x: auto;
        }
        
        .order-history h2 {
            padding: 20px;
            background: #f8f8f8;
            border-bottom: 1px solid #eee;
            color: #bd6f2f;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background: #f8f8f8;
            font-weight: 600;
            color: #555;
        }
        
        tr:hover {
            background: #f9f9f9;
        }
        
        .food-img {
            width: 80px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
            transition: transform 0.3s;
        }
        
        .food-img:hover {
            transform: scale(1.1);
        }
        
        .action-btn {
            padding: 6px 12px;
            background: #e74c3c;
            color: white;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        
        .action-btn:hover {
            background: #c0392b;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .quick-links {
                justify-content: center;
            }
            
            th, td {
                padding: 10px 8px;
                font-size: 0.9rem;
            }
            
            .food-img {
                width: 60px;
                height: 50px;
            }
        }
        
        @media (max-width: 480px) {
            .welcome-header h1 {
                font-size: 1.8rem;
            }
            
            .quick-links {
                flex-direction: column;
                align-items: center;
            }
            
            .quick-links a {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-header">
            <h1>Welcome <?php echo $_SESSION['SESS_FIRST_NAME'];?></h1>
            <p>View your order history, manage reservations, and update your profile</p>
        </div>
        
        <div class="quick-links">
            <a href="member-profile.php">My Profile</a>
            <a href="cart.php">Cart <span class="badge"><?php echo $num_items;?></span></a>
            <a href="inbox.php">Inbox <span class="badge"><?php echo $num_messages;?></span></a>
            <a href="tables.php">Tables</a>
            <a href="partyhalls.php">Party-Halls</a>
            <a href="ratings.php">Rate Us</a>
            <a href="logout.php">Logout</a>
        </div>
        
        <div class="info-box">
            <p>Here you can view order history and delete old orders from your account. Invoices can be viewed from the order history. You can also make table reservations in your account.</p>
            <h3><a href="foodzone.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: #bd6f2f; color: white; border-radius: 4px;">Order More Food!</a></h3>
        </div>
        
        <div class="order-history">
            <h2>ORDER HISTORY</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Food Photo</th>
                        <th>Food Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Delivery Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row=mysqli_fetch_array($result)){
                        $lt = $row['lt'];
                        if($lt =='food'){
                            $qry = "SELECT * FROM food_details f inner join categories c on c.category_id = f.food_category where food_id = {$row['food_id']}";
                        }else{
                            $qry = "SELECT * FROM specials where special_id = {$row['food_id']}";
                        }
                        $res = mysqli_fetch_array(mysqli_query($conn,$qry));
                        echo "<tr>";
                        echo "<td>" . $row['order_id']."</td>";
                        echo '<td><a href="images/'. $res[$lt.'_photo']. '" target="_blank"><img src="images/'. $res[$lt.'_photo']. '" class="food-img" alt="'. $res[$lt.'_name']. '"></a></td>';
                        echo "<td>" . $res[$lt.'_name']."</td>";
                        echo "<td>" . ($lt == 'food' ? $res['category_name'] : 'Special Deals')."</td>";
                        echo "<td>" . $currency_symbol . $res[$lt.'_price']."</td>";
                        echo "<td>" . $row['quantity_value']."</td>";
                        echo "<td>" . $currency_symbol . $row['total']."</td>";
                        echo "<td>" . $row['delivery_date']."</td>";
                        echo '<td><a href="delete-order.php?id=' . $row['order_id'] . '" class="action-btn">Cancel</a></td>';
                        echo "</tr>";
                    }
                    mysqli_free_result($result);
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>