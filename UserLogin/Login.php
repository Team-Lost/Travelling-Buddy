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
    <link rel="stylesheet" href="../Assets/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="left col-md-8">
                <section class="home">
                    <div id="carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active" style='background-image: url(../Images/1.jpg);'>
                                <div class="container"> <!--bootstrap container-->
                                    <h1>Hellooo</h1>
                                    <p>Lone Traveller!</p>
                                </div>
                            </div>
                            <div class="carousel-item" style='background-image: url(../Images/2.jpg);'>
                                <div class="container"> <!--bootstrap container-->
                                    <h1>Travelling alone?</h1>
                                    <p>Let's find you some friend</p>
                                </div>
                            </div>
                            <div class="carousel-item" style='background-image: url(../Images/3.jpg);'>
                                <div class="container"> <!--bootstrap container-->
                                    <h1>Just Login</h1>
                                    <p>Or sign up if you don't have an ID yet.</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </section>
            </div>
            <div class = "right col-md-4">
                <form action="#" method="post" enctype="multipart/form-data" style="margin-top: 50%; padding-left: 4rem;padding-right: 4rem;">
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
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        function loadSignUp() {
            location.replace("SignUp.php")
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>