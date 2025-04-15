<?php
    require_once('auth.php');
    require_once('connection/config.php');
    
    //Connect to mysqli server
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }
    
    //get member id from session
    $memberId=$_SESSION['SESS_MEMBER_ID'];
    
    //retrieving cart items count
    $flag_0 = 0;
    $items=mysqli_query($conn,"SELECT * FROM cart_details WHERE member_id='$memberId' AND flag='$flag_0'")
    or die("Something is wrong ... \n" . mysqli_error()); 
    $num_items = mysqli_num_rows($items);
    
    //retrieving messages count
    $messages=mysqli_query($conn,"SELECT * FROM messages")
    or die("Something is wrong ... \n" . mysqli_error()); 
    $num_messages = mysqli_num_rows($messages);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME ?>: My Profile</title>
    <style>
        /* Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        
        a {
            text-decoration: none;
            color: #bd6f2f;
            transition: color 0.3s;
        }
        
        a:hover {
            color: #8a4f1a;
        }
        
        /* Layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, #bd6f2f, #8a4f1a);
            color: white;
            padding: 30px 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .profile-header h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        
        /* Quick Links */
        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .quick-links a {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            background: #f8f8f8;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .quick-links a:hover {
            background: #e8e8e8;
        }
        
        .badge {
            margin-left: 8px;
            background: #bd6f2f;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 12px 25px;
            background: #bd6f2f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            background: #8a4f1a;
        }
        
        .action-btn.active {
            background: #8a4f1a;
            box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
        }
        
        /* Profile Sections */
        .profile-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 0;
            margin-bottom: 30px;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.5s ease-out;
        }
        
        .profile-section.active {
            max-height: 1000px;
            padding: 25px;
        }
        
        .profile-section h2 {
            color: #bd6f2f;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border 0.3s;
        }
        
        .form-control:focus {
            border-color: #bd6f2f;
            outline: none;
        }
        
        .required {
            color: #e74c3c;
        }
        
        .btn {
            padding: 12px 25px;
            background: #bd6f2f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #8a4f1a;
        }
        
        .info-text {
            margin-bottom: 30px;
            line-height: 1.7;
            color: #555;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .quick-links {
                justify-content: center;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .action-btn {
                width: 100%;
            }
        }
        
        @media (max-width: 480px) {
            .profile-header h1 {
                font-size: 1.8rem;
            }
            
            .quick-links {
                flex-direction: column;
                align-items: center;
            }
            
            .quick-links a {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    <script language="JavaScript" src="validation/user.js"></script>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h1>My Profile</h1>
            <p>Manage your account settings and delivery information</p>
        </div>
        
        <div class="quick-links">
            <a href="member-index.php">Home</a>
            <a href="cart.php">Cart <span class="badge"><?php echo $num_items;?></span></a>
            <a href="inbox.php">Inbox <span class="badge"><?php echo $num_messages;?></span></a>
            <a href="tables.php">Tables</a>
            <a href="partyhalls.php">Party-Halls</a>
            <a href="ratings.php">Rate Us</a>
            <a href="logout.php">Logout</a>
        </div>
        
        <div class="info-text">
            <p>Here you can change your password and also add a billing or delivery address. The delivery address will be used to bill your food orders as well as providing us with details on where to deliver your food.</p>
        </div>
        
        <div class="action-buttons">
            <button id="passwordBtn" class="action-btn">Change Password</button>
            <button id="addressBtn" class="action-btn">Add Delivery Address</button>
        </div>
        
        <!-- Password Change Section -->
        <div id="passwordSection" class="profile-section">
            <h2>Change Your Password</h2>
            <form id="updateForm" name="updateForm" method="post" action="update-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return updateValidate(this)">
                <div class="form-group">
                    <label for="opassword">Old Password <span class="required">*</span></label>
                    <input name="opassword" type="password" class="form-control" id="opassword" required>
                </div>
                
                <div class="form-group">
                    <label for="npassword">New Password <span class="required">*</span></label>
                    <input name="npassword" type="password" class="form-control" id="npassword" required>
                </div>
                
                <div class="form-group">
                    <label for="cpassword">Confirm New Password <span class="required">*</span></label>
                    <input name="cpassword" type="password" class="form-control" id="cpassword" required>
                </div>
                
                <button type="submit" name="Submit" class="btn">Change Password</button>
            </form>
        </div>
        
        <!-- Address Section -->
        <div id="addressSection" class="profile-section">
            <h2>Add Delivery/Billing Address</h2>
            <form id="billingForm" name="billingForm" method="post" action="billing-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return billingValidate(this)">
                <div class="form-group">
                    <label for="sAddress">Street Address <span class="required">*</span></label>
                    <input name="sAddress" type="text" class="form-control" id="sAddress" required>
                </div>
                
                <div class="form-group">
                    <label for="box">P.O. Box No <span class="required">*</span></label>
                    <input name="box" type="text" class="form-control" id="box" required>
                </div>
                
                <div class="form-group">
                    <label for="city">City <span class="required">*</span></label>
                    <input name="city" type="text" class="form-control" id="city" required>
                </div>
                
                <div class="form-group">
                    <label for="mNumber">Mobile No <span class="required">*</span></label>
                    <input name="mNumber" type="text" class="form-control" id="mNumber" required>
                </div>
                
                <div class="form-group">
                    <label for="lNumber">Landline No</label>
                    <input name="lNumber" type="text" class="form-control" id="lNumber">
                </div>
                
                <button type="submit" name="Submit" class="btn">Save Address</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordBtn = document.getElementById('passwordBtn');
            const addressBtn = document.getElementById('addressBtn');
            const passwordSection = document.getElementById('passwordSection');
            const addressSection = document.getElementById('addressSection');
            
            // Toggle password section
            passwordBtn.addEventListener('click', function() {
                if (passwordSection.classList.contains('active')) {
                    passwordSection.classList.remove('active');
                    passwordBtn.classList.remove('active');
                } else {
                    passwordSection.classList.add('active');
                    passwordBtn.classList.add('active');
                    // Close address section if open
                    addressSection.classList.remove('active');
                    addressBtn.classList.remove('active');
                }
            });
            
            // Toggle address section
            addressBtn.addEventListener('click', function() {
                if (addressSection.classList.contains('active')) {
                    addressSection.classList.remove('active');
                    addressBtn.classList.remove('active');
                } else {
                    addressSection.classList.add('active');
                    addressBtn.classList.add('active');
                    // Close password section if open
                    passwordSection.classList.remove('active');
                    passwordBtn.classList.remove('active');
                }
            });
            
            // Close all sections when clicking outside
            document.addEventListener('click', function(e) {
                if (!passwordBtn.contains(e.target) && !passwordSection.contains(e.target) &&
                    !addressBtn.contains(e.target) && !addressSection.contains(e.target)) {
                    passwordSection.classList.remove('active');
                    passwordBtn.classList.remove('active');
                    addressSection.classList.remove('active');
                    addressBtn.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>