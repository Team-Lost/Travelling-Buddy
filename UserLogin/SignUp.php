<?php
session_start();
include "../Model/Database.php";
$nameError = $mailError = $genderError = $filesError = $filesError = $phnError = $pass1Error = $pass2Error = $success = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

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

    //---check mail---//
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) || empty($_POST['mail']) || !preg_match('/^([a-zA-Z\d\.-]+)@([a-zA-Z\d-]+)\.([a-zA-Z]{2,3})(\.[a-zA-Z]{2,3})?$/', $_POST['mail'])) {
        $mailError = "Please enter a valid email";
        $error = true;
    }
    //--check if email exists---//
    $mail = $_POST['mail'];
    $query = "Select count(Mail) from User where Mail = '$mail'";
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
        echo "<pre>";
        echo "test";
        print_r($_FILES['files']);
        echo "</pre>";
        $fileName = $_FILES['files']['name'];
        $fileTmpDestination = $_FILES['files']['tmp_name'];
        $fileSize = $_FILES['files']['size'];
        $fileError = $_FILES['files']['error'];
        $fileType = $_FILES['files']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        echo $fileActualExt;
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 2000000) {
                    $fileActualName = md5($fileExt[0]) . "." . $fileActualExt;
                    echo $fileActualName;
                    // $fileDestination = 'uploads/' . $fileActualName;
                    //move the file to temp lcoation to actual location//
                    // move_uploaded_file($fileTmpDestination, $fileDestination);
                } else {
                    $filesError = "File size exceeds 2 mb!";
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
        $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
        $query = "INSERT INTO USER(UserName, Mail, Phone, UserPassword) VALUES ('$_POST[userName]', '$_POST[mail]', '$_POST[phoneNumber]','$password')";
        echo "data inserted succesfully";
        $db->updateTable($query);
        $success = "Your account has been registered.Once the admin approves your account,a mail will be sent to confirm your account activation!";
        die;
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
    <title>SignUp 1</title>
</head>

<body>


    <!--Client Side Validation-->
    <div class="container">
        <form action="" class="signUp1" method="post" class="form-control" enctype="multipart/form-data">
            <div>
                <input class="form-control mt-3 mb-3" type="text" name="userName" placeholder="Full Name" minlength=3 maxlength=100>
                <span class="error">* <?php echo $nameError; ?></span>
            </div>
            <div>
                <input class="form-control mb-3" type="tel" name="phoneNumber" placeholder="Phone Number" minlength=4 maxlength=15>
                <span class="error">* <?php echo $phnError; ?></span>
            </div>
            <div>
                <input class="form-control mb-3" type="email" name="mail" placeholder="tv@gmail.com">
                <span class="error">* <?php echo $mailError; ?></span>
            </div>
            <div>
                <input type="radio" name="gender" value="male" required>Male
                <input type="radio" name="gender" value="female">Female
                <input type="radio" class="mb-3" name="gender" value="thirdGender">Third Gender
                <span class="error">* <?php echo $genderError; ?></span>
            </div>
            <div>
                <input class="form-control mb-3" type="password" name="password1" placeholder="password">
                <span class="error">* <?php echo $pass1Error; ?></span>
            </div>
            <div>
                <input class="form-control mb-3" type="password" name="password2" placeholder="confirm password">
                <span class="error">* <?php echo $pass2Error; ?></span>
            </div>
            <div>
                <input type="file" class="mb-3" name="files" id="files" accept="application/pdf,image/png,image/jpeg,image/jpg">
                <span class="error">* <?php echo $filesError; ?></span>
            </div>
            <div>
                <input class="form-control mb-3" type="submit" name="submit">
            </div>
            <div>
                <label><?php echo $success; ?></label>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>