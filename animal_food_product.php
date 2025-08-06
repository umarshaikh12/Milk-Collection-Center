<?php
    require("connection.php");

    if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: AdminLogin.php");
    }

    if(isset($_POST['logout']))
    {
        session_destroy();
        header("location: AdminLogin.php");
    }

    // Handle Animal Food Form submission
    if(isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $quantity = $_POST['quantity'];
        $price_per_kg = $_POST['price_per_kg'];
        $date = $_POST['date'];

        $query = "INSERT INTO animal_food_table (name, quantity, price_per_kg, date) VALUES ('$name', '$quantity', '$price_per_kg', '$date')";
        $result = mysqli_query($con, $query);

        if ($result) {
            // Insert successful, show an alert
            echo '<script>alert("Animal food data inserted successfully!");</script>';
        } else {
            // Insert failed, show an alert
            echo '<script>alert("Error: ' . mysqli_error($con) . '");</script>';
        }
    }

    // Handle Sell Food Form submission
    if(isset($_POST['sellFood'])) {
        $farmerName = mysqli_real_escape_string($con, $_POST['farmerName']);
        $productName = mysqli_real_escape_string($con, $_POST['productName']);
        $sellQuantity = $_POST['sellQuantity'];
        $sellDate = $_POST['sellDate'];

        // Insert the sale information into the sell_food_table
        $sellQuery = "INSERT INTO sell_food_table (farmer_name, product_name, quantity_sold, sale_date) VALUES ('$farmerName', '$productName', '$sellQuantity', '$sellDate')";
        $sellResult = mysqli_query($con, $sellQuery);

        if ($sellResult) {
            // Insert successful, show an alert
            echo '<script>alert("Sell food data inserted successfully!");</script>';
        } else {
            // Insert failed, show an alert
            echo '<script>alert("Error: ' . mysqli_error($con) . '");</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Food Form</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/animal_food_product.css">
    <script>
        function showAddFoodForm() {
            document.getElementById('animal-food-form').style.display = 'block';
            document.getElementById('sell-food-form').style.display = 'none';
        }

        function showSellFoodForm() {
            document.getElementById('animal-food-form').style.display = 'none';
            document.getElementById('sell-food-form').style.display = 'block';
        }
    </script>
</head>

<body>
    <div class="header">
        <ul class="navbar">
            <div class="head1">
                <li><a href="Adminpanel.php">Home</a></li>
                <li><a href="farmerreg.php">Farmer Registration</a></li>
                <li><a href="addmilk.php">Add Milk</a></li>
                <li><a href="setprice.php">Fat Range</a></li>
                <li><a href="animal_food_product.php">Animal Food Form</a></li>
                <li><a href="milk_collection_details.php">Milk Collection Details</a></li>
                <li><a href="Fatprices.php">Fat Prices</a></li>
                <li><a href="farmer_details.php">Farmer Details</a></li>
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

    <!-- Add Food Button -->
    <center>
    <div class="food">
    <button onclick="showAddFoodForm()">Add Food</button>

    <!-- Sell Food Button -->
    <button onclick="showSellFoodForm()">Sell Food</button>
    </div>
    </center>

    <!-- Animal Food Form -->
    <div id="animal-food-form" style="display: none;">
        <h2>Add Food</h2>
        <form method="POST" action="animal_food_product.php">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="quantity">Quantity (kg):</label>
            <input type="number" name="quantity" required>

            <label for="price_per_kg">Price per kg:</label>
            <input type="number" step="0.01" name="price_per_kg" required>

            <label for="date">Date:</label>
            <input type="date" name="date" required>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <!-- Sell Food Form -->
    <div id="sell-food-form" style="display: none;">
        <h2>Sell Food</h2>
        <form method="POST">
            <label for="farmerName">Farmer Name:</label>
            <select name="farmerName" required>
                <?php
                    // Retrieve farmer names from the farmerreg table
                    $query = "SELECT `farmer_name` FROM `farmerreg`";
                    $result = mysqli_query($con, $query);

                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['farmer_name']}'>{$row['farmer_name']}</option>";
                        }
                    }
                ?>
            </select>

            <label for="productName">Product Name:</label>
            <select name="productName" required>
                <?php
                    // Retrieve product names from the animal_food_table
                    $query = "SELECT DISTINCT name FROM animal_food_table";
                    $result = mysqli_query($con, $query);

                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['name']}'>{$row['name']}</option>";
                        }
                    }
                ?>
            </select>

            <label for="sellQuantity">Quantity:</label>
            <input type="number" name="sellQuantity" required>

            <label for="sellDate">Date:</label>
            <input type="date" name="sellDate" required>

            <button type="submit" name="sellFood">Submit</button>
        </form>
    </div>
</body>
</html>
