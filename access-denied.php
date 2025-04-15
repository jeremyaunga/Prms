<?php require_once('connection/config.php'); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo APP_NAME; ?>: Access Denied</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
  /* Base Styles */
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #f8f3ed;
    color: #4a2c12;
    line-height: 1.6;
    display: flex;
    flex-direction: column;
  }
  
  /* Card Styles */
  .access-denied-card {
    width: 100%;
    max-width: 600px;
    margin: auto;
    background-color: rgba(255, 249, 240, 0.95);
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 1px solid rgba(189, 111, 47, 0.2);
    transform: translateY(0);
    transition: all 0.3s ease;
    text-align: center;
  }
  
  .access-denied-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
  }
  
  .card-header {
    background: linear-gradient(to right, #5a3921, #7d4e2a);
    color: #fff;
    padding: 30px;
    border-bottom: 4px solid #d4a76a;
  }
  
  .card-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
  }
  
  .card-header i {
    margin-right: 10px;
  }
  
  .card-body {
    padding: 40px 30px;
    background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyMTgsMTY3LDEwNiwwLjAzKSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==');
  }
  
  .error-icon {
    font-size: 5rem;
    color: #bd6f2f;
    margin-bottom: 20px;
  }
  
  .error-message {
    font-size: 1.3rem;
    color: #5a3921;
    margin-bottom: 30px;
    line-height: 1.6;
  }
  
  /* Button Styles */
  .btn {
    display: inline-block;
    background: linear-gradient(to right, #5a3921, #7d4e2a);
    color: #fff;
    padding: 12px 30px;
    border-radius: 4px;
    font-size: 1.1rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(90, 57, 33, 0.3);
    margin-bottom: 30px;
  }
  
  .btn:hover {
    background: linear-gradient(to right, #7d4e2a, #5a3921);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(90, 57, 33, 0.4);
  }
  
  .btn i {
    margin-right: 8px;
  }
  
  /* Navigation Links */
  .navigation {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 20px;
  }
  
  .nav-link {
    color: #5a3921;
    font-weight: 600;
    padding: 8px 15px;
    border-radius: 4px;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 0.9rem;
  }
  
  .nav-link:hover {
    color: #fff;
    background-color: #bd6f2f;
  }
  
  /* Footer Styles */
  #footer {
    background-color: #4a2c12;
    color: #f8f3ed;
    padding: 20px;
    text-align: center;
    border-top: 4px solid #d4a76a;
    width: 100%;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .access-denied-card {
      margin: 20px;
    }
    
    .card-header h1 {
      font-size: 1.8rem;
    }
    
    .error-icon {
      font-size: 4rem;
    }
    
    .error-message {
      font-size: 1.1rem;
    }
    
    .btn {
      padding: 10px 25px;
      font-size: 1rem;
    }
    
    .navigation {
      flex-direction: column;
      gap: 10px;
    }
    
    .nav-link {
      padding: 8px;
    }
  }
</style>
</head>
<body>
  <div class="access-denied-card">
    <div class="card-header">
      <h1><i class="fas fa-exclamation-triangle"></i> Access Denied</h1>
    </div>
    <div class="card-body">
      <div class="error-icon">
        <i class="fas fa-lock"></i>
      </div>
      <p class="error-message">
        You don't have permission to access this page.<br>
        Please login or register to continue.
      </p>
      <a href="login-register.php" class="btn">
        <i class="fas fa-sign-in-alt"></i> Login or Register
      </a>
      
      <div class="navigation">
        <a href="index.php" class="nav-link">Home</a>
        <a href="foodzone.php" class="nav-link">Food Zone</a>
        <a href="specialdeals.php" class="nav-link">Special Deals</a>
        <a href="contactus.php" class="nav-link">Contact Us</a>
      </div>
    </div>
  </div>
  
  <div id="footer">
    &copy; <?php echo date("Y"); ?> <?php echo APP_NAME ?> Restaurant. All Rights Reserved.
  </div>
</body>
</html>