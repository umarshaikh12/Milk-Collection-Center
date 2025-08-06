<?php
    require("connection.php");


    if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: AdminLogin.php");
    }

    // Fetch total number of registered farmers
    $result = $con->query("SELECT COUNT(*) AS totalFarmers FROM farmerreg");
    $row = $result->fetch_assoc();
    $totalFarmers = $row['totalFarmers'];

    // Fetch total milk of cows and buffalos date-wise
    $milkResult = $con->query("SELECT collection_date, 
                                       SUM(CASE WHEN milk_type = 'Cow' THEN milk_quantity ELSE 0 END) AS cowMilk,
                                       SUM(CASE WHEN milk_type = 'Buffalo' THEN milk_quantity ELSE 0 END) AS buffaloMilk
                                FROM milk_collection 
                                GROUP BY collection_date");
    $milkDetails = $milkResult->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="CSS/home.css">
    <style>
        .content {
            margin: 20px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.12);
        }
        h2 {
            color: #145a32;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #99a3a4;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #145a32;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        button[type="submit"] {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #c0392b;
        }
    </style>
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
                <!-- <li><a href="animal_food_details.php">Animal Food Details</a></li> -->
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
        <h2>Total Number of Farmers : <?php echo $totalFarmers; ?></h2>

        <h2>Total Milk Collection :</h2>
        <table>
            <tr>
                <th>Collection Date</th>
                <th>Cow Milk (liters)</th>
                <th>Buffalo Milk (liters)</th>
            </tr>
            <?php foreach ($milkDetails as $milk) : ?>
                <tr>
                    <td><?php echo $milk['collection_date']; ?></td>
                    <td><?php echo $milk['cowMilk']; ?></td>
                    <td><?php echo $milk['buffaloMilk']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <?php
        if(isset($_POST['logout']))
        {
            session_destroy();
            header("location: AdminLogin.php");
        }
    ?>
</body>
</html>
