<?php
require_once('auth.php');
require_once('connection/config.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if(!$conn) {
    die('Failed to connect to server: ' . mysqli_error());
}

$tables = mysqli_query($conn,"SELECT members.firstname, members.lastname, reservations_details.ReservationID, reservations_details.table_id, reservations_details.Reserve_Date, reservations_details.Reserve_Time, tables.table_id, tables.table_name FROM members, reservations_details, tables WHERE members.member_id = reservations_details.member_id AND tables.table_id=reservations_details.table_id")
or die("There are no records to display ... \n" . mysqli_error()); 

$partyhalls = mysqli_query($conn,"SELECT members.firstname, members.lastname, reservations_details.ReservationID, reservations_details.partyhall_id, reservations_details.Reserve_Date, reservations_details.Reserve_Time, partyhalls.partyhall_id, partyhalls.partyhall_name FROM members, reservations_details, partyhalls WHERE members.member_id = reservations_details.member_id AND partyhalls.partyhall_id=reservations_details.partyhall_id")
or die("There are no records to display ... \n" . mysqli_error()); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations Management | Pathfinder</title>
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
        
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--secondary), transparent);
            margin: 3rem 0;
            opacity: 0.5;
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
            <a href="reservations.php" class="active"><i class="fas fa-calendar-check"></i> Reservations</a>
            <a href="specials.php"><i class="fas fa-star"></i> Specials</a>
            <a href="allocation.php"><i class="fas fa-user-tie"></i> Staff</a>
            <a href="messages.php"><i class="fas fa-envelope"></i> Messages</a>
            <a href="options.php"><i class="fas fa-cog"></i> Options</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div id="container">
        <h2 class="page-title"><i class="fas fa-calendar-check"></i> Reservations Management</h2>
        
        <div class="card">
            <h3 class="section-title"><i class="fas fa-chair"></i> Tables Reserved</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Table Name</th>
                        <th>Reserved Date</th>
                        <th>Reserved Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($tables)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['ReservationID']); ?></td>
                        <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($row['table_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Reserve_Date']); ?></td>
                        <td><?php echo htmlspecialchars($row['Reserve_Time']); ?></td>
                        <td>
                            <a href="delete-reservation.php?id=<?php echo $row['ReservationID']; ?>" class="action-btn">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <div class="divider"></div>
            
            <h3 class="section-title"><i class="fas fa-glass-cheers"></i> Party Halls Reserved</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>PartyHall Name</th>
                        <th>Reserved Date</th>
                        <th>Reserved Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($partyhalls)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['ReservationID']); ?></td>
                        <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($row['partyhall_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Reserve_Date']); ?></td>
                        <td><?php echo htmlspecialchars($row['Reserve_Time']); ?></td>
                        <td>
                            <a href="delete-reservation.php?id=<?php echo $row['ReservationID']; ?>" class="action-btn">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</div>
</body>
</html>
<?php
mysqli_free_result($tables);
mysqli_free_result($partyhalls);
mysqli_close($conn);
?>