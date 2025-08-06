<?php
require("connection.php");

// Fetch unique farmer names from the database
$sqlNames = "SELECT DISTINCT farmer_name FROM milk_collection";
$resultNames = $con->query($sqlNames);

if ($resultNames === FALSE) {
    die("Error fetching farmer names: " . $con->error);
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
    <title>Farmer Details</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/payment_details.css">
    <script>
        function showDetails(milkType) {
            document.getElementById('select_farmer').style.display = 'block';
            document.getElementById('milk_type').value = milkType;
        }

        function toggleDetails(farmerId) {
            var cowDetails = document.getElementById('details_cow_' + farmerId);
            var buffaloDetails = document.getElementById('details_buffalo_' + farmerId);
            cowDetails.style.display = (cowDetails.style.display === 'none') ? 'table-row' : 'none';
            buffaloDetails.style.display = 'none'; // Hide buffalo details
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
            <li><a href="milk_coll_details.php">Milk Collection Details</a></li>
            <a href="Fatprices.php">Fat Prices</a></li>
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

<center style="margin-top: 30px;">
    <div class="food">
    <button onclick="showDetails('cow')">Cow</button>
    <!-- Sell Food Button -->
    <button onclick="showDetails('buffalo')">Buffalo</button>
    </div>
</center>

<?php
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: AdminLogin.php");
}
?>

<div id="select_farmer" style="display: none">
<form method="POST" action="">
    <input type="hidden" name="milkType" id="milk_type" value="">
    <label for="selectFarmer">Select Farmer:</label>
    <select name="selectFarmer" id="selectFarmer">
        <?php
        while ($row = $resultNames->fetch_assoc()) {
            $farmerName = $row["farmer_name"];
            echo "<option value='$farmerName'>$farmerName</option>";
        }
        ?>
    </select>
    <button type="submit" name="viewDetails">View Details</button>
</form>
</div>

<?php
echo "<center>";
if (isset($_POST['viewDetails'])) {
    $selectedFarmer = $_POST['selectFarmer'];
    $milkType = $_POST['milkType'];
    echo "<h2>Details for Farmer: $selectedFarmer</h2>";

    // Fetch details based on selected milk type
    processDetails($con, $selectedFarmer, $milkType);
}
echo "</center>";
?>

<table>
    <tbody>
        <?php
        while ($row = $resultNames->fetch_assoc()) {
            $farmerName = $row["farmer_name"];
            echo "<tr onclick='toggleDetails(\"$farmerName\")'>";
            echo "<td>" . $farmerName . "</td>";
            echo "</tr>";

            // Fetch details for cow milk
            processDetails($con, $farmerName, 'cow');

            // Fetch details for buffalo milk
            processDetails($con, $farmerName, 'buffalo');
        }
        ?>
    </tbody>
</table>

</body>
</html>

<?php
// Close database connection
$con->close();

function processDetails($con, $farmerName, $milkType) {
    $sqlDetails = "SELECT milk_quantity, milk_fat, collection_date FROM milk_collection WHERE farmer_name = '$farmerName' AND milk_type = '$milkType'";
    $resultDetails = $con->query($sqlDetails);

    if ($resultDetails === FALSE) {
        die("Error fetching details for $farmerName: " . $con->error);
    }

    // Initialize variables
    $totalMilk = 0;
    $totalFat = 0;
    $rowCount = 0;
    $meanFat = 0;

    // Display details in a nested table
    echo "<tr id='details_${milkType}_${farmerName}' class='details' style='display: none;'>";
    echo "<td colspan='1'>";
    echo "<table>";
    echo "<thead><tr><th>Milk Type</th><th>Milk Quantity</th><th>Milk Fat</th><th>Collection Date</th></tr></thead>";
    echo "<tbody>";

    // Display individual records
    while ($detailRow = $resultDetails->fetch_assoc()) {
        $totalMilk += $detailRow["milk_quantity"];
        $totalFat += $detailRow["milk_fat"];
        $rowCount++;

        echo "<tr>";
        echo "<td>" . $milkType . "</td>";
        echo "<td>" . $detailRow["milk_quantity"] . "</td>";
        echo "<td>" . $detailRow["milk_fat"] . "</td>";
        echo "<td>" . $detailRow["collection_date"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo "</td></tr>";
}
?>
