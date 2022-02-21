<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    function isValid($selector, $validator)
    {
        $currentDate = time();
        $query = "Select * from passwordReset where ResetSelector = '$selector' && ResetExpire >= '$currentDate'";
        $db = new database();
        $res = mysqli_query($db->connect(), $query);
        if (mysqli_num_rows($res) > 0) {
            if ($row = mysqli_fetch_assoc($res)) {
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row["ResetToken"]);
                if(!$tokenCheck) {
                    return false;
                }
            }
        } else {
            return true;
        }
    }

    include "../Model/Database.php";
    $passError = "";
    $selector = $_GET["selector"];
    $validator = $_GET['validator'];
    if (empty($selector) || empty($validator)) {
        echo "Could not validate your request1!";
    } else if (!(ctype_xdigit($selector) && ctype_xdigit($validator))) {
        echo "Could not validate your request2!";
    } else {
        if (isValid($selector, $validator)) {
            echo "Invalid or Expired Token! Please resubmit.";
            return;
        }
        if (isset($_POST['submit'])) {
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            if (empty($password1) || empty($password2)) {
                $passError = "Please fill out both the fields!";
            } else if ($password1 != $password2) {
                $passError = "Passwords don't match!";
            } else if (isValid($token, $validator)) {
                $passError = "Token expired! Please resubmit!";
            } else {
                $newPassword = password_hash($password1, PASSWORD_DEFAULT);
                $query = "Update User Set UserPassword = '$newPassword' where Mail = '$row[ResetMail]'";
                $db->updateTable($query);
                echo $query . "<br>";
                $query = "Delete from PasswordReset where ResetMail = '$row[ResetMail]'";
                $db->updateTable($query);
            }
        }
    }
    ?>
    <form action="#" method="post">
        <input type="hidden" name="selector" value="<?php echo $selector ?>">
        <input type="hidden" name="validator" value="<?php echo $validator ?>">
        <input type="password" name="password1" placeholder="Enter a new password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$">
        <input type="password" name="password2" placeholder="confirm password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$">
        <input type="submit" name="submit" value="Reset Password">
        <span class="error">* <?php echo $passError; ?></span>
    </form>
</body>

</html>