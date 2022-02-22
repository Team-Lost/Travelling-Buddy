<?php
include "../Model/Database.php";
require '../PHPMailer-master/mail.php';
$mailError = $sent = "";
if (isset($_POST['submit'])) {
    if (!filter_var($_POST['resetMail'], FILTER_VALIDATE_EMAIL) || empty($_POST['resetMail']) || !preg_match('/^([a-zA-Z\d\.-]+)@([a-zA-Z\d-]+)\.([a-zA-Z]{2,3})(\.[a-zA-Z]{2,3})?$/', $_POST['resetMail'])) {
        $mailError = "Please enter a valid email";
        return;
    }
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    //  $expires = date("U")+ 1800;
    $expires = time() + 1800; //1 day
    $url = "http://localhost/Travelling-Buddy/UserLogin/ResetPassword.php?selector=" . $selector . "&validator=" . bin2hex($token);
    //echo $url;
    $userExists = false;
    $checkMail = $_POST['resetMail'];
    $query = "Select count(Mail) from User where Mail = '$checkMail'";
    $db = new database();
    $check = 0;
    $res = mysqli_query($db->connect(), $query);
    if (mysqli_num_rows($res) > 0) {
        if ($row = mysqli_fetch_assoc($res)) {
            $check = $row['count(Mail)'];
        }
    }
    if ($check == 1) {
        $userExists = true;
    }
    //i think we can just update here
    $query = "Delete from passwordReset where ResetMail = '$checkMail'";
    //echo $query;
    $db->updateTable($query);
    $token = password_hash($token, PASSWORD_DEFAULT);
    $query = "Insert into passwordReset(ResetMail,ResetSelector,ResetToken,ResetExpire) values ('$checkMail','$selector','$token','$expires')";
    //echo $query;
    $db->updateTable($query);
    $receipient = $checkMail;
    $subject = "Reset password instructions";
    date_default_timezone_set(date_default_timezone_get());
    $date = date('m/d/Y h:i:s a', time());
    if (!$userExists) {
        $message = "<p class='text-center'>Hello there,<br><br>
                       The user account for this email was not found.Try a different email address.<br><br>
                       Sincerely,<br>
                       Travelling Buddy team
                       </p><br><br>";
        //echo $message;
    } else {
        $message = '<p>Hello there,<br>
                       <br>Someone(hopefully you) have requested to change your Travelling Buddy password.<br>
                       Please click the link below to change your password now.<br>
                       <br><a href = "' . $url . '">Reset my password</a><br>
                       <br>This link will expire in 1 day.If you have sent multiple requests,click on the link of most recent mail<br>
                       If you did not make the request,please disregard this email.<br>
                       <br>Sincerely,<br>
                       Travelling Buddy team
                       </p><br><br><br>
                       <small>If you are having trouble clicking on the link,copy and paste the link below in your browser</small>
                       <br><p>' . $url . '</p>';
    }
    //sendMail($receipient, $subject, $message);
    if (sendMail($receipient, $subject, $message)) {
        $sent = "Email sent! Check both your inbox and spams";
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
    <link rel="stylesheet" href="..\Assets\css\home.css">

</head>

<body class="body-ssp-fb">
    <div class="container container-fitter mt-p-10-5">
        <h2 class="text-center">Reset Your Password</h2>
        <p class="text-center">An email will be send to you with instructions on how to reset your password</p>
        <form method="POST">
            <div class="form-group justify-content-center text-center">
                <input class="form-control" type="email" name="resetMail" placeholder="mail">
                <p class="text-center error"> <?php echo $mailError; ?></p>
                <input class="btn btn-info form-control w-50" type=submit value="Receive New Password By Mail" name="submit"></submit>
                <p class="text-center"> <?php echo $sent; ?></p>
            </div>
        </form>
        <div>
            <?php echo $sent; ?>
        </div>
    </div>
    
</body>

</html>