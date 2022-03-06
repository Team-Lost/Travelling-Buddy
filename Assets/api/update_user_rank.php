<?php
    include "../../Model/Database.php";
    require '../../PHPMailer-master/mail.php';
    $response = 0;
    function getMail($id)
{
    $db = new database();
    $query = "Select Mail from User where UserID = $id";
    $res = mysqli_query($db->connect(), $query);
    if (mysqli_num_rows($res) > 0) {
        if ($row = mysqli_fetch_assoc($res)) {
            return $row['Mail'];
        }
    }
}
    if (isset($_POST['task'])) {
        $db = new database();
        if ($_POST['task'] == "approve") {
            $url = "http://localhost/Travelling-Buddy/UserLogin/Login.php?";
            $userID = $_POST['userID'];
            $query = "Update User Set Rank = 'USER' where UserID = $userID";
            $db->updateTable($query);
            $response = 1;
            $receipient = getMail($userID);
            $subject = "Approve Confirmation";
            $message = '<h2>Welcome to Travelling Buddy!</h2><br><br>
                           You are now part of the community of travellers.Here you can plan a trip with fellow travellers according to your ease and choice.Enjoy!<br><br>
                           <a href = "' . $url . '">Get Started</a><br><br>
                           Sincerely,<br>
                           Travelling Buddy team
                           </p><br><br>                       
                           <small>If you are having trouble clicking on the link,copy and paste the link below in your browser</small>
                           <br><p>' . $url . '</p>';
        }
   
        if ($_POST['task'] == "reject") {
            $userID = $_POST['userID'];
            $receipient = getMail($userID);
            $subject = "Rejected Account";
            $message = '<p>Hello there,<br><br>
                           Your account was not approved.Please provide valid informations.<br><br>
                           Sincerely,<br>
                           Travelling Buddy team
                           </p><br><br>';
            $query = "Delete from User where UserID = $userID";
            $db->updateTable($query);
            $response = 1;
        }
        if (sendMail($receipient, $subject, $message)) {           
           
        }
    }
    echo $response;
    ?>
