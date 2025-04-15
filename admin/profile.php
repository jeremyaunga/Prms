<?php
// Enable error reporting at the very top
error_reporting(E_ALL);
ini_set('display_errors', 1);

// File and session checks
if (!file_exists('auth.php') || !is_readable('auth.php')) {
    die('<div class="error-container" style="font-family:Arial;padding:20px;color:#e74c3c;">Error: Cannot access auth.php. Check file permissions and path.</div>');
}

require_once('auth.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['SESS_ADMIN_ID'])) {
    die('<div class="error-container" style="font-family:Arial;padding:20px;color:#e74c3c;">Error: Admin session not found. Please login first.</div>');
}

if (!file_exists('connection/config.php') || !is_readable('connection/config.php')) {
    die('<div class="error-container" style="font-family:Arial;padding:20px;color:#e74c3c;">Error: Cannot access config.php. Check file permissions and path.</div>');
}

require_once('connection/config.php');

if (!defined('APP_NAME')) {
    die('<div class="error-container" style="font-family:Arial;padding:20px;color:#e74c3c;">Error: APP_NAME constant not defined in config.php</div>');
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Profile | <?php echo htmlspecialchars(APP_NAME); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Pathfinder Hotel & Restaurant Brown Theme */
    :root {
        --primary: #5D4037;    /* Rich brown */
        --secondary: #8D6E63;  /* Lighter brown */
        --accent: #D7CCC8;     /* Light beige */
        --highlight: #BCAAA4;   /* Medium brown */
        --light: #EFEBE9;      /* Cream */
        --dark: #3E2723;       /* Dark brown */
        --text: #4E342E;       /* Dark brown text */
        --text-light: #8D6E63;
        --error: #D32F2F;      /* Red for errors */
        --success: #388E3C;    /* Green for success */
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--light);
        color: var(--text);
        line-height: 1.6;
    }
    
    #page {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    #header {
        background: linear-gradient(to right, var(--dark), var(--primary));
        color: white;
        padding: 1.5rem 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-bottom: 4px solid var(--highlight);
        position: relative;
        overflow: hidden;
    }
    
    #header::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(30deg);
    }
    
    #header h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 2rem;
        letter-spacing: 0.5px;
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .nav-links {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        position: relative;
    }
    
    .nav-links a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        padding: 0.5rem 0;
        transition: all 0.3s ease;
        position: relative;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .nav-links a:after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: var(--accent);
        transition: width 0.3s ease;
    }
    
    .nav-links a:hover:after,
    .nav-links a.active:after {
        width: 100%;
    }
    
    #container {
        flex: 1;
        padding: 2.5rem;
        width: 100%;
    }
    
    .profile-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2.5rem;
        margin-bottom: 3rem;
    }
    
    .profile-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
        border-left: 4px solid var(--highlight);
        transition: all 0.3s ease;
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    
    .card-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--accent);
    }
    
    .card-header i {
        background-color: var(--light);
        color: var(--primary);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 1.1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .card-title {
        color: var(--dark);
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 600;
    }
    
    .required-note {
        color: var(--error);
        font-size: 0.85rem;
        text-align: center;
        margin-bottom: 1.5rem;
        font-style: italic;
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
    
    .form-group .required {
        color: var(--error);
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
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 2rem;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-align: center;
        letter-spacing: 0.5px;
        width: 100%;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn i {
        margin-right: 8px;
    }
    
    .btn-primary {
        background: var(--primary);
    }
    
    .btn-primary:hover {
        background: #4b332c;
    }
    
    /* Password strength indicator */
    .password-strength {
        height: 4px;
        background: var(--accent);
        margin-top: 0.5rem;
        border-radius: 2px;
        overflow: hidden;
    }
    
    .strength-meter {
        height: 100%;
        width: 0;
        transition: width 0.3s, background 0.3s;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .profile-section {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        #container {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .nav-links {
            gap: 1rem;
        }
        
        #header h1 {
            font-size: 1.6rem;
        }
        
        .card-title {
            font-size: 1.3rem;
        }
        
        .profile-card {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 480px) {
        #container {
            padding: 1rem;
        }
        
        .btn {
            padding: 0.9rem;
        }
    }
</style>
</head>
<body>
<div id="page">
    <div id="header">
        <h1><i class="fas fa-user-shield"></i> Admin Profile</h1>
        <div class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="categories.php"><i class="fas fa-tags"></i> Categories</a>
            <a href="foods.php"><i class="fas fa-utensils"></i> Menu Items</a>
            <a href="accounts.php"><i class="fas fa-users"></i> Accounts</a>
            <a href="orders.php"><i class="fas fa-clipboard-list"></i> Orders</a>
            <a href="reservations.php"><i class="fas fa-calendar-check"></i> Reservations</a>
            <a href="specials.php"><i class="fas fa-star"></i> Specials</a>
            <a href="allocation.php"><i class="fas fa-user-tie"></i> Staff</a>
            <a href="messages.php"><i class="fas fa-envelope"></i> Messages</a>
            <a href="options.php"><i class="fas fa-cog"></i> Options</a>
            <a href="profile.php" class="active"><i class="fas fa-user-cog"></i> Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div id="container">
        <div class="profile-section">
            <div class="profile-card">
                <div class="card-header">
                    <i class="fas fa-key"></i>
                    <h2 class="card-title">Change Admin Password</h2>
                </div>
                <p class="required-note"><i class="fas fa-exclamation-circle"></i> Fields marked with * are required</p>
                
                <form id="updateForm" name="updateForm" method="post" action="update-exec.php?id=<?php echo htmlspecialchars($_SESSION['SESS_ADMIN_ID']); ?>" onsubmit="return updateValidate(this)">
                    <div class="form-group">
                        <label for="opassword">Current Password <span class="required">*</span></label>
                        <input type="password" class="form-control" id="opassword" name="opassword" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="npassword">New Password <span class="required">*</span></label>
                        <input type="password" class="form-control" id="npassword" name="npassword" required
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                               title="Must contain at least 8 characters, including uppercase, lowercase, and a number">
                        <div class="password-strength">
                            <div class="strength-meter" id="passwordStrength"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="cpassword">Confirm New Password <span class="required">*</span></label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Change Password</button>
                </form>
            </div>
            
            <div class="profile-card">
                <div class="card-header">
                    <i class="fas fa-user-plus"></i>
                    <h2 class="card-title">Add New Staff</h2>
                </div>
                <p class="required-note"><i class="fas fa-exclamation-circle"></i> Fields marked with * are required</p>
                
                <form id="staffForm" name="staffForm" method="post" action="staff-exec.php" onsubmit="return staffValidate(this)">
                    <div class="form-group">
                        <label for="fName">First Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="fName" name="fName" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="lName">Last Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="lName" name="lName" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sAddress">Street Address <span class="required">*</span></label>
                        <input type="text" class="form-control" id="sAddress" name="sAddress" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="mobile">Mobile/Tel <span class="required">*</span></label>
                        <input type="text" class="form-control" id="mobile" name="mobile" required
                               pattern="[0-9]{10,15}" 
                               title="Please enter a valid phone number (10-15 digits)">
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add Staff</button>
                </form>
            </div>
        </div>
    </div>
    
    <footer style="text-align:center; padding:1.5rem 2rem; background:var(--dark); color:var(--accent);">
        &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(APP_NAME); ?> | Admin Dashboard
    </footer>
</div>

<script>
// Password strength indicator
document.getElementById('npassword').addEventListener('input', function() {
    const password = this.value;
    const strengthMeter = document.getElementById('passwordStrength');
    let strength = 0;
    
    // Check for length
    if (password.length >= 8) strength += 1;
    if (password.length >= 12) strength += 1;
    
    // Check for uppercase letters
    if (/[A-Z]/.test(password)) strength += 1;
    
    // Check for numbers
    if (/[0-9]/.test(password)) strength += 1;
    
    // Check for special characters
    if (/[^A-Za-z0-9]/.test(password)) strength += 1;
    
    // Update strength meter
    const width = strength * 20;
    let color = '#f44336'; // red
    
    if (strength >= 4) {
        color = '#4CAF50'; // green
    } else if (strength >= 2) {
        color = '#FFC107'; // yellow
    }
    
    strengthMeter.style.width = width + '%';
    strengthMeter.style.background = color;
});

// Form validation
function updateValidate(form) {
    if (form.npassword.value !== form.cpassword.value) {
        alert('New password and confirmation password do not match!');
        form.cpassword.focus();
        return false;
    }
    return true;
}

function staffValidate(form) {
    // Basic validation - more can be added as needed
    if (form.fName.value.trim() === '') {
        alert('Please enter first name');
        form.fName.focus();
        return false;
    }
    if (form.lName.value.trim() === '') {
        alert('Please enter last name');
        form.lName.focus();
        return false;
    }
    return true;
}
</script>
</body>
</html>