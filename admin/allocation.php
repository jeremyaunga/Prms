<?php
require_once('auth.php');
require_once('connection/config.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if(!$conn) {
    die('Failed to connect to server: ' . mysqli_error());
}

$staff = mysqli_query($conn,"SELECT * FROM staff")
or die("There are no records to display ... \n" . mysqli_error()); 

$flag_0 = 0;
$orders = mysqli_query($conn,"SELECT * FROM orders_details WHERE flag='$flag_0'")
or die("There are no records to display ... \n" . mysqli_error()); 

$reservations = mysqli_query($conn,"SELECT * FROM reservations_details WHERE flag='$flag_0'")
or die("There are no records to display ... \n" . mysqli_error()); 

$staff_1 = mysqli_query($conn,"SELECT * FROM staff")
or die("There are no records to display ... \n" . mysqli_error());

$staff_2 = mysqli_query($conn,"SELECT * FROM staff")
or die("There are no records to display ... \n" . mysqli_error());
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Allocation | Pathfinder</title>
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
        --success: #4CAF50;    /* Green for positive metrics */
        --warning: #FF9800;    /* Orange for pending metrics */
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
    }
    
    .nav-links a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        padding: 0.25rem 0;
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
    
    .section-title {
        color: var(--dark);
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        color: var(--secondary);
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
        font-size: 0.95rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
        border-radius: 8px;
    }
    
    .data-table th {
        background: var(--primary);
        color: white;
        padding: 1.25rem;
        text-align: left;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--accent);
    }
    
    .data-table tr:last-child td {
        border-bottom: none;
    }
    
    .data-table tr:hover td {
        background-color: var(--light);
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        background: var(--secondary);
        color: white;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        gap: 0.5rem;
    }
    
    .action-btn:hover {
        background: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .action-btn i {
        font-size: 0.8rem;
    }
    
    .allocation-form {
        background: white;
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 500;
        color: var(--dark);
    }
    
    .form-control {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 1px solid var(--accent);
        border-radius: 4px;
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #fafafa;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(93, 64, 55, 0.1);
        background-color: white;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 2rem;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-align: center;
        letter-spacing: 0.5px;
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
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .divider {
        height: 1px;
        background: linear-gradient(to right, transparent, var(--secondary), transparent);
        margin: 2rem 0;
        opacity: 0.5;
    }
    
    .required {
        color: #e53935;
        margin-left: 4px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        #container {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .nav-links {
            gap: 1rem;
        }
        
        #header h1 {
            font-size: 1.6rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .data-table {
            display: block;
            overflow-x: auto;
        }
    }
    
    @media (max-width: 480px) {
        #container {
            padding: 1rem;
        }
        
        .data-table th, 
        .data-table td {
            padding: 0.75rem;
            font-size: 0.85rem;
        }
        
        .action-btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
    }
</style>
<script language="JavaScript" src="validation/admin.js"></script>
</head>
<body>
<div id="page">
    <div id="header">
        <h1>Pathfinder Hotel & Restaurant</h1>
        <div class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="categories.php"><i class="fas fa-tags"></i> Categories</a>
            <a href="foods.php"><i class="fas fa-utensils"></i> Foods</a>
            <a href="accounts.php"><i class="fas fa-users"></i> Accounts</a>
            <a href="orders.php"><i class="fas fa-clipboard-list"></i> Orders</a>
            <a href="reservations.php"><i class="fas fa-calendar-check"></i> Reservations</a>
            <a href="specials.php"><i class="fas fa-star"></i> Specials</a>
            <a href="allocation.php" class="active"><i class="fas fa-user-tie"></i> Staff</a>
            <a href="messages.php"><i class="fas fa-envelope"></i> Messages</a>
            <a href="options.php"><i class="fas fa-cog"></i> Options</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div id="container">
        <h2 class="page-title"><i class="fas fa-user-tie"></i> Staff Allocation Management</h2>
        
        <div class="card">
            <h3 class="section-title"><i class="fas fa-users"></i> Staff List</h3>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Street Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($staff)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['StaffID']); ?></td>
                        <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($row['Street_Address']); ?></td>
                        <td>
                            <a href="delete-staff.php?id=<?php echo $row['StaffID']; ?>" class="action-btn">
                                <i class="fas fa-trash-alt"></i> Remove
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <div class="divider"></div>
            
            <div class="form-row">
                <div class="allocation-form">
                    <h3 class="section-title"><i class="fas fa-clipboard-list"></i> Orders Allocation</h3>
                    
                    <form id="ordersAllocationForm" name="ordersAllocationForm" method="post" action="orders-allocation.php" onsubmit="return ordersAllocationValidate(this)">
                        <div class="form-group">
                            <label for="orderid"><i class="fas fa-list-ol"></i> Order ID <span class="required">*</span></label>
                            <select name="orderid" id="orderid" class="form-control" required>
                                <option value="select">- select order -
                                <?php while ($row = mysqli_fetch_array($orders)): ?>
                                    <option value="<?php echo $row['order_id']; ?>"><?php echo $row['order_id']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="staffid"><i class="fas fa-user-tie"></i> Staff ID <span class="required">*</span></label>
                            <select name="staffid" id="staffid" class="form-control" required>
                                <option value="select">- select staff -
                                <?php while ($row = mysqli_fetch_array($staff_1)): ?>
                                    <option value="<?php echo $row['StaffID']; ?>"><?php echo $row['StaffID'] . " - " . $row['firstname'] . " " . $row['lastname']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group" style="text-align: center;">
                            <button type="submit" name="Submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Allocate Staff
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="allocation-form">
                    <h3 class="section-title"><i class="fas fa-calendar-check"></i> Reservations Allocation</h3>
                    
                    <form id="reservationsAllocationForm" name="reservationsAllocationForm" method="post" action="reservations-allocation.php" onsubmit="return reservationsAllocationValidate(this)">
                        <div class="form-group">
                            <label for="reservationid"><i class="fas fa-list-ol"></i> Reservation ID <span class="required">*</span></label>
                            <select name="reservationid" id="reservationid" class="form-control" required>
                                <option value="select">- select reservation -
                                <?php while ($row = mysqli_fetch_array($reservations)): ?>
                                    <option value="<?php echo $row['ReservationID']; ?>"><?php echo $row['ReservationID']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="staffid"><i class="fas fa-user-tie"></i> Staff ID <span class="required">*</span></label>
                            <select name="staffid" id="staffid" class="form-control" required>
                                <option value="select">- select staff -
                                <?php while ($row = mysqli_fetch_array($staff_2)): ?>
                                    <option value="<?php echo $row['StaffID']; ?>"><?php echo $row['StaffID'] . " - " . $row['firstname'] . " " . $row['lastname']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group" style="text-align: center;">
                            <button type="submit" name="Submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Allocate Staff
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</div>
</body>
</html>
<?php
mysqli_free_result($staff);
mysqli_free_result($orders);
mysqli_free_result($reservations);
mysqli_free_result($staff_1);
mysqli_free_result($staff_2);
mysqli_close($conn);
?>