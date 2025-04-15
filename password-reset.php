<?php
//Start session
session_start();
    
//checking connection and connecting to a database
require_once('connection/config.php');
//Connect to mysqli server
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if(!$conn) {
    die('Failed to connect to server: ' . mysqli_error());
}
?>
<?php
if(isset($_POST['Submit'])){
    //Function to sanitize values received from the form. Prevents SQL injection
    function clean($str) {
        global $conn;
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysqli_real_escape_string($conn,$str);
    }
    //get email
    $email = clean($_POST['email']);
    
    //selecting a specific record from the members table. Return an error if there are no records in the table
    $result=mysqli_query($conn,"SELECT * FROM members WHERE login='$email'")
    or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 
}
?>
<?php
if(isset($_POST['Change'])){
    //Function to sanitize values received from the form. Prevents SQL injection
    function clean($str) {
        global $conn;
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysqli_real_escape_string($conn,$str);
    }
    if(trim($_SESSION['member_id']) != ''){
        $member_id=$_SESSION['member_id']; //gets member id from session
        //get answer and new password from form
        $answer = clean($_POST['answer']);
        $new_password = clean($_POST['new_password']);
        
        // update the entry
        $result = mysqli_query($conn,"UPDATE members SET passwd='".md5($_POST['new_password'])."' WHERE member_id='$member_id' AND answer='".md5($_POST['answer'])."'")
        or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours. \n");  
        
        if($result){
            unset($_SESSION['member_id']);
            header("Location: reset-success.php"); //redirect to reset success page         
        }
        else{
            unset($_SESSION['member_id']);
            header("Location: reset-failed.php"); //redirect to reset failed page
        }
    }
    else{
        unset($_SESSION['member_id']);
        header("Location: reset-failed.php"); //redirect to reset failed page
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo APP_NAME ?>: Password Reset</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script language="JavaScript" src="validation/user.js"></script>
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
    align-items: center;
    justify-content: center;
  }
  
  #reset {
    width: 100%;
    max-width: 600px;
    margin: 20px auto;
    background-color: rgba(255, 249, 240, 0.9);
    border-radius: 8px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    padding: 30px;
    border: 1px solid rgba(189, 111, 47, 0.2);
    backdrop-filter: blur(2px);
  }
  
  h1 {
    color: #5a3921;
    font-size: 2em;
    margin-bottom: 25px;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    text-align: center;
    position: relative;
    padding-bottom: 10px;
  }
  
  h1:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: #d4a76a;
  }
  
  form {
    margin: 20px 0;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    padding: 12px 8px;
    text-align: left;
  }
  
  th {
    font-weight: 600;
    color: #5a3921;
  }
  
  .textfield {
    width: 100%;
    padding: 10px;
    border: 1px solid #d4a76a;
    border-radius: 4px;
    background-color: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
  }
  
  .textfield:focus {
    outline: none;
    border-color: #7d4e2a;
    box-shadow: 0 0 0 2px rgba(125, 78, 42, 0.2);
  }
  
  input[type="submit"], input[type="reset"] {
    background-color: #7d4e2a;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    margin: 5px;
  }
  
  input[type="submit"]:hover, input[type="reset"]:hover {
    background-color: #5a3921;
  }
  
  input[type="submit"] {
    background-color: #d4a76a;
    color: #4a2c12;
  }
  
  input[type="submit"]:hover {
    background-color: #bd6f2f;
  }
  
  hr {
    border: 0;
    height: 1px;
    background: linear-gradient(to right, transparent, #d4a76a, transparent);
    margin: 25px 0;
  }
  
  .security-info {
    background-color: rgba(218, 165, 32, 0.1);
    padding: 15px;
    border-radius: 4px;
    margin: 15px 0;
    border-left: 4px solid #d4a76a;
  }
  
  .security-info b {
    color: #5a3921;
  }
  
  .error {
    color: #c13c3c;
    font-weight: 600;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    #reset {
      padding: 20px;
      margin: 20px;
    }
    
    table {
      display: block;
    }
    
    tr {
      display: flex;
      flex-direction: column;
      margin-bottom: 15px;
    }
    
    th, td {
      padding: 8px 0;
      display: block;
      width: 100% !important;
    }
    
    input[type="submit"], input[type="reset"] {
      width: 100%;
      margin: 5px 0;
    }
  }
</style>
</head>
<body>
<div id="reset">
  <h1>Password Reset</h1>
  <div style="padding: 20px;">
    <form name="passwordResetForm" id="passwordResetForm" method="post" action="password-reset.php" onsubmit="return passwordResetValidate(this)">
      <table>
        <tr>
          <th>Account Email</th>
          <td><input name="email" type="text" class="textfield" id="email" placeholder="Enter your email address" required /></td>
          <td><input type="submit" name="Submit" value="Check" /></td>
        </tr>
      </table>
    </form>
    
    <?php
    if(isset($_POST['Submit'])){
        $row=mysqli_fetch_assoc($result);
        $_SESSION['member_id']=$row['member_id']; //creates a member id session
        session_write_close(); //closes session
        $question_id=$row['question_id'];
        
        //get question text based on question_id
        $question=mysqli_query($conn,"SELECT * FROM questions WHERE question_id='$question_id'")
        or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");
        
        $question_row=mysqli_fetch_assoc($question);
        $question=$question_row['question_text'];
        if($question!=""){
            echo '<div class="security-info">';
            echo "<p><b>Your Member ID:</b> ".$_SESSION['member_id']."</p>";
            echo "<p><b>Your Security Question:</b> ".$question."</p>";
            echo '</div>';
        }
        else{
            echo '<div class="security-info error">';
            echo "<p><b>Your Security Question:</b> THIS ACCOUNT DOES NOT EXIST! PLEASE CHECK YOUR EMAIL AND TRY AGAIN.</p>";
            echo '</div>';
        }
    }
    ?>
    
    <hr>
    
    <form name="passwordResetForm" id="passwordResetForm" method="post" action="password-reset.php" onsubmit="return passwordResetValidate_2(this)">
      <table>
        <tr>
          <td colspan="3" style="text-align: center;"><span class="error">* </span>Required fields</td>
        </tr>
        <tr>
          <th>Your Security Answer <span class="error">*</span></th>
          <td colspan="2"><input name="answer" type="text" class="textfield" id="answer" placeholder="Enter your security answer" required /></td>
        </tr>
        <tr>
          <th>New Password <span class="error">*</span></th>
          <td colspan="2"><input name="new_password" type="password" class="textfield" id="new_password" placeholder="Enter new password" required /></td>
        </tr>
        <tr>
          <th>Confirm New Password <span class="error">*</span></th>
          <td colspan="2"><input name="confirm_new_password" type="password" class="textfield" id="confirm_new_password" placeholder="Confirm new password" required /></td>
        </tr>
        <tr>
          <td colspan="3" style="text-align: center;">
            <input type="reset" name="Reset" value="Clear Fields" />
            <input type="submit" name="Change" value="Change Password" />
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
</body>
</html>