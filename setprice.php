<?php
    require("connection.php");

    // Fetch existing price data from the database
    $sqlCow = "SELECT * FROM fat_prices WHERE milk_type = 'cow'";
    $resultCow = $con->query($sqlCow);

    $sqlBuffalo = "SELECT * FROM fat_prices WHERE milk_type = 'buffalo'";
    $resultBuffalo = $con->query($sqlBuffalo);

    // Process form data when the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $fatFrom = $_POST["fat_from"];
        $fatTo = $_POST["fat_to"];
        $price = $_POST["price"];
        $milkType = $_POST["milk_type"];

        // Insert data into the database
        $insertSql = "INSERT INTO fat_prices (fat_from, fat_to, price, milk_type) 
                      VALUES ('$fatFrom', '$fatTo', '$price', '$milkType')";

        if ($con->query($insertSql) === TRUE) {
            echo "<script>alert('Price set successfully');</script>";
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
    <title>Set Fat Prices Form</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/setprice.css">
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
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="setprice">
    <label for="milk_type">Milk Type:</label>
    <select name="milk_type" required>
        <option value="cow">Cow Milk</option>
        <option value="buffalo">Buffalo Milk</option>
    </select><br>

    <label for="fat_from">Fat From:</label>
    <input type="number" name="fat_from" step="0.01" required><br>

    <label for="fat_to">Fat To:</label>
    <input type="number" name="fat_to" step="0.01" required><br>

    <label for="price">Price per Liter:</label>
    <input type="number" name="price" step="0.01" required><br>

    <input type="submit" value="Set Price">
</form>


</body>
</html>
