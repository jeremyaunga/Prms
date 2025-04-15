<?php
//checking connection and connecting to a database
require_once('connection/config.php');
error_reporting(1);
//Connect to mysqli server
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
if(!$conn) {
    die('Failed to connect to server: ' . mysqli_error());
}

//retrieve questions from the questions table
$questions=mysqli_query($conn,"SELECT * FROM questions")
or die("Something is wrong ... \n" . mysqli_error());
?>
<?php
//setting-up a remember me cookie
if (isset($_POST['Submit'])){
    //setting up a remember me cookie
    if($_POST['remember']) {
        $year = time() + 31536000;
        setcookie('remember_me', $_POST['login'], $year);
    }
    else if(!$_POST['remember']) {
        if(isset($_COOKIE['remember_me'])) {
            $past = time() - 100;
            setcookie(remember_me, gone, $past);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME ?>: Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #bd6f2f;
            --primary-dark: #9a5a26;
            --primary-light: #e8a35a;
            --text-dark: #333;
            --text-light: #777;
            --bg-light: #f9f5f0;
            --bg-white: #ffffff;
            --shadow: 0 10px 30px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body, html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        .full-page-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 20px 0;
            box-shadow: var(--shadow);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .header-top {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-align: center;
        }
        
        nav {
            width: 100%;
            background-color: rgba(0,0,0,0.2);
            border-radius: 5px;
            padding: 10px;
        }
        
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            flex-wrap: wrap;
        }
        
        nav ul li {
            margin: 0 10px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: var(--transition);
            font-weight: 500;
            font-size: 1rem;
        }
        
        nav ul li a:hover {
            background-color: rgba(255,255,255,0.2);
        }
        
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        .auth-container {
            position: relative;
            width: 100%;
            max-width: 1200px;
            height: 600px;
            perspective: 1000px;
        }
        
        .auth-box {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 0.8s ease;
        }
        
        .auth-box.register-active {
            transform: rotateY(180deg);
        }
        
        .login-form, .register-form {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            background-color: var(--bg-white);
            border-radius: 20px;
            padding: 60px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
        }
        
        .register-form {
            transform: rotateY(180deg);
        }
        
        .form-title {
            color: var(--primary-color);
            margin-bottom: 40px;
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
        }
        
        .form-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            flex: 1;
        }
        
        .form-column {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 1.1rem;
        }
        
        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 1.1rem;
            transition: var(--transition);
            background-color: var(--bg-light);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(189, 111, 47, 0.2);
        }
        
        .btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 500;
            transition: var(--transition);
            text-align: center;
            display: inline-block;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        .btn-reset {
            background-color: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        
        .btn-reset:hover {
            background-color: rgba(189, 111, 47, 0.1);
            transform: none;
        }
        
        .form-footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }
        
        .remember-me input {
            width: 20px;
            height: 20px;
            accent-color: var(--primary-color);
        }
        
        .toggle-form {
            text-align: center;
            margin-top: 30px;
            color: var(--text-light);
            font-size: 1.1rem;
        }
        
        .toggle-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-left: 5px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .toggle-link:hover {
            text-decoration: underline;
        }
        
        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 1rem;
            transition: var(--transition);
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .input-icon {
            position: absolute;
            right: 20px;
            top: 45px;
            color: var(--text-light);
            font-size: 1.2rem;
        }
        
        .form-decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(189, 111, 47, 0.1), transparent);
            z-index: -1;
        }
        
        .decoration-1 {
            top: -50px;
            left: -50px;
        }
        
        .decoration-2 {
            bottom: -50px;
            right: -50px;
        }
        
        .form-image {
            background: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            border-radius: 15px;
            height: 100%;
        }
        
        @media (max-width: 992px) {
            .form-content {
                grid-template-columns: 1fr;
            }
            
            .form-image {
                display: none;
            }
            
            .auth-container {
                height: auto;
                max-width: 800px;
            }
            
            .login-form, .register-form {
                padding: 40px;
            }
        }
        
        @media (max-width: 768px) {
            .header-top {
                flex-direction: column;
                text-align: center;
            }
            
            header h1 {
                font-size: 2rem;
                margin-bottom: 15px;
            }
            
            nav ul {
                flex-direction: column;
                align-items: center;
            }
            
            nav ul li {
                margin: 5px 0;
            }
            
            .auth-container {
                perspective: none;
            }
            
            .auth-box {
                transform-style: flat;
            }
            
            .auth-box.register-active {
                transform: none;
            }
            
            .login-form, .register-form {
                position: relative;
                transform: none !important;
                display: none;
                margin-bottom: 30px;
                height: auto;
            }
            
            .login-form.active, .register-form.active {
                display: flex;
            }
            
            .form-title {
                font-size: 2rem;
                margin-bottom: 30px;
            }
            
            .form-decoration {
                display: none;
            }
        }
    </style>
    <script language="JavaScript" src="validation/user.js"></script>
</head>
<body>
    <div class="full-page-container">
        <header>
            <div class="header-content">
                <div class="header-top">
                    <h1><?php echo APP_NAME ?> Restaurant</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="foodzone.php">Food Zone</a></li>
                        <li><a href="specialdeals.php">Special Deals</a></li>
                        <li><a href="member-index.php">My Account</a></li>
                        <li><a href="contactus.php">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        
        <div class="main-content">
            <div class="auth-container">
                <div class="form-decoration decoration-1"></div>
                <div class="form-decoration decoration-2"></div>
                
                <div class="auth-box" id="authBox">
                    <!-- Login Form -->
                    <form id="loginForm" name="loginForm" method="post" action="login-exec.php" onsubmit="return loginValidate(this)" class="login-form active">
                        <h2 class="form-title">Welcome Back</h2>
                        
                        <div class="form-content">
                            <div class="form-column">
                                <div class="form-group">
                                    <label for="login">Email</label>
                                    <input name="login" type="text" class="form-control" id="login" placeholder="Enter your email" />
                                    <i class="fas fa-envelope input-icon"></i>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Enter your password" />
                                    <i class="fas fa-lock input-icon"></i>
                                </div>
                                
                                <div class="form-footer">
                                    <div class="remember-me">
                                        <input name="remember" type="checkbox" id="remember" value="1" onselect="cookie()" <?php if(isset($_COOKIE['remember_me'])) { echo 'checked="checked"'; } ?>/>
                                        <label for="remember">Remember me</label>
                                    </div>
                                    <a href="JavaScript: resetPassword()" class="forgot-password">Forgot password?</a>
                                </div>
                                
                                <button type="submit" name="Submit" class="btn btn-block" style="margin-top: 20px;">
                                    Login <i class="fas fa-arrow-right"></i>
                                </button>
                                
                                <div class="toggle-form">
                                    Don't have an account? 
                                    <span class="toggle-link" onclick="showRegister()">Sign up here</span>
                                </div>
                            </div>
                            
                            <div class="form-column form-image"></div>
                        </div>
                    </form>
                    
                    <!-- Register Form -->
                    <form id="registerForm" name="registerForm" method="post" action="register-exec.php" onsubmit="return registerValidate(this)" class="register-form">
                        <h2 class="form-title">Create Account</h2>
                        
                        <div class="form-content">
                            <div class="form-column">
                                <div class="form-group">
                                    <label for="fname">First Name</label>
                                    <input name="fname" type="text" class="form-control" id="fname" placeholder="Enter your first name" />
                                    <i class="fas fa-user input-icon"></i>
                                </div>
                                
                                <div class="form-group">
                                    <label for="lname">Last Name</label>
                                    <input name="lname" type="text" class="form-control" id="lname" placeholder="Enter your last name" />
                                    <i class="fas fa-user input-icon"></i>
                                </div>
                                
                                <div class="form-group">
                                    <label for="login">Email</label>
                                    <input name="login" type="text" class="form-control" id="login" placeholder="Enter your email" />
                                    <i class="fas fa-envelope input-icon"></i>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Create a password" />
                                    <i class="fas fa-lock input-icon"></i>
                                </div>
                            </div>
                            
                            <div class="form-column">
                                <div class="form-group">
                                    <label for="cpassword">Confirm Password</label>
                                    <input name="cpassword" type="password" class="form-control" id="cpassword" placeholder="Confirm your password" />
                                    <i class="fas fa-lock input-icon"></i>
                                </div>
                                
                                <div class="form-group">
                                    <label for="question">Security Question</label>
                                    <select name="question" id="question" class="form-control">
                                        <option value="select">- select question -</option>
                                        <?php 
                                        while ($row=mysqli_fetch_array($questions)){
                                            echo "<option value=$row[question_id]>$row[question_text]</option>"; 
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="answer">Security Answer</label>
                                    <input name="answer" type="text" class="form-control" id="answer" placeholder="Enter your answer" />
                                </div>
                                
                                <button type="submit" name="Submit" class="btn btn-block" style="margin-top: 10px;">
                                    Register <i class="fas fa-user-plus"></i>
                                </button>
                                
                                <div class="toggle-form">
                                    Already have an account? 
                                    <span class="toggle-link" onclick="showLogin()">Login here</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script>
        // Toggle between login and register forms
        function showRegister() {
            const authBox = document.getElementById('authBox');
            if (window.innerWidth > 768) {
                authBox.classList.add('register-active');
            } else {
                document.querySelector('.login-form').classList.remove('active');
                document.querySelector('.register-form').classList.add('active');
            }
        }
        
        function showLogin() {
            const authBox = document.getElementById('authBox');
            if (window.innerWidth > 768) {
                authBox.classList.remove('register-active');
            } else {
                document.querySelector('.register-form').classList.remove('active');
                document.querySelector('.login-form').classList.add('active');
            }
        }
        
        // Mobile responsive behavior
        function handleResize() {
            if (window.innerWidth <= 768) {
                document.querySelector('.login-form').classList.add('active');
                document.querySelector('.register-form').classList.remove('active');
            }
        }
        
        // Initialize and add resize listener
        window.addEventListener('load', handleResize);
        window.addEventListener('resize', handleResize);
    </script>
</body>
</html>