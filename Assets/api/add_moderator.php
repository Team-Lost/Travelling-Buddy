<?php
require "../../Model/Database.php";
require '../../PHPMailer-master/mail.php';
$response;
if (isset($_POST['task'])) {
    $db = new Database();    
    if ($_POST['task'] == "make") {
        $id = $_POST['userID'];
        $receipient = $_POST['userMail'];     
        $query = "Update User Set Rank = 'MODERATOR' where UserID = $id";
        $db->updateTable($query);
        $response['query'] = $query;
        $response['$receipient'] = $receipient;
        $message = "You have been accepted as a moderator.Hope you will have a great time with us!
        <br><br>
        Sincerely,<br>
        Travelling Buddy team
        </p><br><br>";
        $response['$message'] = $message;
        sendMail($receipient, 'Regarding your rank!', $message);
        echo json_encode($response);
    }
}
