<?php
    require("connection.php");

    // Check if the user is logged in
    if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: AdminLogin.php");
    }

    // Logout functionality
    if(isset($_POST['logout']))
    {
        session_destroy();
        header("location: AdminLogin.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Food Details</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/animal_food_details.css">
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
                <li><a href="animal_food_details.php">Animal Food Details</a></li>
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

    <div class="content">
        <h2>Animal Food Records</h2>

        <?php
            // Retrieve and display records from the animal_food_table
            $query = "SELECT * FROM animal_food_table";
            $result = mysqli_query($con, $query);

            if(mysqli_num_rows($result) > 0) {
                echo "<table border='1'>";
                echo "<tr><th>Name</th><th>Quantity (kg)</th><th>Price per kg</th><th>Date</th></tr>";

                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['quantity']}</td>";
                    echo "<td>{$row['price_per_kg']}</td>";
                    echo "<td>{$row['date']}</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No records found.";
            }
        ?>
    </div>
</body>
</html>
