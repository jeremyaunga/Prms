<?php
	//Start session
	session_start();
	
	//Unset the variables stored in session
	unset($_SESSION['SESS_ADMIN_ID']);
	unset($_SESSION['SESS_ADMIN_NAME']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logged Out</title>
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
    
    #page {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        width: 100%;
    }
    
    #header {
        background: linear-gradient(to right, var(--dark), var(--primary));
        color: white;
        padding: 2.5rem 2rem;
        text-align: center;
        border-bottom: 4px solid var(--highlight);
    }
    
    #header h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        font-size: 2rem;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    
    .main-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .logout-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        padding: 3rem 2rem;
        text-align: center;
        width: 100%;
    }
    
    .err {
        color: var(--primary);
        font-size: 1.2rem;
        margin-bottom: 2rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .err i {
        font-size: 1.5rem;
    }
    
    .login-link {
        display: inline-block;
        margin-top: 1.5rem;
        padding: 0.75rem 1.75rem;
        background: var(--primary);
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 2px solid var(--primary);
    }
    
    .login-link:hover {
        background: white;
        color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    #footer {
        background: var(--dark);
        color: var(--accent);
        padding: 1.5rem;
        text-align: center;
        font-size: 0.9rem;
        margin-top: auto;
        width: 100%;
    }
    
    .bottom_addr {
        color: var(--accent);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        #header {
            padding: 2rem 1.5rem;
        }
        
        #header h1 {
            font-size: 1.8rem;
        }
        
        .logout-container {
            padding: 2.5rem 1.5rem;
        }
        
        .err {
            font-size: 1.1rem;
        }
    }
    
    @media (max-width: 576px) {
        #header {
            padding: 1.5rem 1rem;
        }
        
        #header h1 {
            font-size: 1.5rem;
        }
        
        .main-content {
            padding: 1.5rem;
        }
        
        .logout-container {
            padding: 2rem 1.5rem;
        }
        
        .err {
            font-size: 1rem;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .err i {
            font-size: 1.25rem;
        }
        
        .login-link {
            padding: 0.6rem 1.25rem;
            font-size: 0.9rem;
        }
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div id="page">
    <div id="header">
        <h1>Pathfinder Hotel & Restaurant</h1>
    </div>
    
    <div class="main-content">
        <div class="logout-container">
            <h4 class="err"><i class="fas fa-check-circle"></i> You have been successfully logged out.</h4>
            <a href="login-form.php" class="login-link">
                <i class="fas fa-sign-in-alt"></i> Return to Login Page
            </a>
        </div>
    </div>
    
    <div id="footer">
        <div class="bottom_addr">&copy; <?php echo date('Y'); ?> Pathfinder Hotel Restaurant. All Rights Reserved</div>
    </div>
</div>
</body>
</html>