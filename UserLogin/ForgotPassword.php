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
    $expires = time() + 1800;//1 day
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
    echo $query;
    $db->updateTable($query);
    $token = password_hash($token, PASSWORD_DEFAULT);
    $query = "Insert into passwordReset(ResetMail,ResetSelector,ResetToken,ResetExpire) values ('$checkMail','$selector','$token','$expires')";
    //echo $query;
    $db->updateTable($query);    
    $receipient = $checkMail;
    $subject = "Reset password instructions";    
    date_default_timezone_set(date_default_timezone_get());
    $date = date('m/d/Y h:i:s a', time());
    if(!$userExists)
    {
        $message = '<p>Hello there,<br><br>
                       The user account for this email was not found.Try a different email address.<br><br>
                       Sincerely,<br>
                       Travelling Buddy team
                       </p><br><br>'; 
        echo $message;
    }   
    else
    {       
        $message = '<p>Hello there,<br>
                       <br>Someone(hopefully you) have requested to change your Travelling Buddy password.<br>
                       Please click the link below to change your password now.<br>
                       <br><a href = "'.$url.'">Reset my password</a><br>
                       <br>This link will expire in 1 day.If you have sent multiple requests,click on the link of most recent mail<br>
                       If you did not make the request,please disregard this email.<br>
                       <br>Sincerely,<br>
                       Travelling Buddy team
                       </p><br><br><br>
                       <small>If you are having trouble clicking on the link,copy and paste the link below in your browser</small>
                       <br><p>'.$url.'</p>';        
   }    
    //sendMail($receipient, $subject, $message);
    if(sendMail($receipient, $subject, $message))
    {
       $sent = "Email sent!check both your inbox and spams";
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
    <h2>Reset Your Password</h2>
    <p>An email will be send to you with instructions on how to reset your password</p>
    <form method="POST">
        <div>
            <input type="email" name="resetMail" placeholder="mail">
            <span class="error">* <?php echo $mailError; ?></span>
        </div>
        <input type=submit value="Receive New Password By Mail" name="submit"></submit>
    </form>
    <div>
        <?php echo $sent; ?>
    </div>
</body>

</html>