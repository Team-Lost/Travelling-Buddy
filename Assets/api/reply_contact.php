<?php
require "../../Model/Database.php";
require '../../PHPMailer-master/mail.php';
$response;
if (isset($_POST['task'])) {
    $db = new Database();    
    if ($_POST['task'] == "reply") {
        $contactID = $_POST['contactID'];
        $receipient = $_POST['contactMail'];
        $query = "Update Contact Set contactStatus = 'REPLIED' where contactID = $contactID";
        $db->updateTable($query);
        $response['query'] = $query;
        $response['$receipient'] = $receipient;
        $message = $_POST['contactReply'];
        $response['$message'] = $message;
        sendMail($receipient, 'Regarding about your contact with us!', $message);
        echo json_encode($response);
    }
}
