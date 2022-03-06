<?php
require "../../Model/Database.php";
require '../../PHPMailer-master/mail.php';
$response;
if (isset($_POST['task'])) {
    $db = new Database();    
    if ($_POST['task'] == "unban") {
        $id = $_POST['userID'];
        $receipient = $_POST['userMail'];     
        $query = "Update User Set Rank = 'USER' where UserID = $id";
        $db->updateTable($query);
        $response['query'] = $query;
        $response['$receipient'] = $receipient;
        $message = "Your ban has been removed.You can now log back into your account.Kindly be careful of our rules and regulations from next time!
        <br><br>
        Sincerely,<br>
        Travelling Buddy team
        </p><br><br>";
        $response['$message'] = $message;
        sendMail($receipient, 'Regarding removing your ban!', $message);
        echo json_encode($response);
    }
}
