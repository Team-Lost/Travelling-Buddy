<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/cee0f4dddc.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="..\Assets\css\home.css">
    <style>
        .full-body {
            height: 100vh;
            width: 100vh;
        }
    </style>

</head>

<body class="body-ssp-fb">
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
                if (!$tokenCheck) {
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
    <div class="container container-fitter" style="margin-top: 30vh">
        <form action="#" method="post">
            <div class="form-group">
                <h3 class="text-center p-2">Enter your new password!</p>
                <input class="form-control m-1" type="hidden" name="selector" value="<?php echo $selector ?>">
                <input class="form-control m-1" type="hidden" name="validator" value="<?php echo $validator ?>">
                <input class="form-control m-1" type="password" name="password1" placeholder="Enter a new password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$">
                <input class="form-control m-1" type="password" name="password2" placeholder="confirm password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$">
                <input class="form-control btn btn-info margin-t15" type="submit" name="submit" value="Reset Password">
                <p class="text-center"> <?php echo $passError; ?></p>
            </div>
        </form>
    </div>
    <script>
        var container = document.getElementsByClassName("container-fitter");
        if (screen.width > 820) {
            container[0].setAttribute("style", "width: 40%; margin-top: 30vh;");
        } else {
            container[0].setAttribute("style", "width: 90%; margin-top: 30vh;");
        }
    </script>
</body>

</html>