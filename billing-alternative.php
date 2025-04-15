<?php
    require_once('auth.php');
    require_once('connection/config.php');
    
    // Connect to database
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }
    
    // Check if cart_id was passed from previous page
    $cart_id = isset($_GET['cart_id']) ? intval($_GET['cart_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME ?>: Billing Address</title>
    <style>
        /* Modern styling while maintaining original color scheme */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        
        #page {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        #header {
            background: #bd6f2f;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        #logo a {
            display: block;
            height: 100%;
        }
        
        #company_name {
            font-size: 1.5rem;
            margin-top: 10px;
        }
        
        #menu {
            background: #333;
        }
        
        #menu ul {
            list-style: none;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        #menu li {
            padding: 15px 20px;
        }
        
        #menu a {
            color: white;
            font-weight: bold;
        }
        
        #menu a:hover {
            color: #bd6f2f;
        }
        
        #center {
            padding: 20px;
        }
        
        h1 {
            color: #bd6f2f;
            margin-bottom: 15px;
        }
        
        hr {
            border: 0;
            height: 1px;
            background: #ddd;
            margin: 15px 0;
        }
        
        .form-container {
            border: 1px solid #bd6f2f;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            background: white;
        }
        
        table {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
        }
        
        .textfield {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        input[type="submit"] {
            background: #bd6f2f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background: #8a4f1a;
        }
        
        .required {
            color: #e74c3c;
        }
        
        @media (max-width: 768px) {
            #menu ul {
                flex-direction: column;
                align-items: center;
            }
            
            #menu li {
                padding: 10px;
            }
        }
    </style>
    <script language="JavaScript" src="validation/user.js"></script>
</head>
<body>
<div id="page">
  <div id="menu">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="foodzone.php">Food Zone</a></li>
      <li><a href="specialdeals.php">Special Deals</a></li>
      <li><a href="member-index.php">My Account</a></li>
      <li><a href="contactus.php">Contact Us</a></li>
    </ul>
  </div>
  
  <div id="header">
    <div id="logo"><a href="index.php" class="blockLink"></a></div>
    <div id="company_name"><?php echo APP_NAME ?> Restaurant</div>
  </div>
  
  <div id="center">
    <h1>Billing Address</h1>
    <hr>
    <p>We have found out that you don't have a billing address in your account. Please add a billing address in the form below. It is the same address that will be used to deliver your food orders. Please note that ONLY correct street/physical addresses should be used in order to ensure smooth delivery of your food orders. For more information <a href="contactus.php">Click Here</a> to contact us.</p>
    
    <div class="form-container">
      <form id="billingForm" name="billingForm" method="post" action="billing-exec.php?cart_id=<?php echo $cart_id; ?>" onsubmit="return billingValidate(this)">
        <table>
          <caption><h3>ADD DELIVERY/BILLING ADDRESS</h3></caption>
          <tr>
            <td colspan="2" style="text-align:center;"><span class="required">* </span>Required fields</td>
          </tr>
          <tr>
            <th>Street Address <span class="required">*</span></th>
            <td><input name="sAddress" type="text" class="textfield" id="sAddress" required /></td>
          </tr>
          <tr>
            <th>P.O. Box No <span class="required">*</span></th>
            <td><input name="box" type="text" class="textfield" id="box" required /></td>
          </tr>
          <tr>
            <th>City <span class="required">*</span></th>
            <td><input name="city" type="text" class="textfield" id="city" required /></td>
          </tr>
          <tr>
            <th>Mobile No <span class="required">*</span></th>
            <td><input name="mNumber" type="text" class="textfield" id="mNumber" required /></td>
          </tr>
          <tr>
            <th>Landline No</th>
            <td><input name="lNumber" type="text" class="textfield" id="lNumber" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Add" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  
  <?php include 'footer.php'; ?>
</div>
</body>
</html>
<?php
    mysqli_close($conn);
?>