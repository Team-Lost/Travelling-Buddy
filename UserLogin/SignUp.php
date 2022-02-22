<?php
session_start();
include "../Model/Database.php";
$nameError = $mailError = $genderError = $filesError = $filesError = $phnError = $pass1Error = $pass2Error = $success = $userName =  $mail = $phoneNumber = $checkMail = $checkPhone = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre>";

    //-------------------server side validation======================//
    $error = false;
    //---check name----//
    //error for anything except letters
    if (is_numeric($_POST['userName']) || !preg_match('/^[a-zA-Z ]+$/', $_POST['userName'])) {
        $nameError = "Username can only contain letters!";
        $error = true;
    }
    //error for not matching the length requirement;   
    if (!(strlen($_POST['userName']) >= 3 && strlen($_POST['userName']) <= 100)) {
        $nameError = "Username doesn't satisfy the required length!";
        $error = true;
    }

    //---check phone---//
    if (!preg_match('/^\+?.[0-9]+$/', $_POST['phoneNumber'])) {
        $phnError = "Phone can only contain digits and optionally + in the first position";
        $error = true;
    }
    if (!(strlen($_POST['phoneNumber']) >= 4 && strlen($_POST['phoneNumber']) <= 15)) {
        $phnError = "Phone number doesnot satisfy the required length!";
        $error = true;
    }
    //check if phone number already exists--//
    $checkPhone = $_POST['phoneNumber'];
    $query = "Select count(Phone) from User where Phone = '$checkPhone'";
    $db = new database();
    $check = 0;
    $res = mysqli_query($db->connect(), $query);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $check = $row['count(Phone)'];
            break;
        }
    }
    if ($check == 1) {
        $mailError = "Phone number already exists!";
        $error = true;
    }

    //---check mail---//
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) || empty($_POST['mail']) || !preg_match('/^([a-zA-Z\d\.-]+)@([a-zA-Z\d-]+)\.([a-zA-Z]{2,3})(\.[a-zA-Z]{2,3})?$/', $_POST['mail'])) {
        $mailError = "Please enter a valid email";
        $error = true;
    }
    //--check if email exists---//
    $checkMail = $_POST['mail'];
    $query = "Select count(Mail) from User where Mail = '$checkMail'";
    $db = new database();
    $check = 0;
    $res = mysqli_query($db->connect(), $query);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $check = $row['count(Mail)'];
            break;
        }
    }
    if ($check == 1) {
        $mailError = "Email already exists!";
        $error = true;
    }


    //---check radio button---//
    if (empty($_POST['gender'])) {
        $genderError = "Please select atleast one!";
        $error = true;
    }
    //---check password---//
    if (strlen($_POST['password1']) < 8) {
        echo strlen($_POST['password1']);
        $pass1Error = "Password must be atleast 8 characters long!";
        $error = true;
    }
    if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$/', $_POST['password1'])) {
        $pass1Error = "Password must contain atleast one uppercase letter,one lowercase letter,one digit and one special character!";
        $error = true;
    }
    if ($_POST['password1'] != $_POST['password2']) {
        $pass2Error = "Passwords don't match!";
        $error = true;
    }
    //---check file---//        
    if (empty($_FILES['files'])) {
        $filesError = "Please select a file in pdf or image format!";
        $error = true;
    } else {
        //define
        $fileName = $fileTmpDestination = $fileError = $fileType = $fileExt = $fileActualExt = $fileActualName = "";
        $fileSize = -1;
        $file = $_FILES['files'];
        // echo "<pre>";
        // echo "test";
        // print_r($_FILES['files']);
        // echo "</pre>";
        $fileName = $_FILES['files']['name'];
        $fileTmpDestination = $_FILES['files']['tmp_name'];
        $fileSize = $_FILES['files']['size'];
        $fileError = $_FILES['files']['error'];
        $fileType = $_FILES['files']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 8000000) {
                    $fileActualName = md5($fileExt[0]) . "." . $fileActualExt;
                    if ($fileActualExt == "pdf") {
                        $fileDestination = '../UserIdentification/Documents/' . $fileActualName;
                    } else {
                        $fileDestination = '../UserIdentification/Images/' . $fileActualName;
                    }
                } else {
                    $filesError = "File size exceeds 8 mb!";
                    $error = true;
                }
            } else {
                $filesError = "There was an error while uploading this file!";
                $error = true;
            }
        } else {
            $filesError = "File of this format is not supported!";
            $error = true;
        }
    }
    if (!$error) {
        $db = new database();
        $userName = trim($_POST['userName']);
        $mail = trim($_POST['mail']);
        $phoneNumber = trim($_POST['phoneNumber']);
        $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
        //move the file to temp lcoation to actual location//
        move_uploaded_file($fileTmpDestination, $fileDestination);
        $query = "INSERT INTO USER(UserName, Mail, Phone, Gender, UserPassword, IDFile) VALUES ('$userName', '$mail', '$phoneNumber','$_POST[gender]','$password','$fileActualName')";
        //echo $query;
        echo "data inserted succesfully";
        $db->updateTable($query);
        $userName = "";
        $phoneNumber = "";
        $mail = "";
        $success = "Your account has been registered.Once the admin approves your account,a mail will be sent to confirm your account activation!";
        //die;
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
    <title>SignUp</title>
    <!--Main CSS-->
    <style>
        :root {
            font-size: 100%;
            font-size: 16px;
            line-height: 1.5;
        }

        body {
            padding: 0;
            margin: 0;
            font-weight: 500;
        }

        .split-screen {
            display: flex;
            flex-direction: column;
        }

        .left {
            height: 200px;
            background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.5)), url("../Images/1.jpg");
            background-repeat: no-repeat;
            background-size: auto 100vh;

        }

        .left,
        .right {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left .copy {
            color: white;
            text-align: center;
        }

        .right .copy {
            text-align: center;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="tel"],
        form input[type="password"] {
            display: block;
            width: 100%;
            box-sizing: border-box;
            border-radius: 8px;
        }

        label {
            padding: 0 5px;
        }

        form input[type="submit"] {
            width: 100%;
            display: block;
            border-radius: 15px;
        }

        form input[type="file"] {
            margin: 0;
            padding: 2rem 1.5rem;
            font: 1rem/1.5 "PT Sans", Arial, sans-serif;
            color: #5a5a5a;
        }

        @media screen and (min-width:900px) {
            .split-screen {
                flex-direction: row;
                height: 100vh;
            }

            .left,
            .right {
                display: flex;
                width: 50%;
                height: auto;
            }
        }
    </style>
</head>

<body>


    <!--Client Side Validation-->
    <div class="split-screen">
        <div class="left">
            <section class="copy">
                <h1>Travelling Buddy</h1>

            </section>
        </div>
        <div class="right">
            <form action="" class="signUp1" method="post" class="form-control" enctype="multipart/form-data">
                <section class="copy">
                    <h2>Sign Up</h2>
                    <div class="login-container">
                        <p>Already Have an account?</p>
                        <a href="Login.php">Sign In</a>
                    </div>
                </section>
                <div class="input-container">
                    <label for="userName">Full Name*</label>
                    <input class="form-control mb-3" type="text" name="userName" id="userName" placeholder="Full Name(Letters only)" value="<?php echo $userName; ?>" minlength=3 maxlength=100 required pattern="^[a-zA-Z ]+$">
                    <span class="error"><?php echo $nameError; ?></span>
                </div>
                <div class="input-container">
                    <label for="phoneNumber" class="mt-3">Phone Number*</label>
                    <input class="form-control mb-3" type="tel" name="phoneNumber" id="phoneNumber" placeholder="Phone Number(Only plus and digits are allowed)" value="<?php echo $phoneNumber; ?>" minlength=4 maxlength=15 required pattern="^\+?.[0-9]+$">
                    <span class="error"> <?php echo $phnError; ?></span>
                </div>
                <div class="input-container">
                    <label for="mail" class="mt-3">Mail*</label>
                    <input class="form-control mb-3" type="email" name="mail" id="mail" placeholder="@" value="<?php echo $mail; ?>" required>
                    <span class="error"><?php echo $mailError; ?></span>
                </div>
                <div class="input-container">
                    <label for="gender" class="mt-3">Gender*</label>
                    <input type="radio" name="gender" value="male" required>Male
                    <input type="radio" name="gender" value="female">Female
                    <input type="radio" class="mb-3" name="gender" value="thirdGender">Third Gender
                    <span class="error"><?php echo $genderError; ?></span>
                </div>
                <div class="input-container">
                    <label for="password1" class="mt-3">Password*</label>
                    <input class="form-control mb-3" type="password" name="password1" placeholder="password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$">
                    <span class="error"><?php echo $pass1Error; ?></span>
                </div>
                <div class="input-container">
                    <label for="password2" class="mt-3">Confirm Password*</label>
                    <input class="form-control mb-3" type="password" name="password2" placeholder="confirm password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$">
                    <span class="error"><?php echo $pass2Error; ?></span>
                </div>
                <div class="input-container">
                    <label for="files" class="mt-3">Files*</label>
                    <input type="file" name="files" id="files" accept="application/pdf,image/png,image/jpeg,image/jpg" required>
                    <span class="error"><?php echo $filesError; ?></span>
                </div>
                <div class="input-container">
                    <input class="form-control mt-3" type="submit" name="submit">
                </div>
                <div>
                    <label><?php echo $success; ?></label>
                </div>
        </div>
        </form>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>