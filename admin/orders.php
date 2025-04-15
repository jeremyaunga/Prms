<?php
require_once('auth.php');
require_once('connection/config.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if(!$conn) {
    die('Failed to connect to server: ' . mysqli_error());
}

$result = mysqli_query($conn,"SELECT * FROM orders_details o 
          INNER JOIN cart_details c ON c.cart_id = o.cart_id 
          INNER JOIN quantities q ON q.quantity_id = c.quantity_id 
          INNER JOIN members m ON m.member_id = c.member_id 
          INNER JOIN billing_details b ON b.billing_id = o.billing_id") 
          or die("There are no records to display ... \n" . mysqli_error()); 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Orders Management | Pathfinder</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style type="text/css">
    /* Consistent Pathfinder Theme */
    :root {
        --primary: #5D4037;    /* Rich brown */
        --secondary: #8D6E63;  /* Lighter brown */
        --accent: #D7CCC8;     /* Light beige */
        --highlight: #BCAAA4;   /* Medium brown */
        --light: #EFEBE9;      /* Cream */
        --dark: #3E2723;       /* Dark brown */
        --text: #4E342E;       /* Dark brown text */
        --text-light: #8D6E63;
        --success: #4CAF50;    /* Green */
        --warning: #FF9800;    /* Orange */
        --error: #D32F2F;     /* Red */
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--light);
        color: var(--text);
        line-height: 1.6;
    }
    
    #page {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    
    #header {
        background: linear-gradient(to right, var(--dark), var(--primary));
        color: white;
        padding: 1.5rem 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-bottom: 4px solid var(--highlight);
    }
    
    #header h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 2rem;
        letter-spacing: 0.5px;
    }
    
    .nav-links {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        background: var(--secondary);
        padding: 1rem 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .nav-links a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        padding: 0.5rem 0;
        transition: all 0.3s ease;
        position: relative;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .nav-links a:after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: var(--accent);
        transition: width 0.3s ease;
    }
    
    .nav-links a:hover:after,
    .nav-links a.active:after {
        width: 100%;
    }
    
    #container {
        flex: 1;
        padding: 2.5rem;
        max-width: 1400px;
        width: 100%;
        margin: 0 auto;
    }
    
    .page-title {
        color: var(--dark);
        margin-bottom: 2rem;
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 600;
        text-align: center;
        letter-spacing: 0.5px;
        position: relative;
    }
    
    .page-title:after {
        content: '';
        display: block;
        width: 100px;
        height: 3px;
        background: var(--highlight);
        margin: 0.75rem auto 0;
    }
    
    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-bottom: 3rem;
        border-left: 4px solid var(--highlight);
    }
    
    .table-container {
        overflow-x: auto;
        margin-top: 1.5rem;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.95rem;
    }
    
    .table th {
        background: var(--primary);
        color: white;
        padding: 1.25rem;
        text-align: left;
        font-weight: 500;
        letter-spacing: 0.5px;
        position: sticky;
        top: 0;
    }
    
    .table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--accent);
        vertical-align: middle;
    }
    
    .table tr:last-child td {
        border-bottom: none;
    }
    
    .table tr:hover td {
        background-color: var(--light);
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending {
        background-color: #FFF3E0;
        color: #E65100;
    }
    
    .status-completed {
        background-color: #E8F5E9;
        color: #2E7D32;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-align: center;
        letter-spacing: 0.5px;
        min-width: 100px;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn i {
        margin-right: 8px;
    }
    
    .btn-primary {
        background: var(--primary);
    }
    
    .btn-primary:hover {
        background: #4b332c;
    }
    
    .btn-success {
        background: var(--success);
    }
    
    .btn-success:hover {
        background: #3d8b40;
    }
    
    .btn-danger {
        background: var(--error);
    }
    
    .btn-danger:hover {
        background: #b71c1c;
    }
    
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        min-width: auto;
    }
    
    .action-btns {
        display: flex;
        gap: 0.5rem;
    }
    
    /* Footer */
    #footer {
        background: linear-gradient(to right, var(--dark), var(--primary));
        color: var(--accent);
        padding: 1.5rem 2rem;
        text-align: center;
        font-size: 0.9rem;
        margin-top: auto;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        #container {
            padding: 1.5rem;
        }
        
        .table th, 
        .table td {
            padding: 0.75rem;
        }
    }
    
    @media (max-width: 768px) {
        .nav-links {
            gap: 1rem;
            padding: 0.75rem 1rem;
            justify-content: center;
        }
        
        .nav-links a {
            font-size: 0.85rem;
        }
        
        #header h1 {
            font-size: 1.6rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .card {
            padding: 1.5rem;
        }
        
        .action-btns {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .btn-sm {
            width: 100%;
            justify-content: center;
        }
    }
    
    @media (max-width: 480px) {
        #container {
            padding: 1rem;
        }
        
        .table th, 
        .table td {
            padding: 0.5rem;
            font-size: 0.85rem;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
        
        .table-container {
            border-radius: 4px;
        }
    }
</style>
</head>
<body>
<div id="page">
    <div id="header">
        <h1>Pathfinder Hotel & Restaurant</h1>
    </div>
    
    <div class="nav-links">
        <a href="index.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="categories.php"><i class="fas fa-tags"></i> Categories</a>
        <a href="foods.php"><i class="fas fa-utensils"></i> Menu Items</a>
        <a href="accounts.php"><i class="fas fa-users"></i> Accounts</a>
        <a href="orders.php" class="active"><i class="fas fa-clipboard-list"></i> Orders</a>
        <a href="reservations.php"><i class="fas fa-calendar-check"></i> Reservations</a>
        <a href="specials.php"><i class="fas fa-star"></i> Specials</a>
        <a href="allocation.php"><i class="fas fa-user-tie"></i> Staff</a>
        <a href="messages.php"><i class="fas fa-envelope"></i> Messages</a>
        <a href="options.php"><i class="fas fa-cog"></i> Options</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    
    <div id="container">
        <h2 class="page-title"><i class="fas fa-clipboard-list"></i> Orders Management</h2>
        
        <div class="card">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Delivery Date</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)){
                            $lt = $row['lt'];
                            $qry = ($lt == 'food') 
                                ? "SELECT * FROM food_details f INNER JOIN categories c ON c.category_id = f.food_category WHERE food_id = {$row['food_id']}"
                                : "SELECT * FROM specials WHERE special_id = {$row['food_id']}";
                            
                            $res = mysqli_fetch_array(mysqli_query($conn,$qry));
                            
                            echo "<tr>";
                            echo "<td>#" . $row['order_id']."</td>";
                            echo "<td><strong>" . $row['firstname']." ".$row['lastname']."</strong></td>";
                            echo "<td>" . $res[$lt.'_name']."</td>";
                            echo "<td>KSh " . number_format($res[$lt.'_price'], 2)."</td>";
                            echo "<td>" . $row['quantity_value']."</td>";
                            echo "<td><strong>KSh " . number_format($row['total'], 2)."</strong></td>";
                            echo "<td>" . date('M j, Y', strtotime($row['delivery_date']))."</td>";
                            echo "<td>" . $row['Street_Address']."</td>";
                            echo "<td>" . $row['Mobile_No']."</td>";
                            echo '<td><span class="status-badge '.($row['flag'] == 1 ? 'status-completed' : 'status-pending').'">'.($row['flag'] == 1 ? 'Completed' : 'Pending').'</span></td>';
                            echo '<td>
                                    <div class="action-btns">
                                        <a href="process-order.php?id='.$row['order_id'].'&status=complete" class="btn btn-success btn-sm" title="Mark Complete"><i class="fas fa-check"></i></a>
                                        <a href="delete-order.php?id='.$row['order_id'].'" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(\'Are you sure you want to delete this order?\')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>';
                            echo "</tr>";
                        }
                        mysqli_free_result($result);
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div id="footer">
        &copy; <?php echo date("Y"); ?> Pathfinder Hotel & Restaurant. All Rights Reserved
    </div>
</div>
</body>
</html>