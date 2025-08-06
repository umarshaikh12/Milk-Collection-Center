<?php
require("connection.php");

// Check if the delete parameter is set
if (isset($_GET['delete'])) {
    $farmerName = $_GET['delete'];

    // Perform the delete operation on 'farmerreg' table
    $stmtFarmer = $con->prepare("DELETE FROM farmerreg WHERE farmer_name = ?");
    $stmtFarmer->bind_param("s", $farmerName);

    // Perform the delete operation on 'milk_collection_details' table
    $stmtMilk = $con->prepare("DELETE FROM milk_collection WHERE farmer_name = ?");
    $stmtMilk->bind_param("s", $farmerName);

    if ($stmtFarmer->execute() && $stmtMilk->execute()) {
        echo "<script>alert('Farmer and related milk records deleted successfully')</script>";
    } else {
        echo "<script>alert('Error deleting farmer and related milk records')</script>";
    }

    $stmtFarmer->close();
    $stmtMilk->close();
}

// Fetch farmer details for display
$result = $con->query("SELECT * FROM farmerreg");
$farmerDetails = $result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Details</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/farmer_details.css">
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

    <div class="farmer-details-table">
        <h2>Farmer Details</h2>
        <table>
            <tr>
                <th>Farmer Name</th>
                <th>Phone Number</th>
                <th>Number of Cows</th>
                <th>Number of Buffalos</th>
                <th>Address</th>
                <th>Aadhar Number</th>
                <th>Bank Account</th>
                <th>Action</th>
            </tr>
            <?php foreach ($farmerDetails as $farmer) : ?>
                <tr>
                    <td><?php echo $farmer['farmer_name']; ?></td>
                    <td><?php echo $farmer['phone_no']; ?></td>
                    <td><?php echo $farmer['Number_of_Cows']; ?></td>
                    <td><?php echo $farmer['Number_of_Buffalos']; ?></td>
                    <td><?php echo $farmer['address']; ?></td>
                    <td><?php echo $farmer['adhar_number']; ?></td>
                    <td><?php echo $farmer['bank_account']; ?></td>
                    <td>
                        <button><a href="?delete=<?php echo $farmer['farmer_name']; ?>" onclick="return confirm('Are you sure you want to delete this farmer and related milk records?')">Delete</a>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <?php
    if (isset($_POST['logout'])) {
        session_destroy();
        header("location: AdminLogin.php");
    }
    ?>
</body>

</html>