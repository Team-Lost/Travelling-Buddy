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
function getName($id)
{
    $db = new database();
    $query = "Select UserName from User where UserID = $id";
    $res = mysqli_query($db->connect(), $query);
    if (mysqli_num_rows($res) > 0) {
        if ($row = mysqli_fetch_assoc($res)) {
            return $row['UserName'];
        }
    }
}
if (isset($_POST['task'])) {
    $db = new database();
    //if no actions are required,just inform the reported id that no problems were found
    if ($_POST['task'] == "dismiss") {       
            $reportID = $_POST['reportID'];
            $reportedBy = $_POST[ 'reportedBy'];           
            $query = "Update Reports Set Status = 'RESOLVED' where reportID = $reportID";
            $db->updateTable($query);
            $response = 1;
            //get the mail of the person who reported the id
            $receipient = getMail($reportedBy);                  
            //get the name of the person whose id was reported
            $name = getName($reportedID);          
            if ($_POST['reportType'] == "POST") {
                $subject = "Regarding the Post you have reported";
            } else {
                $subject = "Regarding the Profile you have reported";
            }
            $message = 'We have reviewed your report about {$name}\'s\ post and have decided it doesn\'t\ go against our standards.<br>
                        Thank you for reporting  and helping us make a better platform for everyone. 
                        <br><br>
                        Sincerely,<br>
                        Travelling Buddy team
                        </p><br><br>';
     
    }
    if ($_POST['task'] == "ban")
    {
        $reportID = $_POST['reportID'];
        $reportedID = $_POST['reportedID'];
        $reportedBy = $_POST[ 'reportedBy'];
        //if post
        if($_POST['reportedType'] == "POST")
        {
            $query = "Delete from POSTS where postID = $reportedID";
        }
        $query = "Update Reports Set Status = 'RESOLVED' where reportID = $reportID";
        $db->updateTable($query);
              
    }     
    if (sendMail($receipient, $subject, $message)) {
        
    }
}
