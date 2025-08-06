<?php
require("connection.php");

// Check if the connection is successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch farmer names from the database
$sqlFarmers = "SELECT farmer_name FROM farmerreg";
$resultFarmers = $con->query($sqlFarmers);

// Fetch milk types from the database
$sqlMilkTypes = "SELECT * FROM milk_types";
$resultMilkTypes = $con->query($sqlMilkTypes);

if ($resultMilkTypes === FALSE) {
    die("Error fetching milk types: " . $con->error);
}

// Initialize form variables
$farmerName = $milkQuantity = $collectionDate = $milkType = $fat = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data with default values if not set
    $farmerName = isset($_POST["farmer_name"]) ? $_POST["farmer_name"] : "";
    $milkQuantity = isset($_POST["milk_quantity"]) ? $_POST["milk_quantity"] : "";
    $collectionDate = isset($_POST["collection_date"]) ? $_POST["collection_date"] : "";
    $milkType = isset($_POST["milk_type"]) ? $_POST["milk_type"] : "";
    $fat = isset($_POST["milk_fat"]) ? $_POST["milk_fat"] : "";

    // Insert data into the database
    $insertSql = "INSERT INTO milk_collection (farmer_name, milk_type, milk_quantity, collection_date, milk_fat) 
                    VALUES ('$farmerName', '$milkType', '$milkQuantity', '$collectionDate', '$fat')";

    if ($con->query($insertSql) === TRUE) {
        echo "<script>alert('Data inserted successfully');</script>";
    } else {
        echo "Error: " . $insertSql . "<br>" . $con->error;
    }
}
?>
<?php
    if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: AdminLogin.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Collection Form</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/addmilk.css">
</head>
<body>

<div class="header">
        <ul class="navbar">
            <div class="head1">
            <li><a href="Adminpanel.php">Home</a></li>
            <li><a href="farmerreg.php">Farmer Registration</a></li>
            <li><a href="addmilk.php">Add Milk</a></li>
            <li><a href="setprice.php">Fat Range</a></li>
            <!-- <li><a href="animal_food_product.php">Animal Food Form</a></li> -->
            <li><a href="milk_coll_details.php">Milk Collection Details</a></li>
            <li><a href="Fatprices.php">Fat Prices</a></li>
            <li><a href="farmer_details.php">Farmer Details</a></li>
            <li><a href="payment_details.php">Payment Details</a></li>
            </div>
            <div>
            <li class="logout-button">
                <form method="POST">
                    <button name="logout">Log Out</button>
                </form>
            </li>
            </div>
        </ul>
    </div>
        
    <?php
        if(isset($_POST['logout']))
        {
            session_destroy();
            header("location: AdminLogin.php");
        }
    ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="addmilk">
    <label for="farmer_name">Farmer Name:</label>
    <select name="farmer_name" required>
        <?php
        // Populate dropdown list with farmer names from the database
        if ($resultFarmers->num_rows > 0) {
            while ($row = $resultFarmers->fetch_assoc()) {
                echo "<option value='" . $row["farmer_name"] . "'>" . $row["farmer_name"] . "</option>";
            }
        }
        ?>
    </select><br>

    <label for="milk_type">Milk Type:</label>
    <select name="milk_type" required>
        <?php
        // Populate dropdown list with milk types from the database
        if ($resultMilkTypes->num_rows > 0) {
            while ($row = $resultMilkTypes->fetch_assoc()) {
                echo "<option value='" . $row["type_name"] . "'>" . $row["type_name"] . "</option>";
            }
        }
        ?>
    </select><br>

    <label for="milk_quantity">Milk Quantity (liters):</label>
    <input type="number" name="milk_quantity" required><br>

    <label for="milk_fat">Fat Content:</label>
    <input type="number" name="milk_fat" step="0.01" required><br>

    <label for="collection_date">Collection Date:</label>
    <input type="date" name="collection_date" required><br>

    <input type="submit" value="Submit">
</form>
</body>
</html>

<?php
// Close database connection
$con->close();
?>
