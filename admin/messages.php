<?php
    require_once('auth.php');
?>
<?php
// Database connection
require_once('connection/config.php');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if(!$conn) {
    die('Failed to connect to server: ' . mysqli_error());
}

// Get all messages
$result = mysqli_query($conn, "SELECT * FROM messages") 
          or die("There are no records to display ... \n" . mysqli_error()); 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Messages Management | Pathfinder</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style type="text/css">
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
    }
    
    #header {
        background: linear-gradient(to right, var(--dark), var(--primary));
        color: white;
        padding: 1.5rem 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-bottom: 4px solid var(--highlight);
    }
    
    #header h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 2rem;
        letter-spacing: 0.5px;
    }
    
    .nav-links {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    
    .nav-links a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        padding: 0.25rem 0;
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
        max-width: 1400px;
        width: 100%;
        margin: 0 auto;
    }
    
    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-bottom: 3rem;
        border-left: 4px solid var(--highlight);
    }
    
    .card-title {
        color: var(--dark);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--accent);
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .card-title i {
        color: var(--highlight);
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
    
    textarea.form-control {
        min-height: 150px;
        resize: vertical;
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
    
    .btn-danger {
        background: var(--error);
    }
    
    .btn-danger:hover {
        background: #b71c1c;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }
    
    .table th {
        background: var(--primary);
        color: white;
        padding: 1.25rem;
        text-align: left;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    .table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--accent);
    }
    
    .table tr:last-child td {
        border-bottom: none;
    }
    
    .table tr:hover td {
        background-color: var(--light);
    }
    
    .message-preview {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .action-btns {
        display: flex;
        gap: 0.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        #container {
            padding: 1.5rem;
        }
        
        .table th, 
        .table td {
            padding: 0.75rem;
        }
    }
    
    @media (max-width: 768px) {
        .nav-links {
            gap: 1rem;
        }
        
        #header h1 {
            font-size: 1.6rem;
        }
        
        .card {
            padding: 1.5rem;
        }
        
        .action-btns {
            flex-direction: column;
        }
    }
    
    @media (max-width: 480px) {
        #container {
            padding: 1rem;
        }
        
        .table {
            display: block;
            overflow-x: auto;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>
<script language="JavaScript" src="validation/admin.js"></script>
</head>
<body>
<div id="page">
    <div id="header">
        <h1>Pathfinder Hotel & Restaurant</h1>
        <div class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="categories.php"><i class="fas fa-tags"></i> Categories</a>
            <a href="foods.php"><i class="fas fa-utensils"></i> Menu Items</a>
            <a href="accounts.php"><i class="fas fa-users"></i> Accounts</a>
            <a href="orders.php"><i class="fas fa-clipboard-list"></i> Orders</a>
            <a href="reservations.php"><i class="fas fa-calendar-check"></i> Reservations</a>
            <a href="specials.php"><i class="fas fa-star"></i> Specials</a>
            <a href="allocation.php"><i class="fas fa-user-tie"></i> Staff</a>
            <a href="messages.php" class="active"><i class="fas fa-envelope"></i> Messages</a>
            <a href="options.php"><i class="fas fa-cog"></i> Options</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div id="container">
        <div class="card">
            <h2 class="card-title"><i class="fas fa-paper-plane"></i> Send a Message</h2>
            <form id="messageForm" name="messageForm" method="post" action="message-exec.php" onsubmit="return messageValidate(this)">
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter message subject" />
                </div>
                <div class="form-group">
                    <label for="txtmessage">Message</label>
                    <textarea name="txtmessage" id="txtmessage" class="form-control" placeholder="Type your message here..."></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" name="Submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                    <button type="reset" name="Reset" class="btn btn-danger">
                        <i class="fas fa-eraser"></i> Clear Form
                    </button>
                </div>
            </form>
        </div>

        <div class="card">
            <h2 class="card-title"><i class="fas fa-inbox"></i> Sent Messages</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['message_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['message_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['message_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['message_subject']); ?></td>
                        <td class="message-preview" title="<?php echo htmlspecialchars($row['message_text']); ?>">
                            <?php echo htmlspecialchars($row['message_text']); ?>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="view-message.php?id=<?php echo $row['message_id']; ?>" class="btn btn-primary" style="padding: 0.5rem 1rem;">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="delete-message.php?id=<?php echo $row['message_id']; ?>" class="btn btn-danger" style="padding: 0.5rem 1rem;" onclick="return confirm('Are you sure you want to delete this message?')">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</div>
</body>
</html>
<?php
mysqli_free_result($result);
mysqli_close($conn);
?>