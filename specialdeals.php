<?php
//checking connection and connecting to a database
require_once('connection/config.php');
//Connect to mysqli server
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
if(!$conn) {
    die('Failed to connect to server: ' . mysqli_error());
}

//retrieve promotions from the specials table
$result=mysqli_query($conn,"SELECT * FROM specials")
or die("There are no records to display ... \n" . mysqli_error()); 

//retrieve a currency from the currencies table
$flag_1 = 1;
$currencies=mysqli_query($conn,"SELECT * FROM currencies WHERE flag='$flag_1'")
or die("A problem has occurred ... \n" . "Our team is working on it ... \n" . "Please check back later."); 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo APP_NAME ?>: Special Deals</title>
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
    background-color: #fff;
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
  
  /* Login Link */
  .login-link {
    color: #f8f3ed;
    text-decoration: none;
    padding: 8px 15px;
    margin-left: 15px;
    border: 1px solid #d4a76a;
    border-radius: 4px;
    font-size: 0.9em;
    transition: all 0.3s ease;
    display: inline-block;
  }
  
  .login-link:hover {
    background-color: #d4a76a;
    color: #4a2c12;
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
  
  /* Main Content Styles */
  .main-content {
    padding: 40px 30px;
    flex: 1;
    background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyMTgsMTY3LDEwNiwwLjAzKSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==');
  }
  
  .page-header {
    text-align: center;
    margin-bottom: 40px;
  }
  
  .page-header h1 {
    color: #5a3921;
    font-size: 2.4em;
    margin-bottom: 15px;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
  }
  
  .page-header h1:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: #d4a76a;
  }
  
  .page-header p {
    color: #6b4423;
    font-size: 1.1em;
  }
  
  /* Divider */
  .divider {
    border: 0;
    height: 1px;
    background: linear-gradient(to right, transparent, #d4a76a, transparent);
    margin: 30px 0;
  }
  
  /* Note Box */
  .note-box {
    background-color: rgba(255, 249, 240, 0.9);
    border-left: 4px solid #d4a76a;
    padding: 20px;
    margin: 30px 0;
    border-radius: 0 6px 6px 0;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  }
  
  .note-box h3 {
    color: #5a3921;
    font-family: 'Playfair Display', serif;
    margin-bottom: 10px;
  }
  
  .note-box a {
    color: #7d4e2a;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .note-box a:hover {
    color: #5a3921;
    text-decoration: underline;
  }
  
  /* Promotions Table */
  .promotions-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin: 30px 0;
    background-color: rgba(255, 249, 240, 0.9);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    border-radius: 6px;
    overflow: hidden;
  }
  
  .promotions-table caption {
    text-align: center;
    padding: 20px;
    font-family: 'Playfair Display', serif;
    font-size: 1.5em;
    color: #5a3921;
    font-weight: 700;
    caption-side: top;
  }
  
  .promotions-table th {
    background-color: #5a3921;
    color: #fff;
    padding: 15px;
    text-align: left;
    font-weight: 600;
  }
  
  .promotions-table td {
    padding: 15px;
    border-bottom: 1px solid #e8d5b5;
    vertical-align: middle;
  }
  
  .promotions-table tr:last-child td {
    border-bottom: none;
  }
  
  .promotions-table tr:nth-child(even) {
    background-color: rgba(232, 213, 181, 0.3);
  }
  
  .promotions-table tr:hover {
    background-color: rgba(212, 167, 106, 0.1);
  }
  
  .promo-photo {
    width: 80px;
    height: 70px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #e8d5b5;
    transition: transform 0.3s ease;
  }
  
  .promo-photo:hover {
    transform: scale(1.05);
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
    
    .login-link {
      margin-left: 10px;
      padding: 6px 10px;
      font-size: 0.8em;
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
    
    .main-content {
      padding: 30px 20px;
    }
    
    .page-header h1 {
      font-size: 1.8em;
    }
    
    .promotions-table {
      display: block;
      overflow-x: auto;
    }
    
    .promotions-table th, 
    .promotions-table td {
      padding: 10px;
    }
    
    .promo-photo {
      width: 60px;
      height: 50px;
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
      <li><a href="member-index.php">Home</a></li>
      <li><a href="foodzone.php">Food Zone</a></li>
      <li><a href="specialdeals.php">Special Deals</a></li>
      <li><a href="member-index.php">My Account</a></li>
      <li><a href="contactus.php">Contact Us</a></li>
    </ul>
  </div>
  
  <div class="main-content">
    <div class="page-header">
      <h1>SPECIAL DEALS</h1>
      <p>Check out our special deals below. These are for a limited time only. Make your decision now.</p>
    </div>
    
    <hr class="divider">
    
    <div class="note-box">
      <h3>Note: To order, go to <a href="foodzone.php">Food Zone</a> and choose "Specials" under categories.</h3>
    </div>
    
    <table class="promotions-table">
      <caption>CURRENT PROMOTIONS</caption>
      <tr>
        <th>Promo Photo</th>
        <th>Promo Name</th>
        <th>Description</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Price</th>
      </tr>
      <?php
        $symbol=mysqli_fetch_assoc($currencies);
        while ($row=mysqli_fetch_assoc($result)){
          echo "<tr>";
          echo '<td><a href="images/'. $row['special_photo']. '" target="_blank"><img src="images/'. $row['special_photo']. '" class="promo-photo" alt="Promo Image"></a></td>';
          echo "<td>" . $row['special_name']."</td>";
          echo "<td>" . $row['special_description']."</td>";
          echo "<td>" . $row['special_start_date']."</td>";
          echo "<td>" . $row['special_end_date']."</td>";
          echo "<td>" . $symbol['currency_symbol']. "" . $row['special_price']."</td>";
          echo "</tr>";
        }
        mysqli_free_result($result);
        mysqli_close($conn);
      ?>
    </table>
  </div>
  
  <div id="footer">
    &copy; <?php echo date("Y"); ?> <?php echo APP_NAME ?> Restaurant. All Rights Reserved.
  </div>
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