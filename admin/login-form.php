<?php require_once('connection/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?php echo APP_NAME; ?></title>
    <style>
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
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--text);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .page-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            width: 100%;
        }
        
        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        /* Header */
        .login-header {
            background: linear-gradient(to right, var(--dark), var(--primary));
            color: white;
            padding: 2rem;
            text-align: center;
            border-bottom: 4px solid var(--highlight);
        }
        
        .login-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .login-header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Form */
        .login-form {
            padding: 2rem;
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
        
        /* Login Button */
        .login-btn {
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .login-btn:hover {
            background: var(--dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        /* Footer */
        .login-footer {
            background: var(--dark);
            color: var(--accent);
            text-align: center;
            padding: 1.5rem;
            font-size: 0.85rem;
            border-top: 1px solid rgba(215, 204, 200, 0.2);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .page-wrapper {
                padding: 1.5rem;
            }
            
            .login-header {
                padding: 1.75rem;
            }
            
            .login-header h1 {
                font-size: 1.6rem;
            }
            
            .login-form {
                padding: 1.75rem;
            }
        }
        
        @media (max-width: 480px) {
            .page-wrapper {
                padding: 1rem;
            }
            
            .login-header {
                padding: 1.5rem 1rem;
            }
            
            .login-header h1 {
                font-size: 1.4rem;
            }
            
            .login-header p {
                font-size: 0.8rem;
            }
            
            .login-form {
                padding: 1.5rem 1.25rem;
            }
            
            .form-control {
                padding: 0.9rem 1.1rem;
            }
            
            .login-btn {
                padding: 0.9rem;
                font-size: 0.95rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h1>Administrator Login</h1>
                <p>Pathfinder Restaurant Management System</p>
            </div>
            
            <form id="loginForm" name="loginForm" method="post" action="login-exec.php" onsubmit="return loginValidate(this)" class="login-form">
                <div class="form-group">
                    <label for="login"><i class="fas fa-user"></i> Username</label>
                    <input type="text" class="form-control" id="login" name="login" required>
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
            
            <div class="login-footer">
                &copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>
            </div>
        </div>
    </div>
    
    <script src="validation/admin.js"></script>
</body>
</html>