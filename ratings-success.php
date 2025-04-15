<?php
// Rating Success Page (rating-success.php)
require_once('connection/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME ?>: Rating Success</title>
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
        
        .success-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        .success-box {
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
        
        .success-box::before, .success-box::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(189, 111, 47, 0.1), transparent);
            z-index: -1;
        }
        
        .success-box::before {
            top: -50px;
            left: -50px;
        }
        
        .success-box::after {
            bottom: -50px;
            right: -50px;
        }
        
        .success-box h1 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
        }
        
        .success-message {
            border: 1px solid var(--primary-color);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            background-color: rgba(189, 111, 47, 0.05);
        }
        
        .success-icon {
            color: #28a745;
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .success-text {
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
        
        @media (max-width: 768px) {
            .success-box {
                padding: 40px 20px;
            }
            
            .success-box h1 {
                font-size: 2rem;
            }
            
            .success-message {
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
                    <h1><?php echo APP_NAME ?> Restaurant</h1>
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
        
        <div class="success-container">
            <div class="success-box">
                <h1>Rating Successful</h1>
                <div class="success-message">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="success-text">The food has been rated successfully!</p>
                </div>
                <a href="member-index.php" class="btn">
                    <i class="fas fa-user" style="margin-right: 10px;"></i>Return to Your Account
                </a>
            </div>
        </div>
        
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>