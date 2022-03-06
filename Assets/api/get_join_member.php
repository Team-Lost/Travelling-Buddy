<?php
session_start();
$currID = $_SESSION['UserID'];
$postID = $_POST['postID'];
$conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
$check = "SELECT COUNT(UserID) as cntValid FROM user where UserID = $currID AND UserID IN ((SELECT posterID FROM posts WHERE postID = $postID) UNION (SELECT userID FROM chats WHERE postID = $postID AND status = 'IN'))";
$res = mysqli_query($conn, $check);
$data = mysqli_fetch_assoc($res);
if($data['cntValid'] == '0') {
    echo 'INVALID';
    return;
}

$query = "SELECT user.UserID, user.UserName, user.Mail, user.Phone, chats.status, chats.postID" .
    " FROM user" .
    " INNER JOIN chats ON user.userID = chats.userID" .
    " WHERE chats.status='IN' AND chats.postID = $postID";

$res = mysqli_query($conn, $query);
if (mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_assoc($res)) {
        $imgPath = getPath($row['UserID']);
        include "../../Model/joined_user_box.php";
    }
}

function getPath($UserID)
{
    $path = "profile_picture.png";
    if (file_exists("../../ProfilePictures/$UserID/")) {
        $files = scandir("../../ProfilePictures/$UserID/", 1);
        if (sizeof($files) > 2) {
            $path = "ProfilePictures/$UserID/$files[0]";
        }
    }
    return $path;
}
