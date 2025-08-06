<?php
    require("connection.php");

    if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: AdminLogin.php");
    }

    // Handling record deletion if the delete button is clicked
    if(isset($_POST['delete_record'])) {
        $record_id = $_POST['record_id'];
        $sqlDelete = "DELETE FROM fat_prices WHERE id = $record_id";
        $con->query($sqlDelete);
        // Redirect to refresh the page after deletion
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    $sqlCow = "SELECT * FROM fat_prices WHERE milk_type = 'cow'";
    $resultCow = $con->query($sqlCow);

    $sqlBuffalo = "SELECT * FROM fat_prices WHERE milk_type = 'buffalo'";
    $resultBuffalo = $con->query($sqlBuffalo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/fatprices.css">
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
    <div class="pricetb">
        <h2>Existing Prices:</h2>

        <h3>Cow Milk Prices:</h3>
        <table>
            <tr>
                <th>Fat Range</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php
                while ($rowCow = $resultCow->fetch_assoc()) {
                    echo "<tr>
                            <td>{$rowCow['fat_from']} - {$rowCow['fat_to']}</td>
                            <td>{$rowCow['price']}</td>
                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='record_id' value='{$rowCow['id']}'>
                                    <button type='submit' name='delete_record' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
            ?>
        </table>

        <h3>Buffalo Milk Prices:</h3>
        <table>
            <tr>
                <th>Fat Range</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php
                while ($rowBuffalo = $resultBuffalo->fetch_assoc()) {
                    echo "<tr>
                            <td>{$rowBuffalo['fat_from']} - {$rowBuffalo['fat_to']}</td>
                            <td>{$rowBuffalo['price']}</td>
                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='record_id' value='{$rowBuffalo['id']}'>
                                    <button type='submit' name='delete_record' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
            ?>
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
