<?php
session_start();
if (isset($_COOKIE['rememberUserCookie'])) {
    $cookieID = $_COOKIE['rememberUserCookie'];
    $db = new Database();
    $query = "Select * from user where UserID = $cookieID limit 1";
    $res = mysqli_query($db->connect(), $query);
    if (mysqli_num_rows($res) > 0) {
        if ($row = mysqli_fetch_assoc($res)) {
            $_SESSION['UserName'] = $row['UserName'];
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['Mail'] = $row['Mail'];
            $_SESSION['Phone'] = $row['Phone'];
            $_SESSION['Rank'] = $row['Rank'];
        }
    }
    header("Location: ../home.php");
}

if (isset($_SESSION['UserID'])) {
    header("Location: ../index.php");
}

include "../Model/Database.php";
/*--------If cookie is set-----*/

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
            if ($uRank != 'PENDING') {
                setcookie("rememberUserCookie", $uID, time() + 60);
                echo "Login Successful";
                $_SESSION['UserID'] = $uID;
                $_SESSION['UserName'] = $uName;
                $_SESSION['Mail'] = $uMail;
                $_SESSION['Phone'] = $uPhn;
                $_SESSION['Rank'] = $uRank;
                header("Location: ../home.php");
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
    <script src="https://kit.fontawesome.com/cee0f4dddc.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="../Assets/css/home.css" rel="stylesheet">
    <style>
        body {
            background-image: linear-gradient(to bottom right, gray, white);
            min-height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
        }

        button {
            height: 40px;
        }
    </style>
</head>

<body>
    <br><br><br>
    <div class="container container-fitter p-4">
        <form action="#" method="post" enctype="multipart/form-data">
            <h1 class="text-center">Sign In</h1>
            <label for="">Email:</label>
            <input type="email" class="form-control" id="formInput" name="mail" placeholder="tv@gmail.com" title="Please enter a valid mail!">
            <p class="error text-center"> <?php echo $mailError; ?></p>
            <label for="">Password:</label>
            <input type="password" class="form-control" id="formInput" name="password" placeholder="password">
            <p class="error text-center"> <?php echo $passError; ?></p>
            <button type="submit" class="btn btn-primary form-control" name="Submit">Login</button>
            <p class="text-center"><?php echo $loginError; ?></p>
            <a href="ForgotPassword.php" class="formAnchor">
                <p class="text-center">Forgotten password?</p>
            </a>
            <div class="gap-gray"></div>
            <button type="button" class="btn btn-info form-control margin-t15" onclick="javascript:loadSignUp()">Create New Account</button>
        </form>
    </div>
    <script>
        function loadSignUp() {
            location.replace("SignUp.php")
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>