<?php 
require_once('auth.php');
require_once('connection/config.php');

// Database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if(!$conn) {
    die('Failed to connect to server: ' . mysqli_error($conn));
}

$flag_1 = 1;

// Dashboard statistics queries
$members = mysqli_query($conn, "SELECT * FROM members") or die(mysqli_error($conn)); 
$orders_placed = mysqli_query($conn, "SELECT * FROM orders_details") or die(mysqli_error($conn));
$orders_processed = mysqli_query($conn, "SELECT * FROM orders_details WHERE flag='$flag_1'") or die(mysqli_error($conn));
$tables_reserved = mysqli_query($conn, "SELECT * FROM reservations_details WHERE table_flag='$flag_1'") or die(mysqli_error($conn));
$partyhalls_reserved = mysqli_query($conn, "SELECT * FROM reservations_details WHERE partyhall_flag='$flag_1'") or die(mysqli_error($conn));
$tables_allocated = mysqli_query($conn, "SELECT * FROM reservations_details WHERE flag='$flag_1' AND table_flag='$flag_1'") or die(mysqli_error($conn));
$partyhalls_allocated = mysqli_query($conn, "SELECT * FROM reservations_details WHERE flag='$flag_1' AND partyhall_flag='$flag_1'") or die(mysqli_error($conn));
$foods = mysqli_query($conn, "SELECT * FROM food_details") or die(mysqli_error($conn));

// Initialize rating variables
$food_name = '';
$excellent_value = $good_value = $average_value = $bad_value = $worse_value = 0;
$excellent_rate = $good_rate = $average_rate = $bad_rate = $worse_rate = '0%';

// Rating processing logic
if(isset($_POST['Submit'])){
    function clean($str, $conn) {
        $str = trim($str);
        return mysqli_real_escape_string($conn, $str);
    }
    
    $id = clean($_POST['food'], $conn);
    
    if($id != 'select') {
        // Get food name using prepared statement
        $stmt = $conn->prepare("SELECT food_name FROM food_details WHERE food_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $food_row = $result->fetch_assoc();
        $food_name = $food_row['food_name'];
        $stmt->close();
        
        // Get ratings counts using prepared statements
        $ratings = [
            'excellent' => 5,
            'good' => 4,
            'average' => 3, 
            'bad' => 2,
            'worse' => 1
        ];
        
        foreach($ratings as $key => $value) {
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM ratings WHERE food_id=? AND rating_value=?");
            $stmt->bind_param("ii", $id, $value);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            ${$key.'_value'} = $row['count'];
            $stmt->close();
        }
        
        // Calculate percentages
        $total = $excellent_value + $good_value + $average_value + $bad_value + $worse_value;
        
        if($total > 0) {
            $excellent_rate = round(($excellent_value/$total)*100, 1).'%';
            $good_rate = round(($good_value/$total)*100, 1).'%';
            $average_rate = round(($average_value/$total)*100, 1).'%';
            $bad_rate = round(($bad_value/$total)*100, 1).'%';
            $worse_rate = round(($worse_value/$total)*100, 1).'%';
        }
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Pathfinder</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style type="text/css">
    /* Consistent Pathfinder Theme */
    :root {
        --primary: #5D4037;
        --secondary: #8D6E63;
        --accent: #D7CCC8;
        --highlight: #BCAAA4;
        --light: #EFEBE9;
        --dark: #3E2723;
        --text: #4E342E;
        --text-light: #8D6E63;
        --success: #4CAF50;
        --warning: #FF9800;
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
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border-top: 4px solid var(--primary);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    
    .stat-card.pending {
        border-top-color: var(--warning);
    }
    
    .stat-card.completed {
        border-top-color: var(--success);
    }
    
    .stat-card h3 {
        color: var(--secondary);
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-card .value {
        font-size: 2rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }
    
    .stat-card .description {
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .divider {
        height: 1px;
        background: linear-gradient(to right, transparent, var(--secondary), transparent);
        margin: 3rem 0;
        opacity: 0.5;
    }
    
    .rating-form {
        background: white;
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
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
        min-width: 180px;
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
    
    .rating-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 2rem;
        font-size: 0.95rem;
    }
    
    .rating-table th {
        background: var(--primary);
        color: white;
        padding: 1.25rem;
        text-align: center;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    .rating-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--accent);
        text-align: center;
    }
    
    .rating-table tr:last-child td {
        border-bottom: none;
    }
    
    .rating-table tr:hover td {
        background-color: var(--light);
    }
    
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
        
        #container {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr));
        }
        
        .nav-links {
            gap: 1rem;
        }
        
        #header h1 {
            font-size: 1.6rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .stat-card {
            padding: 1.25rem;
        }
        
        .stat-card .value {
            font-size: 1.75rem;
        }
    }
    
    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        #container {
            padding: 1rem;
        }
        
        .rating-table th, 
        .rating-table td {
            padding: 0.75rem;
            font-size: 0.85rem;
        }
    }
</style>
</head>
<body>
<div id="page">
    <div id="header">
        <h1>Pathfinder Hotel & Restaurant</h1>
        <div class="nav-links">
            <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
            <a href="categories.php"><i class="fas fa-tags"></i> Categories</a>
            <a href="foods.php"><i class="fas fa-utensils"></i> Foods</a>
            <a href="accounts.php"><i class="fas fa-users"></i> Accounts</a>
            <a href="orders.php"><i class="fas fa-clipboard-list"></i> Orders</a>
            <a href="reservations.php"><i class="fas fa-calendar-check"></i> Reservations</a>
            <a href="specials.php"><i class="fas fa-star"></i> Specials</a>
            <a href="allocation.php"><i class="fas fa-user-tie"></i> Staff</a>
            <a href="messages.php"><i class="fas fa-envelope"></i> Messages</a>
            <a href="options.php"><i class="fas fa-cog"></i> Options</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div id="container">
        <h2 class="page-title"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>
        
        <div class="card">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3><i class="fas fa-users"></i> Members Registered</h3>
                    <div class="value"><?php echo mysqli_num_rows($members); ?></div>
                    <div class="description">Total customer accounts</div>
                </div>
                
                <div class="stat-card pending">
                    <h3><i class="fas fa-shopping-basket"></i> Orders Placed</h3>
                    <div class="value"><?php echo mysqli_num_rows($orders_placed); ?></div>
                    <div class="description">Total orders received</div>
                </div>
                
                <div class="stat-card completed">
                    <h3><i class="fas fa-check-circle"></i> Orders Processed</h3>
                    <div class="value"><?php echo mysqli_num_rows($orders_processed); ?></div>
                    <div class="description">Completed orders</div>
                </div>
                
                <div class="stat-card pending">
                    <h3><i class="fas fa-clock"></i> Orders Pending</h3>
                    <div class="value"><?php echo mysqli_num_rows($orders_placed) - mysqli_num_rows($orders_processed); ?></div>
                    <div class="description">Awaiting processing</div>
                </div>
                
                <div class="stat-card">
                    <h3><i class="fas fa-chair"></i> Tables Reserved</h3>
                    <div class="value"><?php echo mysqli_num_rows($tables_reserved); ?></div>
                    <div class="description">Total table reservations</div>
                </div>
                
                <div class="stat-card completed">
                    <h3><i class="fas fa-check-circle"></i> Tables Allocated</h3>
                    <div class="value"><?php echo mysqli_num_rows($tables_allocated); ?></div>
                    <div class="description">Confirmed assignments</div>
                </div>
                
                <div class="stat-card pending">
                    <h3><i class="fas fa-clock"></i> Tables Pending</h3>
                    <div class="value"><?php echo mysqli_num_rows($tables_reserved) - mysqli_num_rows($tables_allocated); ?></div>
                    <div class="description">Awaiting confirmation</div>
                </div>
                
                <div class="stat-card">
                    <h3><i class="fas fa-glass-cheers"></i> PartyHalls Reserved</h3>
                    <div class="value"><?php echo mysqli_num_rows($partyhalls_reserved); ?></div>
                    <div class="description">Total party hall bookings</div>
                </div>
                
                <div class="stat-card completed">
                    <h3><i class="fas fa-check-circle"></i> PartyHalls Allocated</h3>
                    <div class="value"><?php echo mysqli_num_rows($partyhalls_allocated); ?></div>
                    <div class="description">Confirmed assignments</div>
                </div>
                
                <div class="stat-card pending">
                    <h3><i class="fas fa-clock"></i> PartyHalls Pending</h3>
                    <div class="value"><?php echo mysqli_num_rows($partyhalls_reserved) - mysqli_num_rows($partyhalls_allocated); ?></div>
                    <div class="description">Awaiting confirmation</div>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div class="rating-form">
                <h3 style="color: var(--dark); margin-bottom: 1.5rem; text-align: center;">
                    <i class="fas fa-star"></i> Customer Ratings Analysis
                </h3>
                
                <form name="foodStatusForm" id="foodStatusForm" method="post" action="">
                    <div class="form-group">
                        <label for="food"><i class="fas fa-utensils"></i> Select Food to View Ratings</label>
                        <select name="food" id="food" class="form-control" required>
                            <option value="select">- select food -
                            <?php 
                            mysqli_data_seek($foods, 0); // Reset pointer to beginning
                            while ($row = mysqli_fetch_array($foods)): ?>
                                <option value="<?php echo $row['food_id']; ?>" <?php echo (isset($_POST['food']) && $_POST['food'] == $row['food_id']) ? 'selected' : ''; ?>>
                                    <?php echo $row['food_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group" style="text-align: center;">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-chart-bar"></i> Show Ratings
                        </button>
                    </div>
                </form>
            </div>
            
            <?php if(isset($_POST['Submit']) && $_POST['food'] != 'select'): ?>
            <table class="rating-table">
                <thead>
                    <tr>
                        <th>Food Item</th>
                        <th>Excellent (5★)</th>
                        <th>Good (4★)</th>
                        <th>Average (3★)</th>
                        <th>Bad (2★)</th>
                        <th>Worse (1★)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($food_name); ?></td>
                        <td><?php echo htmlspecialchars($excellent_value." (".$excellent_rate.")"); ?></td>
                        <td><?php echo htmlspecialchars($good_value." (".$good_rate.")"); ?></td>
                        <td><?php echo htmlspecialchars($average_value." (".$average_rate.")"); ?></td>
                        <td><?php echo htmlspecialchars($bad_value." (".$bad_rate.")"); ?></td>
                        <td><?php echo htmlspecialchars($worse_value." (".$worse_rate.")"); ?></td>
                    </tr>
                </tbody>
            </table>
            <?php elseif(isset($_POST['Submit'])): ?>
                <div style="text-align: center; color: var(--warning); margin-top: 1rem;">
                    Please select a food item to view ratings.
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</div>
</body>
</html>
<?php
// Close database connections
mysqli_free_result($members);
mysqli_free_result($orders_placed);
mysqli_free_result($orders_processed);
mysqli_free_result($tables_reserved);
mysqli_free_result($partyhalls_reserved);
mysqli_free_result($tables_allocated);
mysqli_free_result($partyhalls_allocated);
mysqli_free_result($foods);
mysqli_close($conn);
?>