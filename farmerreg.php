<?php
require("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reg"])) {
    $farmer_name = $_POST["farmer_name"];
    $phone = $_POST["phone"];
    $adhar = $_POST["adhar"];
    $nuofcows = $_POST["nuofcows"];
    $nuofbuffalos = $_POST["nuofbuffalos"];
    $address = $_POST["address"];
    $bank_account = $_POST["bank_account"];

    $stmt = $con->prepare("INSERT INTO farmerreg (`farmer_name`, `phone_no`, `adhar_number`, `Number_of_Cows`, `Number_of_Buffalos`, `address`, `bank_account`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $farmer_name, $phone, $adhar, $nuofcows, $nuofbuffalos, $address, $bank_account);

    if ($stmt->execute()) {
        echo "<script>alert('Register Successfully')</script>";
    } else {
        die("Error: " . $stmt->error);
    }

    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/farmer_reg.css">
    <style>
        .cattle-row {
            display: flex;
            justify-content: space-between;
        }

        .cattle-info {
            width: 48%; /* Adjust the width as needed */
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
    if (isset($_POST['logout'])) {
        session_destroy();
        header("location: AdminLogin.php");
    }
    ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="freg">
        <label for="name">Name:</label>
        <input type="text" id="name" name="farmer_name" required>
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>
        <label for="adhar">Aadhar Number:</label>
        <input type="text" id="adhar" name="adhar" required>

        <!-- Display Number of Cows and Buffalos in one row -->
        <div class="cattle-row">
            <div class="cattle-info">
                <label for="nuofcows">Number of Cows:</label>
                <input type="text" id="nuofcows" name="nuofcows" required>
            </div>
            <div class="cattle-info">
                <label for="nuofbuffalos">Number of Buffalos:</label>
                <input type="text" id="nuofbuffalos" name="nuofbuffalos" required>
            </div>
        </div>

        <label for="bank">Bank Account:</label>
        <input type="text" id="bank" name="bank_account" required>
        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>
        <button type="submit" name="reg">Register</button>
    </form>
</body>

</html>
