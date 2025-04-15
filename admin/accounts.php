<?php
    require_once('auth.php');
    require_once('connection/config.php');
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }
    
    // Select all records from the members table
    $result = mysqli_query($conn, "SELECT * FROM members ORDER BY member_id DESC")
        or die("There are no records to display ... \n" . mysqli_error()); 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Accounts Management | Pathfinder</title>
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
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
    }
    
    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-bottom: 2.5rem;
        border-left: 4px solid var(--highlight);
    }
    
    .card-title {
        color: var(--dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--accent);
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .card-title i {
        margin-right: 12px;
        color: var(--highlight);
    }
    
    .table-container {
        overflow-x: auto;
        margin-top: 1.5rem;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    
    .table th {
        background: var(--primary);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    .table td {
        padding: 1rem;
        border-bottom: 1px solid var(--accent);
    }
    
    .table tr:last-child td {
        border-bottom: none;
    }
    
    .table tr:hover td {
        background-color: #f8f9fa;
    }
    
    .action-link {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background-color: var(--dark);
        color: white;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .action-link:hover {
        background-color: #2c1c18;
        text-decoration: none;
    }
    
    .action-link i {
        margin-right: 5px;
    }
    
    .member-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .search-bar {
        display: flex;
        margin-bottom: 1.5rem;
    }
    
    .search-input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: 1px solid var(--accent);
        border-radius: 4px 0 0 4px;
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(93, 64, 55, 0.1);
    }
    
    .search-btn {
        padding: 0 1.5rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .search-btn:hover {
        background: #4b332c;
    }
    
    /* Responsive adjustments */
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
    }
</style>
</head>
<body>
<div id="page">
    <div id="header">
        <h1>Pathfinder Hotel & Restaurant</h1>
        <div class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="categories.php"><i class="fas fa-tags"></i> Categories</a>
            <a href="foods.php"><i class="fas fa-utensils"></i> Foods</a>
            <a href="accounts.php" class="active"><i class="fas fa-users"></i> Accounts</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div id="container">
        <div class="card">
            <h2 class="card-title"><i class="fas fa-user-friends"></i> Member Accounts</h2>
            
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Search members..." id="searchInput">
                <button class="search-btn" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            
            <div class="table-container">
                <table class="table" id="membersTable">
                    <thead>
                        <tr>
                            <th style="width: 60px;"></th>
                            <th>Member ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td>
                                <div class="member-avatar">
                                    <?php echo substr(htmlspecialchars($row['firstname']), 0, 1) . substr(htmlspecialchars($row['lastname']), 0, 1); ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($row['member_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                            <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($row['login']); ?></td>
                            <td>
                                <a href="delete-member.php?id=<?php echo $row['member_id']; ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this member account?')">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</div>

<script>
    // Simple search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('membersTable');
        const rows = table.getElementsByTagName('tr');
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
                const cells = rows[i].getElementsByTagName('td');
                let found = false;
                
                for (let j = 1; j < cells.length - 1; j++) { // Skip avatar and action cells
                    const cellText = cells[j].textContent.toLowerCase();
                    if (cellText.includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }
                
                rows[i].style.display = found ? '' : 'none';
            }
        });
    });
</script>

<?php
    // Close result set
    mysqli_free_result($result);
    
    // Close connection
    mysqli_close($conn);
?>
</body>
</html>