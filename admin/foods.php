<?php
    require_once('auth.php');
    require_once('connection/config.php');
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }
    
    // Retrieve foods with categories
    $result = mysqli_query($conn, "SELECT * FROM food_details, categories WHERE food_details.food_category=categories.category_id")
        or die("There are no records to display ... \n" . mysqli_error()); 
    
    // Retrieve categories
    $categories = mysqli_query($conn, "SELECT * FROM categories")
        or die("There are no records to display ... \n" . mysqli_error()); 
    
    // Retrieve active currency
    $flag_1 = 1;
    $currencies = mysqli_query($conn, "SELECT * FROM currencies WHERE flag='$flag_1'")
        or die("A problem has occurred ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 
    
    $symbol = mysqli_fetch_assoc($currencies); //gets active currency
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Foods Management | Pathfinder</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script language="JavaScript" src="validation/admin.js"></script>
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
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--dark);
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--accent);
        border-radius: 4px;
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: white;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(93, 64, 55, 0.1);
    }
    
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }
    
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1em;
    }
    
    .file-input {
        display: flex;
        align-items: center;
    }
    
    .file-input label {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1rem;
        background-color: var(--primary);
        color: white;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .file-input label:hover {
        background-color: #4b332c;
    }
    
    .file-input input[type="file"] {
        display: none;
    }
    
    .file-name {
        margin-left: 1rem;
        font-size: 0.9rem;
        color: var(--text-light);
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
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
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
    
    .food-image {
        width: 80px;
        height: 70px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid var(--accent);
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
    
    .divider {
        height: 1px;
        background: linear-gradient(to right, transparent, var(--secondary), transparent);
        margin: 2.5rem 0;
        opacity: 0.5;
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
        
        .table {
            display: block;
            overflow-x: auto;
        }
    }
</style>
<script>
    // Display selected file name
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('photo');
        const fileName = document.getElementById('file-name');
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                } else {
                    fileName.textContent = 'No file selected';
                }
            });
        }
    });
</script>
</head>
<body>
<div id="page">
    <div id="header">
        <h1>Pathfinder Hotel & Restaurant</h1>
        <div class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="categories.php"><i class="fas fa-tags"></i> Categories</a>
            <a href="foods.php" class="active"><i class="fas fa-utensils"></i> Foods</a>
            <a href="accounts.php"><i class="fas fa-users"></i> Accounts</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div id="container">
        <!-- Add New Food Section -->
        <div class="card">
            <h2 class="card-title"><i class="fas fa-plus-circle"></i> Add New Food Item</h2>
            <form name="foodsForm" id="foodsForm" action="foods-exec.php" method="post" enctype="multipart/form-data" onsubmit="return foodsValidate(this)">
                <div class="form-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Food Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter food name" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Price</label>
                        <div style="display: flex; align-items: center;">
                            <span style="padding: 0.75rem; background: var(--accent); border: 1px solid var(--accent); border-radius: 4px 0 0 4px;">
                                <?php echo htmlspecialchars($symbol['currency_symbol']); ?>
                            </span>
                            <input type="text" name="price" id="price" class="form-control" style="border-radius: 0 4px 4px 0; margin-left: -1px;" placeholder="0.00" required />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="">Select category</option>
                            <?php 
                            mysqli_data_seek($categories, 0); // Reset pointer
                            while ($row = mysqli_fetch_array($categories)): ?>
                                <option value="<?php echo $row['category_id']; ?>"><?php echo htmlspecialchars($row['category_name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Photo</label>
                        <div class="file-input">
                            <label for="photo">
                                <i class="fas fa-upload"></i> Choose File
                            </label>
                            <span id="file-name" class="file-name">No file selected</span>
                            <input type="file" name="photo" id="photo" accept="image/*" required />
                        </div>
                    </div>
                    
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Enter food description" required></textarea>
                    </div>
                    
                    <div class="form-group" style="grid-column: 1 / -1; text-align: right;">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Add Food Item
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="divider"></div>
        
        <!-- Available Foods Section -->
        <div class="card">
            <h2 class="card-title"><i class="fas fa-utensils"></i> Available Food Items</h2>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        mysqli_data_seek($result, 0); // Reset pointer
                        while ($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><img src="../images/<?php echo htmlspecialchars($row['food_photo']); ?>" class="food-image" alt="<?php echo htmlspecialchars($row['food_name']); ?>"></td>
                            <td><?php echo htmlspecialchars($row['food_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['food_description']); ?></td>
                            <td><?php echo htmlspecialchars($symbol['currency_symbol'] . $row['food_price']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td>
                                <a href="delete-food.php?id=<?php echo $row['food_id']; ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this food item?')">
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

<?php
    // Close all result sets
    mysqli_free_result($result);
    mysqli_free_result($categories);
    mysqli_free_result($currencies);
    
    // Close connection
    mysqli_close($conn);
?>
</body>
</html>