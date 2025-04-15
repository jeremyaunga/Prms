<?php require_once('connection/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Failed | <?php echo APP_NAME; ?></title>
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
            --error: #D32F2F;      /* Red for error messages */
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
        
        /* Error Card */
        .error-card {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transform: translateY(0);
            transition: all 0.3s ease;
            border-left: 4px solid var(--error);
        }
        
        .error-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
        
        /* Header */
        .error-header {
            background: linear-gradient(to right, var(--dark), var(--primary));
            color: white;
            padding: 2rem;
            border-bottom: 4px solid var(--highlight);
        }
        
        .error-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        /* Content */
        .error-content {
            padding: 2.5rem 2rem;
        }
        
        .error-icon {
            font-size: 4rem;
            color: var(--error);
            margin-bottom: 1.5rem;
        }
        
        .error-message {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--error);
            font-family: 'Playfair Display', serif;
        }
        
        .error-description {
            margin-bottom: 2rem;
            font-size: 1rem;
            line-height: 1.6;
            color: var(--text);
        }
        
        /* Try Again Button */
        .try-again-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: var(--primary);
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            min-width: 180px;
        }
        
        .try-again-btn:hover {
            background: var(--dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        /* Footer */
        .error-footer {
            background: var(--dark);
            color: var(--accent);
            padding: 1.5rem;
            font-size: 0.85rem;
            border-top: 1px solid rgba(215, 204, 200, 0.2);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .page-wrapper {
                padding: 1.5rem;
            }
            
            .error-header {
                padding: 1.75rem;
            }
            
            .error-header h1 {
                font-size: 1.6rem;
            }
            
            .error-content {
                padding: 2rem 1.5rem;
            }
            
            .error-icon {
                font-size: 3.5rem;
            }
            
            .error-message {
                font-size: 1.3rem;
            }
        }
        
        @media (max-width: 480px) {
            .page-wrapper {
                padding: 1rem;
            }
            
            .error-header {
                padding: 1.5rem 1rem;
            }
            
            .error-header h1 {
                font-size: 1.4rem;
            }
            
            .error-content {
                padding: 1.75rem 1.25rem;
            }
            
            .error-icon {
                font-size: 3rem;
            }
            
            .error-message {
                font-size: 1.2rem;
            }
            
            .error-description {
                font-size: 0.95rem;
            }
            
            .try-again-btn {
                padding: 0.9rem 1.5rem;
                font-size: 0.95rem;
                min-width: 160px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="error-card">
            <div class="error-header">
                <h1>Login Failed</h1>
            </div>
            
            <div class="error-content">
                <div class="error-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                
                <h2 class="error-message">Login Failed!</h2>
                
                <p class="error-description">
                    Please check your username and password and try again.
                </p>
                
                <a href="login-form.php" class="try-again-btn">
                    <i class="fas fa-redo"></i> Try Again
                </a>
            </div>
            
            <div class="error-footer">
                &copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>
            </div>
        </div>
    </div>
</body>
</html>