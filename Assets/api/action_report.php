<?php
include "../../Model/Database.php";
require '../../PHPMailer-master/mail.php';
$response;
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
            $reportedBy = $_POST['reportedBy'];           
            $query = "Update Reports Set Status = 'RESOLVED' where reportID = $reportID";
            $db->updateTable($query);
            $response['query'] = $query;
            //get the mail of the person who reported the id
            $receipient = getMail($reportedBy);
            $response['$receipient'] = $receipient;                
            //get the name of the person whose id was reported
            $name = getName($_POST['reportedID']);
            $response['name'] = $name;          
            if ($_POST['reportType'] == "POST") {
                $subject = "Regarding the ost you have reported";
                $message = "We have reviewed your report about $name's post and have decided it doesn't go against our standards.<br>
                Thank you for reporting  and helping us make a better platform for everyone. 
                <br><br>
                Sincerely,<br>
                Travelling Buddy team
                </p><br><br>";
            } else {
                $subject = "Regarding the Profile you have reported";
                $message = "We have reviewed your report about $name's profile and have decided it doesn't go against our standards.<br>
                Thank you for reporting  and helping us make a better platform for everyone. 
                <br><br>
                Sincerely,<br>
                Travelling Buddy team
                </p><br><br>";
            }
           
            sendMail($receipient, $subject, $message);//send mail to the user who reported the id
    }
    if ($_POST['task'] == "ban")
    {
        $reportID = $_POST['reportID'];
        $reportedID = $_POST['reportedID'];
        $reportedBy = $_POST[ 'reportedBy'];
        //if post
        if($_POST['reportType'] == "POST")
        {
            $query = "Delete from POSTS where postID = $reportedID";
            $db->updateTable($query);
            $response = 1;
            $query = "Delete from notifications where postID = $reportedID";
            $db->updateTable($query);
            //thank the user who reported the post
            $receipient = getMail($reportedBy);//reported by user's mail
            $name = getName($_POST['reportedID']);//reported user's name
            $subject = "Regarding the post you have reported";
            $message = "We have reviewed your report about $name's post and have decided it goes against our standards and hence deleted the post.<br>
                        Thank you for reporting  and helping us make a better platform for everyone. 
                        <br><br>
                        Sincerely,<br>
                        Travelling Buddy team
                        </p><br><br>"; 
            sendMail($receipient, $subject, $message);//send mail to the user who reported the id
            
            //notify the user whose post has been deleted
            $receipient = getMail($reportedID);//reported user's mail
            $subject = "Regarding your post being deleted";
            $message = "The post you have made goes against our standards and hence we deleted the post.<br>
                        Please be careful next time. 
                        <br><br>
                        Sincerely,<br>
                        Travelling Buddy team
                        </p><br><br>"; 
            sendMail($receipient, $subject, $message);//send mail to the user who reported the id
        }
        else
        {
            $query = "UPDATE USER SET rank = 'BANNED' WHERE UserID = $reportedID";
            $db->updateTable($query);
            $response = 1;
             //thank the user who reported the profile
            $receipient = getMail($reportedBy);//reported by user's mail
            $name = getName($reportedID);//reported user's name
            $subject = "Regarding the profile you have reported";
            $message = "We have reviewed your report about $name's profile and have decided it goes against our standards and hence took appropriate actions.<br>
                         Thank you for reporting  and helping us make a better platform for everyone. 
                         <br><br>
                         Sincerely,<br>
                         Travelling Buddy team
                         </p><br><br>"; 
            sendMail($receipient, $subject, $message);//send mail to the user who reported the id

             //notify the user whose profile has been banned
             $receipient = getMail($reportedID);//reported user's mail
             $subject = "Regarding your profile being banned";
             $message = "We have noticed activities from your profile that goes against our standards and hence you have been banned.<br>
                         You can't log int your account unless our team removes the ban.If you have any query,you can contact us.  
                         <br><br>
                         Sincerely,<br>
                         Travelling Buddy team
                         </p><br><br>"; 
             sendMail($receipient, $subject, $message);//send mail to the user whose id has been reported
             
        }
       
          
    }     
  

}
