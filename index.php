<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location:UserLogin/Login.php");
}
include "Model/Database.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <a href="UserLogin/Logout.php">Logout</a>
    <h2>Welcome to homepage!</h2>
</body>

</html>