<?php
    require_once('auth.php');
    require_once('connection/config.php');
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }
   
    $result = mysqli_query($conn, "SELECT * FROM categories")
        or die("There are no records to display ... \n" . mysqli_error()); 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Categories Management | Pathfinder</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script language="JavaScript" src="validation/admin.js"></script>
<style type="text/css">
    /* Consistent Pathfinder Theme */
    :root {
        --primary: #5D4037;    /* Rich brown */
        --secondary: #8D6E63;  /* Lighter brown */
        --accent: #D7CCC8;     /* Light beige */
        --highlight: #BCAAA4;   /* Medium brown */
        --light: #EFEBE9;      /* Cream */
        --dark: #3E2723;       /* Dark brown */
        --text: #4E342E;       /* Dark brown text */
        --text-light: #8D6E63;
        --success: #4CAF50;    /* Green for positive metrics */
        --warning: #FF9800;    /* Orange for pending metrics */
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
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
    }
    
    .page-title {
        color: var(--dark);
        margin-bottom: 2rem;
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 600;
        text-align: center;
        letter-spacing: 0.5px;
        position: relative;
    }
    
    .page-title:after {
        content: '';
        display: block;
        width: 100px;
        height: 3px;
        background: var(--highlight);
        margin: 0.75rem auto 0;
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
        margin-bottom: 2rem;
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        letter-spacing: 0.5px;
    }
    
    .card-title i {
        margin-right: 12px;
        color: var(--highlight);
    }
    
    .form-group {
        margin-bottom: 1.75rem;
    }
    
    .form-row {
        display: flex;
        gap: 1.5rem;
        align-items: flex-end;
    }
    
    .form-control {
        flex: 1;
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
        min-width: 180px;
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
        background: var(--dark);
    }
    
    .btn-danger:hover {
        background: #2c1c18;
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
        padding: 1.25rem;
        border-bottom: 1px solid var(--accent);
    }
    
    .table tr:last-child td {
        border-bottom: none;
    }
    
    .table tr:hover td {
        background-color: var(--light);
    }
    
    .divider {
        height: 1px;
        background: linear-gradient(to right, transparent, var(--secondary), transparent);
        margin: 3rem 0;
        opacity: 0.5;
    }
    
    /* Collapsible section styles */
    .collapsible-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        padding: 1rem 1.5rem;
        background-color: var(--light);
        border-radius: 4px;
        margin-bottom: 1rem;
    }
    
    .collapsible-header h3 {
        margin: 0;
        font-family: 'Playfair Display', serif;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .collapsible-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    
    .collapsible-content.active {
        max-height: 1000px;
        transition: max-height 0.5s ease-in;
    }
    
    .toggle-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--primary);
        cursor: pointer;
        padding: 0.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        #container {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }
        
        .nav-links {
            gap: 1rem;
        }
        
        #header h1 {
            font-size: 1.6rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .card {
            padding: 1.5rem;
        }
        
        .btn {
            width: 100%;
            padding: 0.9rem;
        }
    }
    
    @media (max-width: 480px) {
        #container {
            padding: 1rem;
        }
        
        .table th, 
        .table td {
            padding: 0.75rem;
            font-size: 0.85rem;
        }
        
        .card-title {
            font-size: 1.4rem;
        }
    }
</style>
</head>
<body>
<div id="page">
    <div id="header">
        <h1>Pathfinder Hotel & Restaurant</h1>
        <div class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="categories.php" class="active"><i class="fas fa-tags"></i> Menu Categories</a>
            <a href="foods.php"><i class="fas fa-utensils"></i> Menu Items</a>
            <a href="reservations.php"><i class="fas fa-calendar-check"></i> Reservations</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div id="container">
        <h2 class="page-title"><i class="fas fa-tags"></i> Menu Categories Management</h2>
        
        <div class="card">
            <h2 class="card-title"><i class="fas fa-plus-circle"></i> Add New Menu Category</h2>
            <form name="categoryForm" id="categoryForm" action="categories-exec.php" method="post" onsubmit="return categoriesValidate(this)">
                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <input type="text" name="name" class="form-control" placeholder="Enter category name (e.g. Starters, Main Courses, Desserts)" required />
                    </div>
                    <div class="form-group">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Add Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card">
            <div class="collapsible-header" onclick="toggleCollapse()">
                <h3><i class="fas fa-list"></i> Current Menu Categories</h3>
                <button class="toggle-btn" id="toggleIcon">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="collapsible-content" id="categoriesTable">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td>
                                <a href="delete-category.php?id=<?php echo $row['category_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to permanently delete this category?')">
                                    <i class="fas fa-trash-alt"></i> Delete
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
    // Toggle collapsible section
    function toggleCollapse() {
        const content = document.getElementById('categoriesTable');
        const icon = document.getElementById('toggleIcon');
        
        content.classList.toggle('active');
        
        // Change icon based on state
        if (content.classList.contains('active')) {
            icon.innerHTML = '<i class="fas fa-times"></i>';
        } else {
            icon.innerHTML = '<i class="fas fa-bars"></i>';
        }
    }
    
    // Initialize the table as collapsed
    document.addEventListener('DOMContentLoaded', function() {
        // Table starts collapsed by default
        document.getElementById('categoriesTable').classList.remove('active');
    });
</script>

<?php
    mysqli_free_result($result);
    mysqli_close($conn);
?>
</body>
</html>