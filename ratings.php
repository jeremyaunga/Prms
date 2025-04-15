<?php
    require_once('auth.php');
?>
<?php
//checking connection and connecting to a database
require_once('connection/config.php');
//Connect to mysqli server
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }
    
//get member id from session
$memberId=$_SESSION['SESS_MEMBER_ID']; 

//selecting all records from the food_details table
$foods=mysqli_query($conn,"SELECT * FROM food_details")
or die("A problem has occurred ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 

//selecting all records from the ratings table
$ratings=mysqli_query($conn,"SELECT * FROM ratings")
or die("A problem has occurred ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 
?>
<?php
    //retrieving all rows from the cart_details table based on flag=0
    $flag_0 = 0;
    $items=mysqli_query($conn,"SELECT * FROM cart_details WHERE member_id='$memberId' AND flag='$flag_0'")
    or die("Something is wrong ... \n" . mysqli_error()); 
    //get the number of rows
    $num_items = mysqli_num_rows($items);
?>
<?php
    //retrieving all rows from the messages table
    $messages=mysqli_query($conn,"SELECT * FROM messages")
    or die("Something is wrong ... \n" . mysqli_error()); 
    //get the number of rows
    $num_messages = mysqli_num_rows($messages);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME ?>: Ratings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script language="JavaScript" src="validation/user.js"></script>
    <style>
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
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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
            max-width: 1500px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .welcome-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 30px 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }
        
        .welcome-header h1 {
            font-family: 'Playfair Display', serif;
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
            background: var(--bg-white);
            border-radius: 8px;
            box-shadow: var(--shadow);
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
            background: var(--primary-color);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
        }
        
        /* Rating Form */
        .rating-form {
            background: var(--bg-white);
            border-radius: 8px;
            padding: 30px;
            box-shadow: var(--shadow);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .rating-form h2 {
            color: var(--primary-color);
            margin-bottom: 25px;
            text-align: center;
            font-family: 'Playfair Display', serif;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            background-color: var(--bg-light);
        }
        
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 1em;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(189, 111, 47, 0.2);
        }
        
        .btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: var(--transition);
            display: inline-block;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        /* Rating Scale Info */
        .scale-info {
            background: var(--bg-white);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            text-align: center;
        }
        
        .scale-list {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        
        .scale-item {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            background: rgba(189, 111, 47, 0.1);
            min-width: 100px;
        }
        
        .scale-value {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        /* Navigation */
        #menu {
            background-color: #4a2c12;
            padding: 0;
        }
        
        #menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        #menu li {
            margin: 0;
        }
        
        #menu a {
            display: block;
            color: #f8f3ed;
            text-decoration: none;
            padding: 16px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.85em;
            letter-spacing: 0.5px;
            position: relative;
        }
        
        #menu a:hover {
            color: #d4a76a;
        }
        
        /* Header */
        #header {
            background: linear-gradient(to right, #5a3921, #7d4e2a);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            border-bottom: 4px solid #d4a76a;
        }
        
        #company_name {
            color: #fff;
            font-size: 1.8em;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
            letter-spacing: 0.5px;
            flex-grow: 1;
        }
        
        /* Info Box */
        .info-box {
            background: var(--bg-white);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            text-align: center;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .welcome-header h1 {
                font-size: 1.8rem;
            }
            
            .quick-links {
                justify-content: center;
            }
            
            #menu ul {
                flex-direction: column;
                align-items: center;
            }
            
            .rating-form {
                padding: 20px;
            }
            
            .scale-list {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div id="page">
        <div class="container">
            <div class="welcome-header">
                <h1>Welcome <?php echo $_SESSION['SESS_FIRST_NAME'];?></h1>
                <p>Share your dining experience with us</p>
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
                <p>We value your feedback! Please rate our food to help us improve our service.</p>
            </div>
            
            <div class="scale-info">
                <h3>Our Rating Scale</h3>
                <div class="scale-list">
                    <?php 
                    mysqli_data_seek($ratings, 0); // Reset pointer to beginning
                    while ($row=mysqli_fetch_array($ratings)): 
                    ?>
                    <div class="scale-item">
                        <div class="scale-value"><?php echo $row['rate_name']; ?></div>
                        <div><?php echo $row['rate_description']; ?></div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <div class="rating-form">
                <h2>RATE OUR FOOD</h2>
                <form name="ratingForm" id="ratingForm" method="post" action="ratings-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return ratingValidate(this)">
                    <div class="form-group">
                        <label for="food">Select Food</label>
                        <select name="food" id="food" class="form-control">
                            <option value="select">- select food -</option>
                            <?php 
                            mysqli_data_seek($foods, 0); // Reset pointer to beginning
                            while ($row=mysqli_fetch_array($foods)): 
                            ?>
                                <option value="<?php echo $row['food_id']; ?>"><?php echo $row['food_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="scale">Select Rating</label>
                        <select name="scale" id="scale" class="form-control">
                            <option value="select">- select scale -</option>
                            <?php 
                            mysqli_data_seek($ratings, 0); // Reset pointer to beginning
                            while ($row=mysqli_fetch_array($ratings)): 
                            ?>
                                <option value="<?php echo $row['rate_id']; ?>"><?php echo $row['rate_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-block">Submit Rating</button>
                </form>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>