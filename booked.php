<?php require_once('connection/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME ?>: Registration Failed</title>
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
        
        /* Error Box */
        .error-box {
            background: var(--bg-white);
            border-radius: 8px;
            padding: 40px;
            box-shadow: var(--shadow);
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .error-box h1 {
            color: var(--primary-color);
            font-family: 'Playfair Display', serif;
            margin-bottom: 25px;
        }
        
        .error-message {
            background-color: rgba(232, 163, 90, 0.2);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            color: var(--primary-dark);
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: var(--transition);
            margin-top: 20px;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
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
            
            #menu ul {
                flex-direction: column;
                align-items: center;
            }
            
            .error-box {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div id="page">
        <div class="container">
            <div class="welcome-header">
                <h1>Registration Failed</h1>
            </div>
            
            <div class="error-box">
                <h1>Reservation Unavailable</h1>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    The party hall you selected has already been booked.
                </div>
                <p>Please try selecting a different date/time or choose another party hall.</p>
                <a href="partyhalls.php" class="btn">
                    <i class="fas fa-calendar-alt"></i> Try Again
                </a>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>