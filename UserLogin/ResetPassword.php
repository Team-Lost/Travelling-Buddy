<?php
include "../Model/Database.php";
$passError = "";
if (isset($_POST['submit'])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $selector = $_POST["selector"];
    $validator = $_POST['validator'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    if (empty($password1) || empty($password2)) {
        $passError = "Please fill out both the fields!";
    } else if ($password1 != $password2) {
        $passError = "Passwords don't match!";
    }
    //
    else {
        $currentDate = time();
        echo '<br>'.$currentDate.'<br>';
        //Expire er ager selector ache kina check  
        $query = "Select * from passwordReset where ResetSelector = '$selector' && ResetExpire >= '$currentDate'";
        echo $query . "<br>";
        $db = new database();
        $cnt = 0;
        $res = mysqli_query($db->connect(), $query);
        
        if (mysqli_num_rows($res) > 0) {
            if ($row = mysqli_fetch_assoc($res)) {
                $cnt++;
                print_r($row);
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row["ResetToken"]);
                if (!$tokenCheck) {
                    $passError = "You need to resubmit your reset request!";
                    header("Location: ForgotPassword.php");
                } else {
                    //  $query = "Select Password from User where Mail = ".$row['ResetMail'];
                    // echo $query."<br>";
                    $newPassword = password_hash($password1, PASSWORD_DEFAULT);
                    $query = "Update User Set UserPassword = '$newPassword' where Mail = '$row[ResetMail]'";
                    $db->updateTable($query);
                    echo $query . "<br>";
                    $query = "Delete from PasswordReset where ResetMail = '$row[ResetMail]'";
                    $db->updateTable($query);
                    //header("Location: Login.php");
                }
            }
        }
        if ($cnt == 0) {
            $passError = "You need to resubmit your reset request!";
            echo $passError;
        }
        echo $query;
    }
}
?>
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
    $selector = $_GET["selector"];
    echo $selector . "<br>";
    $validator = $_GET['validator'];
    echo $validator . "<br>";
    if (empty($selector) || empty($validator)) {
        echo "Could not validate your request!";
    } else {
        //check if they are valid hexadecimal format
        if (ctype_xdigit($selector) && ctype_xdigit($validator)) {
    ?>
            <form action="#" method="post">
                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">
                <input type="password" name="password1" placeholder="Enter a new password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$">
                <input type="password" name="password2" placeholder="confirm password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$">
                <input type="submit" name="submit" value="Reset Password">
                <span class="error">* <?php echo $passError; ?></span>
            </form>
    <?php
        }
    }
    ?>

</body>

</html>