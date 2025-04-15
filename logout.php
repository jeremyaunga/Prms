<?php
    //Start session
    session_start();
    
    //Unset the variables stored in session
    unset($_SESSION['SESS_MEMBER_ID']);
    unset($_SESSION['SESS_FIRST_NAME']);
    unset($_SESSION['SESS_LAST_NAME']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza-Inn: Logged Out</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #bd6f2f;
            --primary-dark: #9a5a26;
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
        }
        
        body, html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        .full-page-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 20px 0;
            box-shadow: var(--shadow);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .header-top {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-align: center;
        }
        
        nav {
            width: 100%;
            background-color: rgba(0,0,0,0.2);
            border-radius: 5px;
            padding: 10px;
        }
        
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            flex-wrap: wrap;
        }
        
        nav ul li {
            margin: 0 10px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: var(--transition);
            font-weight: 500;
            font-size: 1rem;
        }
        
        nav ul li a:hover {
            background-color: rgba(255,255,255,0.2);
        }
        
        .logout-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        .logout-box {
            background-color: var(--bg-white);
            border-radius: 20px;
            padding: 60px;
            box-shadow: var(--shadow);
            text-align: center;
            max-width: 600px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .logout-box::before, .logout-box::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(189, 111, 47, 0.1), transparent);
            z-index: -1;
        }
        
        .logout-box::before {
            top: -50px;
            left: -50px;
        }
        
        .logout-box::after {
            bottom: -50px;
            right: -50px;
        }
        
        .logout-box h1 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
        }
        
        .message-box {
            border: 1px solid var(--primary-color);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            background-color: rgba(189, 111, 47, 0.05);
        }
        
        .success-message {
            color: var(--primary-dark);
            font-size: 1.2rem;
            font-weight: 500;
        }
        
        .btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 500;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        footer {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 30px 0;
            text-align: center;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .bottom_menu {
            margin-bottom: 20px;
        }
        
        .bottom_menu a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            transition: var(--transition);
        }
        
        .bottom_menu a:hover {
            text-decoration: underline;
        }
        
        .bottom_addr {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        @media (max-width: 768px) {
            .logout-box {
                padding: 40px 20px;
            }
            
            .logout-box h1 {
                font-size: 2rem;
            }
            
            .message-box {
                padding: 20px;
            }
            
            nav ul {
                flex-direction: column;
                align-items: center;
            }
            
            nav ul li {
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="full-page-container">
        <header>
            <div class="header-content">
                <div class="header-top">
                    <h1>Pathfinder Hotel Restaurant</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="foodzone.php">Food Zone</a></li>
                        <li><a href="specialdeals.php">Special Deals</a></li>
                        <li><a href="member-index.php">My Account</a></li>
                        <li><a href="contactus.php">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        
        <div class="logout-container">
            <div class="logout-box">
                <h1>Logged Out</h1>
                <div class="message-box">
                    <p class="success-message">
                        <i class="fas fa-check-circle" style="color: var(--primary-color); font-size: 1.5rem; margin-right: 10px;"></i>
                        You have been successfully logged out.
                    </p>
                </div>
                <a href="login-register.php" class="btn">
                    <i class="fas fa-sign-in-alt" style="margin-right: 10px;"></i>Login Again
                </a>
            </div>
        </div>
        
        <footer>
            <div class="footer-content">
                <div class="bottom_menu">
                    <a href="admin/index.php" target="_blank">Administrator</a>
                </div>
                <div class="bottom_addr">
                    &copy; <?php echo date("Y"); ?> @whaletech codes. All Rights Reserved
                </div>
            </div>
        </footer>
    </div>
</body>
</html>