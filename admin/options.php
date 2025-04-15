<?php
    require_once('auth.php');
    require_once('connection/config.php');
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$conn) {
        die('Failed to connect to server: ' . mysqli_error());
    }
    
    // Single query for each table (more efficient)
    $categories = mysqli_query($conn, "SELECT * FROM categories") or die(mysqli_error($conn)); 
    $quantities = mysqli_query($conn, "SELECT * FROM quantities") or die(mysqli_error($conn)); 
    $currencies = mysqli_query($conn, "SELECT * FROM currencies") or die(mysqli_error($conn)); 
    $ratings = mysqli_query($conn, "SELECT * FROM ratings") or die(mysqli_error($conn));
    $timezones = mysqli_query($conn, "SELECT * FROM timezones") or die(mysqli_error($conn)); 
    $tables = mysqli_query($conn, "SELECT * FROM tables") or die(mysqli_error($conn));
    $partyhalls = mysqli_query($conn, "SELECT * FROM partyhalls") or die(mysqli_error($conn));
    $questions = mysqli_query($conn, "SELECT * FROM questions") or die(mysqli_error($conn));
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Options Management | Pathfinder</title>
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
    
    .section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-bottom: 2.5rem;
        border-left: 4px solid var(--highlight);
    }
    
    .section-title {
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
    
    .section-title i {
        margin-right: 12px;
        color: var(--highlight);
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .form-card {
        background: #fafafa;
        padding: 1.5rem;
        border-radius: 6px;
        border: 1px solid var(--accent);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-row {
        display: flex;
        gap: 1rem;
        align-items: center;
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
    
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1em;
    }
    
    .divider {
        height: 1px;
        background: linear-gradient(to right, transparent, var(--secondary), transparent);
        margin: 2rem 0;
        opacity: 0.5;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .nav-links {
            gap: 1rem;
        }
        
        #header h1 {
            font-size: 1.6rem;
        }
        
        .section {
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
            <a href="accounts.php"><i class="fas fa-users"></i> Accounts</a>
            <a href="options.php" class="active"><i class="fas fa-cog"></i> Options</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div id="container">
        <!-- Categories Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-tags"></i> Manage Categories</h2>
            <div class="form-grid">
                <div class="form-card">
                    <form name="categoryForm" id="categoryForm" action="categories-exec.php" method="post" onsubmit="return categoriesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Add New Category</label>
                            <div class="form-row">
                                <input type="text" name="name" class="form-control" placeholder="Category name" required />
                                <button type="submit" name="Insert" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="form-card">
                    <form name="categoryForm" id="categoryForm" action="delete-category.php" method="post" onsubmit="return categoriesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Remove Category</label>
                            <div class="form-row">
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select category</option>
                                    <?php while ($row = mysqli_fetch_array($categories)): ?>
                                        <option value="<?php echo $row['category_id']; ?>"><?php echo htmlspecialchars($row['category_name']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" name="Delete" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Quantities Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-balance-scale"></i> Manage Quantities</h2>
            <div class="form-grid">
                <div class="form-card">
                    <form name="quantityForm" id="quantityForm" action="quantities-exec.php" method="post" onsubmit="return quantitiesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Add New Quantity</label>
                            <div class="form-row">
                                <input type="text" name="name" class="form-control" placeholder="Quantity value" required />
                                <button type="submit" name="Insert" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="form-card">
                    <form name="quantityForm" id="quantityForm" action="delete-quantity.php" method="post" onsubmit="return quantitiesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Remove Quantity</label>
                            <div class="form-row">
                                <select name="quantity" id="quantity" class="form-control" required>
                                    <option value="">Select quantity</option>
                                    <?php while ($row = mysqli_fetch_array($quantities)): ?>
                                        <option value="<?php echo $row['quantity_id']; ?>"><?php echo htmlspecialchars($row['quantity_value']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" name="Delete" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Currencies Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-money-bill-wave"></i> Manage Currencies</h2>
            <div class="form-grid">
                <div class="form-card">
                    <form name="currencyForm" id="currencyForm" action="currencies-exec.php" method="post" onsubmit="return currenciesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Add New Currency</label>
                            <div class="form-row">
                                <input type="text" name="name" class="form-control" placeholder="Currency symbol" required />
                                <button type="submit" name="Insert" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="form-card">
                    <form name="currencyForm" id="currencyForm" action="delete-currency.php" method="post" onsubmit="return currenciesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Remove Currency</label>
                            <div class="form-row">
                                <select name="currency" id="currency" class="form-control" required>
                                    <option value="">Select currency</option>
                                    <?php 
                                    mysqli_data_seek($currencies, 0); // Reset pointer
                                    while ($row = mysqli_fetch_array($currencies)): ?>
                                        <option value="<?php echo $row['currency_id']; ?>"><?php echo htmlspecialchars($row['currency_symbol']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" name="Delete" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="form-card">
                    <form name="currencyForm" id="currencyForm" action="activate-currency.php" method="post" onsubmit="return currenciesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Activate Currency</label>
                            <div class="form-row">
                                <select name="currency" id="currency" class="form-control" required>
                                    <option value="">Select currency</option>
                                    <?php while ($row = mysqli_fetch_array($currencies_1)): ?>
                                        <option value="<?php echo $row['currency_id']; ?>"><?php echo htmlspecialchars($row['currency_symbol']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" name="Update" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Activate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Timezones Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-clock"></i> Manage Timezones</h2>
            <div class="form-grid">
                <div class="form-card">
                    <form name="timezoneForm" id="timezoneForm" action="timezone-exec.php" method="post" onsubmit="return timezonesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Add New Timezone</label>
                            <div class="form-row">
                                <input type="text" name="name" class="form-control" placeholder="Timezone reference" required />
                                <button type="submit" name="Insert" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="form-card">
                    <form name="timezoneForm" id="timezoneForm" action="delete-timezone.php" method="post" onsubmit="return timezonesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Remove Timezone</label>
                            <div class="form-row">
                                <select name="timezone" id="timezone" class="form-control" required>
                                    <option value="">Select timezone</option>
                                    <?php 
                                    mysqli_data_seek($timezones, 0); // Reset pointer
                                    while ($row = mysqli_fetch_array($timezones)): ?>
                                        <option value="<?php echo $row['timezone_id']; ?>"><?php echo htmlspecialchars($row['timezone_reference']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" name="Delete" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="form-card">
                    <form name="timezoneForm" id="timezoneForm" action="activate-timezone.php" method="post" onsubmit="return timezonesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Activate Timezone</label>
                            <div class="form-row">
                                <select name="timezone" id="timezone" class="form-control" required>
                                    <option value="">Select timezone</option>
                                    <?php while ($row = mysqli_fetch_array($timezones_1)): ?>
                                        <option value="<?php echo $row['timezone_id']; ?>"><?php echo htmlspecialchars($row['timezone_reference']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" name="Update" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Activate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Tables Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-chair"></i> Manage Tables</h2>
            <div class="form-grid">
                <div class="form-card">
                    <form name="tableForm" id="tableForm" action="tables-exec.php" method="post" onsubmit="return tablesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Add New Table</label>
                            <div class="form-row">
                                <input type="text" name="name" class="form-control" placeholder="Table name/number" required />
                                <button type="submit" name="Insert" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="form-card">
                    <form name="tableForm" id="tableForm" action="delete-table.php" method="post" onsubmit="return tablesValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Remove Table</label>
                            <div class="form-row">
                                <select name="table" id="table" class="form-control" required>
                                    <option value="">Select table</option>
                                    <?php while ($row = mysqli_fetch_array($tables)): ?>
                                        <option value="<?php echo $row['table_id']; ?>"><?php echo htmlspecialchars($row['table_name']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" name="Delete" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Party Halls Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-glass-cheers"></i> Manage Party Halls</h2>
            <div class="form-grid">
                <div class="form-card">
                    <form name="partyhallForm" id="partyhallForm" action="partyhalls-exec.php" method="post" onsubmit="return partyhallsValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Add New Party Hall</label>
                            <div class="form-row">
                                <input type="text" name="name" class="form-control" placeholder="Party hall name/number" required />
                                <button type="submit" name="Insert" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="form-card">
                    <form name="partyhallForm" id="partyhallForm" action="delete-partyhall.php" method="post" onsubmit="return partyhallsValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Remove Party Hall</label>
                            <div class="form-row">
                                <select name="partyhall" id="partyhall" class="form-control" required>
                                    <option value="">Select party hall</option>
                                    <?php while ($row = mysqli_fetch_array($partyhalls)): ?>
                                        <option value="<?php echo $row['partyhall_id']; ?>"><?php echo htmlspecialchars($row['partyhall_name']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" name="Delete" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Questions Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-question-circle"></i> Manage Questions</h2>
            <div class="form-grid">
                <div class="form-card">
                    <form name="questionForm" id="questionForm" action="questions-exec.php" method="post" onsubmit="return questionsValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Add New Question</label>
                            <div class="form-row">
                                <input type="text" name="name" class="form-control" placeholder="Question text" required />
                                <button type="submit" name="Insert" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="form-card">
                    <form name="questionForm" id="questionForm" action="delete-question.php" method="post" onsubmit="return questionsValidate(this)">
                        <div class="form-group">
                            <label class="form-label">Remove Question</label>
                            <div class="form-row">
                                <select name="question" id="question" class="form-control" required>
                                    <option value="">Select question</option>
                                    <?php while ($row = mysqli_fetch_array($questions)): ?>
                                        <option value="<?php echo $row['question_id']; ?>"><?php echo htmlspecialchars($row['question_text']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" name="Delete" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</div>

<?php
    // Close all result sets
    mysqli_free_result($categories);
    mysqli_free_result($quantities);
    mysqli_free_result($currencies);
    mysqli_free_result($ratings);
    mysqli_free_result($timezones);
    mysqli_free_result($tables);
    mysqli_free_result($partyhalls);
    mysqli_free_result($questions);
    
    // Close connection
    mysqli_close($conn);
?>
</body>
</html>