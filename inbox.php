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
    <title><?php echo APP_NAME ?>: Messages</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        
        /* Messages Table */
        .messages-box {
            background: var(--bg-white);
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow-x: auto;
        }
        
        .messages-box h2 {
            padding: 20px;
            background: #f8f8f8;
            border-bottom: 1px solid #eee;
            color: var(--primary-color);
            font-family: 'Playfair Display', serif;
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
        
        .info-box {
            background: var(--bg-white);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
        }
        
        .info-box p {
            margin-bottom: 15px;
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
            
            th, td {
                padding: 10px 8px;
                font-size: 0.9rem;
                display: block;
                width: 100%;
            }
            
            tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #eee;
            }
        }
    </style>
</head>
<body>
    <div id="page">
        
        <div class="container">
            <div class="welcome-header">
                <h1>Welcome <?php echo $_SESSION['SESS_FIRST_NAME'];?></h1>
                <p>View and manage your messages</p>
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
                <p>Here you can view all messages sent to you. For more information <a href="contactus.php">contact us</a>.</p>
            </div>
            
            <div class="messages-box">
                <h2>INBOX</h2>
                <table>
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Date Received</th>
                            <th>Time Received</th>
                            <th>Subject</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //loop through all table rows
                        while ($row=mysqli_fetch_array($messages)){
                            echo "<tr>";
                            echo "<td>" . $row['message_from']."</td>";
                            echo "<td>" . $row['message_date']."</td>";
                            echo "<td>" . $row['message_time']."</td>";
                            echo "<td>" . $row['message_subject']."</td>";
                            echo "<td>" . $row['message_text']."</td>";
                            echo "</tr>";
                        }
                        mysqli_free_result($messages);
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>