<?php
// Database connection and queries
require_once('connection/config.php');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
if(!$conn) {
    die('Failed to connect to server: ' . mysqli_error());
}

// Get all food items initially
$result = mysqli_query($conn,"SELECT * FROM food_details,categories WHERE food_details.food_category=categories.category_id ")
or die("We're experiencing technical difficulties. Please try again later."); 

// Get categories
$categories = mysqli_query($conn,"SELECT * FROM categories")
or die("Could not load categories. Please try again later."); 

// Handle category filter
$id = 0;
if(isset($_POST['Submit'])){
    function clean($str) {
        global $conn;
        $str = trim($str);
        return mysqli_real_escape_string($conn, $str);
    }
    
    $id = clean($_POST['category']);
    
    if($id > 0){
        $result = mysqli_query($conn,"SELECT * FROM food_details,categories WHERE food_category='$id' AND food_details.food_category=categories.category_id ")
        or die("Could not load filtered items. Please try again."); 
    } elseif($id == 0) {
        $result = mysqli_query($conn,"SELECT * FROM specials WHERE '".date('Y-m-d')."' BETWEEN date(special_start_date) and date(special_end_date) ")
        or die("No specials available at this time."); 
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo APP_NAME ?>: Food Zone</title>
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
  
  /* Filter Form */
  .filter-form {
    background-color: rgba(255, 249, 240, 0.9);
    padding: 20px;
    border-radius: 6px;
    max-width: 800px;
    margin: 0 auto 40px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(189, 111, 47, 0.2);
    backdrop-filter: blur(2px);
    text-align: center;
  }
  
  .filter-form select {
    padding: 12px 20px;
    border: 1px solid #d4a76a;
    border-radius: 4px;
    background-color: #fff;
    color: #4a2c12;
    font-size: 1em;
    margin-right: 10px;
    min-width: 250px;
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%234a2c12'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 20px;
  }
  
  .filter-form input[type="submit"] {
    padding: 12px 25px;
    background-color: #5a3921;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .filter-form input[type="submit"]:hover {
    background-color: #7d4e2a;
  }
  
  /* Food Grid */
  .food-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    margin: 0 auto;
    max-width: 1200px;
  }
  
  .food-card {
    background-color: rgba(255, 249, 240, 0.9);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(189, 111, 47, 0.2);
    transition: all 0.3s ease;
  }
  
  .food-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  }
  
  .food-img-container {
    height: 200px;
    overflow: hidden;
  }
  
  .food-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
  }
  
  .food-card:hover .food-img {
    transform: scale(1.05);
  }
  
  .food-info {
    padding: 20px;
  }
  
  .food-name {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #5a3921;
    font-family: 'Playfair Display', serif;
  }
  
  .food-description {
    color: #6b4423;
    margin-bottom: 15px;
    font-size: 0.9rem;
    line-height: 1.6;
  }
  
  .food-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
  }
  
  .food-category {
    background: #e8d5b5;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    color: #5a3921;
    font-weight: 600;
  }
  
  .food-price {
    font-weight: 700;
    color: #bd6f2f;
    font-size: 1.2rem;
  }
  
  .add-to-cart {
    display: block;
    text-align: center;
    padding: 12px;
    background: #5a3921;
    color: white;
    margin-top: 20px;
    border-radius: 4px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .add-to-cart:hover {
    background: #7d4e2a;
    color: white;
  }
  
  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 50px 20px;
    background-color: rgba(255, 249, 240, 0.9);
    border-radius: 8px;
    max-width: 800px;
    margin: 0 auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(189, 111, 47, 0.2);
  }
  
  .empty-state h3 {
    color: #5a3921;
    font-family: 'Playfair Display', serif;
    margin-bottom: 15px;
  }
  
  .empty-state p {
    color: #6b4423;
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
    
    .filter-form {
      padding: 15px;
    }
    
    .filter-form select {
      min-width: 100%;
      margin-right: 0;
      margin-bottom: 10px;
    }
    
    .filter-form input[type="submit"] {
      width: 100%;
    }
    
    .food-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
<script language="JavaScript" src="validation/user.js"></script>
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
  
  <div class="main-content">
    <div class="page-header">
      <h1>CHOOSE YOUR FOOD</h1>
      <p>Browse our delicious menu or filter by category below</p>
    </div>
    
    <form name="categoryForm" id="categoryForm" method="post" action="foodzone.php" onsubmit="return categoriesValie(this)" class="filter-form">
      <select name="category" id="category">
        <option value="select">- All Categories -
        <?php 
        mysqli_data_seek($categories, 0);
        while ($row=mysqli_fetch_array($categories)){
            echo "<option value='{$row['category_id']}' ".($id == $row['category_id'] ? "selected" : "").">{$row['category_name']}</option>";
        }
        ?>
        <option value="0" <?php echo isset($id) && $id == 0 ? "selected" : "" ?>>Special Deals</option>
      </select>
      <input type="submit" name="Submit" value="Filter Foods" />
    </form>
    
    <?php
    $count = mysqli_num_rows($result);
    if(isset($_POST['Submit']) && $count < 1){
        echo '<div class="empty-state">
            <h3>No items found</h3>
            <p>There are no foods under the selected category at the moment.</p>
        </div>';
    } else {
        echo '<div class="food-grid">';
        
        $lt = (isset($id) && $id == 0) ? "special" : "food";
        mysqli_data_seek($result, 0);
        while ($row=mysqli_fetch_assoc($result)){
            echo '<div class="food-card">
                <div class="food-img-container">
                    <a href="images/'.$row[$lt.'_photo'].'" target="_blank">
                        <img src="images/'.$row[$lt.'_photo'].'" class="food-img" alt="'.$row[$lt.'_name'].'">
                    </a>
                </div>
                <div class="food-info">
                    <h3 class="food-name">'.$row[$lt.'_name'].'</h3>
                    <p class="food-description">'.$row[$lt.'_description'].'</p>
                    <div class="food-meta">
                        <span class="food-category">'.($lt == 'food' ? $row['category_name'] : 'SPECIAL DEAL').'</span>
                        <span class="food-price">KSh '.number_format($row[$lt.'_price'], 2).'</span>
                    </div>
                    <a href="cart-exec.php?id='.$row[$lt.'_id'].'&lt='.$lt.'" class="add-to-cart">Add To Cart</a>
                </div>
            </div>';
        }
        
        echo '</div>';
    }
    
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
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