<?php
// Verify the user is logged in
session_start();
if (!isset($_SESSION['SESS_MEMBER_ID'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .success-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .success-message {
            color: #28a745;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .redirect-message {
            color: #666;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #bd6f2f;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #8a4f1a;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <h1>Billing Successful</h1>
        <div class="success-message">✓ Billing information added successfully!</div>
        <p>You will be redirected to Food Zone shortly.</p>
        <div class="redirect-message">(Redirecting in <span id="countdown">3</span> seconds...)</div>
        <a href="foodzone.php" class="btn">Go to Food Zone Now</a>
    </div>

    <script>
        // Countdown and redirect
        let seconds = 3;
        const countdownElement = document.getElementById('countdown');
        
        const countdown = setInterval(function() {
            seconds--;
            countdownElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = 'foodzone.php';
            }
        }, 1000);
    </script>
</body>
</html>