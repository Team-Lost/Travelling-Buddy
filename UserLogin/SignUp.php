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
    if (!preg_match("/^\+?.[0-9]+$/", $_POST['phoneNumber'])) {
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
        $phnError = "Phone number already exists!";
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
        //echo strlen($_POST['password1']);
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
        //echo "data inserted succesfully";
        $db->updateTable($query);
        $userName = "";
        $phoneNumber = "";
        $mail = "";
        //$success = "Your account has been registered. Once the admin approves your account, a mail will be sent to confirm your account activation!";
        //die;
        $success = "Registered, Wait for admin approval.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/css/signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Sign Up</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="left col-md-4 lg-4">
                <form action="" class="signUp1" method="post" class="form-control" enctype="multipart/form-data" style="padding-left: 2rem;padding-right: 2rem;">
                    <section class="copy">
                        <h2 class="fw-bold">Sign Up</h2>
                        <div class="login-container">
                            <p class="fw-light">Already Have an account?<br><a href="Login.php">Sign In</a></p>
                        </div>
                    </section>
                    <div class="input-container">
                        <label for="userName">Full Name:</label>
                        <input class="form-control shadow-sm" type="text" name="userName" id="userName" placeholder="Full Name (Letters only)" value="<?php echo $userName; ?>" minlength=3 maxlength=100 required pattern="^[a-zA-Z ]+$">
                        <span class="text-danger error"><?php echo $nameError; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="phoneNumber" class="">Phone Number:</label>
                        <input class="form-control shadow-sm " type="tel" name="phoneNumber" id="phoneNumber" placeholder="Phone Number" value="<?php echo $phoneNumber; ?>" minlength=4 maxlength=15 required pattern="^\+?.[0-9]+$">
                        <span class="text-danger error"> <?php echo $phnError; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="mail" class="">Mail:</label>
                        <input class="form-control shadow-sm " type="email" name="mail" id="mail" placeholder="@" value="<?php echo $mail; ?>" required>
                        <span class="text-danger error"><?php echo $mailError; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="gender" class="">Gender:</label>
                        <input class="mx-1" type="radio" name="gender" value="male" required>Male
                        <input class="mx-1" type="radio" name="gender" value="female">Female
                        <input class="mx-1" type="radio" class="" name="gender" value="thirdGender">Third Gender
                        <span class="text-danger error"><?php echo $genderError; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="password1" class="">Password:</label>
                        <input class="form-control shadow-sm " type="password" name="password1" placeholder="Password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$">
                        <span class="text-danger error"><?php echo $pass1Error; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="password2" class="">Confirm Password:</label>
                        <input class="form-control shadow-sm " type="password" name="password2" placeholder="Confirm password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#\?\!\@\$\%\^\&\*\-]).{8,}$">
                        <span class="text-danger error"><?php echo $pass2Error; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="files" class="">Files:</label>
                        <input type="file" name="files" id="files" accept="application/pdf,image/png,image/jpeg,image/jpg" required>
                        <span class="text-danger error"><?php echo $filesError; ?></span>
                    </div>
                    <div class="input-container">
                        <input class="form-control  shadow-sm" type="submit" name="submit">
                        <p class="text-center"><?php echo $success; ?></p>
                    </div>
                </form>
            </div>
            <div class="right col-md-8 lg-8">
                <section class="home">
                    <div id="carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active" style='background-image: url(../Images/4.jpg);'>
                                <div class="container">
                                    <!--bootstrap container-->
                                    <h1>Hellooo</h1>
                                    <p>Lone Traveller!</p>
                                </div>
                            </div>
                            <div class="carousel-item" style='background-image: url(../Images/5.jpg);'>
                                <div class="container">
                                    <!--bootstrap container-->
                                    <h1>Sign up</h1>
                                    <p>and we will find you some buddies.</p>
                                </div>
                            </div>
                            <div class="carousel-item" style='background-image: url(../Images/7.jpg);'>
                                <div class="container">
                                    <!--bootstrap container-->
                                    <h1>Be warned</h1>
                                    <p>Don't give us wrong information!</p>
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

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        function showError(data) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data
            });
        }

        function showInfo(data) {
            Swal.fire({
                icon: 'info',
                title: 'Information received...',
                text: data
            });
        }
    </script>
</body>

</html>