<?php
    require("connection.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="CSS/adminlogin.css">
</head>
<body>
    <h2>Admin Login</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="AdminName">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="AdminPass">
        <br>
        <button type="submit" name="Signin">Sign In</button>
    </form>
</body>
</html>



<?php
if (isset($_POST['Signin'])) 
{
    if (isset($_POST['AdminName']) && isset($_POST['AdminPass'])) 
    {
        $username = $_POST['AdminName'];
        $password = $_POST['AdminPass'];
        $query = "SELECT * FROM `admin_login` WHERE `Admin_name`='$username' AND `Password`='$password'";

        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) == 1) 
        {
            session_start();
            $_SESSION['AdminLoginId']=$_POST['AdminName'];
            header("location: Adminpanel.php");
        }
         else 
        {
            echo "<script>alert('Incorrect Password')</script>";
        }
    } 
    else 
    {
        
    }
}
?>