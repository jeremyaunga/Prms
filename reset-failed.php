<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'connection/config.php'; ?>
<title><?php echo APP_NAME ?>: Reset Failed</title>
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
  }
  
  body {
    display: flex;
    flex-direction: column;
  }
  
  #page {
    flex: 1 0 auto;
    width: 100%;
    margin: 0 auto;
    box-shadow: 0 5px 30px rgba(0,0,0,0.08);
    background-color: #fff;
    overflow: hidden;
    border-radius: 0 0 8px 8px;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }
  
  /* Header Styles */
  #header {
    background: linear-gradient(to right, #5a3921, #7d4e2a);
    padding: 15px 30px;
    display: flex;
    align-items: center;
    border-bottom: 4px solid #d4a76a;
    position: relative;
  }
  
  #logo {
    width: 60px;
    height: 60px;
    background-color: #d4a76a;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #5a3921;
    margin-right: 20px;
    flex-shrink: 0;
    transition: transform 0.3s ease;
  }
  
  #logo:hover {
    transform: scale(1.05);
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
  
  /* Menu Styles */
  #menu {
    background-color: #4a2c12;
    padding: 0;
    position: relative;
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
  
  #menu a:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 3px;
    background: #d4a76a;
    transition: all 0.3s ease;
    transform: translateX(-50%);
  }
  
  #menu a:hover {
    color: #d4a76a;
  }
  
  #menu a:hover:after {
    width: 70%;
  }
  
  /* Mobile Menu Button */
  .menu-toggle {
    display: none;
    background: none;
    border: none;
    color: #f8f3ed;
    font-size: 1.5em;
    cursor: pointer;
    padding: 10px 15px;
    margin-left: auto;
  }
  
  /* Center Content Styles */
  #center {
    padding: 40px 30px;
    text-align: center;
    background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyMTgsMTY3LDEwNiwwLjAzKSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==');
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  
  #center h1 {
    color: #5a3921;
    font-size: 2.4em;
    margin-bottom: 25px;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
  }
  
  #center h1:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: #d4a76a;
  }
  
  .error-box {
    background-color: rgba(255, 249, 240, 0.9);
    border-radius: 6px;
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(193, 60, 60, 0.3);
    backdrop-filter: blur(2px);
    padding: 30px;
  }
  
  .error-message {
    color: #c13c3c;
    font-size: 1.3em;
    font-weight: 600;
    margin: 20px 0;
    padding: 10px;
    background-color: rgba(193, 60, 60, 0.1);
    border-left: 4px solid #c13c3c;
    text-align: center;
  }
  
  .error-box p {
    font-size: 1.1em;
    color: #4a2c12;
    margin: 20px 0;
    line-height: 1.7;
  }
  
  .action-link {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #d4a76a;
    color: #4a2c12;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .action-link:hover {
    background-color: #bd6f2f;
    color: #fff;
  }
  
  /* Footer Styles */
  #footer {
    background-color: #4a2c12;
    color: #f8f3ed;
    padding: 20px;
    text-align: center;
    border-top: 4px solid #d4a76a;
    flex-shrink: 0;
    width: 100%;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    #header {
      padding: 15px 20px;
    }
    
    #menu ul {
      display: none;
      flex-direction: column;
      width: 100%;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #4a2c12;
      z-index: 1000;
    }
    
    #menu ul.show {
      display: flex;
    }
    
    #menu li {
      width: 100%;
      text-align: center;
    }
    
    #menu a {
      padding: 14px;
    }
    
    .menu-toggle {
      display: block;
    }
    
    #center {
      padding: 30px 20px;
    }
    
    #center h1 {
      font-size: 1.8em;
    }
    
    .error-box {
      padding: 20px;
    }
  }
</style>
</head>
<body>
<div id="page">
  <div id="header">
    <div id="logo"><a href="index.php" class="blockLink"></a></div>
    <div id="company_name"><?php echo APP_NAME ?> Restaurant</div>
    <button class="menu-toggle" id="menuToggle">
      <i class="fas fa-bars"></i>
    </button>
  </div>
  <div id="menu">
    <ul id="mainMenu">
      <li><a href="index.php">Home</a></li>
      <li><a href="foodzone.php">Food Zone</a></li>
      <li><a href="specialdeals.php">Special Deals</a></li>
      <li><a href="member-index.php">My Account</a></li>
      <li><a href="contactus.php">Contact Us</a></li>
    </ul>
  </div>
  <div id="center">
    <h1>Password Reset Failed</h1>
    <div class="error-box">
      <div class="error-message">Password Reset Failed!</div>
      <p>You are seeing this page because your attempt to reset/change/update your password has failed. This is due to wrong information provided.</p>
      <p>Please review your information and try again.</p>
      <a href="password-reset.php" class="action-link">Try Again</a>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</div>

<script>
  // Toggle mobile menu
  document.getElementById('menuToggle').addEventListener('click', function() {
    document.getElementById('mainMenu').classList.toggle('show');
  });
  
  // Close menu when clicking on a link (for mobile)
  document.querySelectorAll('#mainMenu a').forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth <= 768) {
        document.getElementById('mainMenu').classList.remove('show');
      }
    });
  });
</script>
</body>
</html>