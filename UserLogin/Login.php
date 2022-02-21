<?php
session_start();
if (isset($_SESSION['UserID'])) {
    header("Location: ../index.php");
}

include "../Model/Database.php";

$mailError = $passError = $loginError = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $error = false;
    if (empty($_POST['mail'])) {
        $mailError = "Mail cannot be empty";
        $error = true;
    }
    if (empty($_POST['password'])) {
        $passError =  "Password field can not be empty";
        $error = true;
    }
    $check = false;
    if (!$error) {
        $mail = $_POST['mail'];
        $db = new database();
        $query = "Select * from user where Mail = '$mail' limit 1";
        $res = mysqli_query($db->connect(), $query);
        if (mysqli_num_rows($res) > 0) {
            if ($row = mysqli_fetch_assoc($res)) {
                $dbPassword = $row['UserPassword'];
                $uName = $row['UserName'];
                $uID = $row['UserID'];
                $uMail = $row['Mail'];
                $uPhn = $row['Phone'];
                $uRank = $row['Rank'];
                $check = true;
            }
        }
    }
    if (!$check) {
        $loginError =  "Check your inputs";
    } else {
        if (password_verify($_POST['password'], $dbPassword)) {
            if (!$uRank = 'PENDING') {
                echo "Login Successful";
                $_SESSION['UserID'] = $uID;
                $_SESSION['UserName'] = $uName;
                $_SESSION['Mail'] = $uMail;
                $_SESSION['Phone'] = $uPhn;
                $_SESSION['AccessRank'] = $uRank;
                header("Location: ../index.php");
                die;
            } else {
                $loginError = "Your account is not approved by admin yet!";
            }
        } else {
            $loginError = "Password doesn't match";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <form action="" class="signUp1" method="post" class="form-control" enctype="multipart/form-data">
            <div>
                <input class="form-control mb-3" type="email" name="mail" placeholder="tv@gmail.com" title="Please enter a valid mail!">
                <span class="error">* <?php echo $mailError; ?></span>
            </div>
            <div>
                <input class="form-control mb-3" type="password" name="password" placeholder="password">
                <span class="error">* <?php echo $passError; ?></span>
            </div>
            <div>
                <input class="form-control mb-3" type="submit" name="submit">
            </div>
            <div>
                <p><?php echo $loginError; ?></p>
            </div>
            <a href="ForgotPassword.php">Forgot your password?</a>
            <a href = "SignUp.php">Sign Up</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>