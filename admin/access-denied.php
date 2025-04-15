<?php require_once('connection/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied | <?php echo APP_NAME; ?></title>
    <style>
        /* Modern CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Beautiful Gradient Background */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #333;
            line-height: 1.6;
        }
        
        /* Stylish Card Container */
        .access-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            padding: 40px;
            text-align: center;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .access-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        /* Header Styles */
        .header {
            margin-bottom: 30px;
        }
        
        h1 {
            color: #e74c3c;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        /* Error Message */
        .error-message {
            margin: 30px 0;
            font-size: 1.5rem;
            color: #2c3e50;
            position: relative;
            padding: 20px 0;
        }
        
        .error-message:before {
            content: "⚠️";
            font-size: 3rem;
            display: block;
            margin-bottom: 20px;
        }
        
        /* Login Button */
        .login-btn {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 20px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }
        
        .login-btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }
        
        /* Footer */
        footer {
            margin-top: 40px;
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        /* Responsive Design */
        @media (max-width: 600px) {
            .access-container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .error-message {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="access-container">
        <div class="header">
            <h1>Access Denied</h1>
        </div>
        
        <div class="error-message">
            You don't have permission to access this page.
        </div>
        
        <a href="login-form.php" class="login-btn">Click Here to Login</a>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>