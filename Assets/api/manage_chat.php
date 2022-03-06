<?php
session_start();
$currID = $_SESSION['UserID'];
$currName = $_SESSION['UserName'];
$conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
if (isset($_POST['task'])) {
    if ($_POST['task'] == 'COUNT') {
        $query = "SELECT COUNT(messageID) as nCount FROM MESSAGES WHERE userID = $currID AND status = 0";
        $res = mysqli_query($conn, $query);
        $cnt = 0;
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $cnt = $row['nCount'];
        }
        echo $cnt;
    }
    if ($_POST['task'] == 'GET_LIST') {
        $query = "SELECT postID, data, senderID, MAX(sentTime) as lastTime FROM MESSAGES WHERE postID IN ((SELECT postID FROM POSTS where posterID = $currID) UNION" .
            " (SELECT postID FROM CHATS WHERE userID = $currID AND STATUS = 'IN')) ORDER BY messageID";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $name = getName($row['senderID']);
                $data = $row['data'];
                $postID = $row['postID'];
                $timeElapsed = time_elapsed_string($row['lastTime']);
                include "../../Model/chat_box.php";
            }
        }
    }
}

//Utility
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
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

function getName($UserID)
{
    $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
    $query = "SELECT UserName FROM USER WHERE UserID = $UserID";
    $res = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($res)['UserName'];
}

function getCreatorID($postID)
{
    $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
    $query = "SELECT posterID FROM POSTS WHERE postID = $postID";
    $res = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($res)['posterID'];
}
