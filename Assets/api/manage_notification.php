<?php
session_start();

$currID = $_SESSION['UserID'];
$currName = $_SESSION['UserName'];
$conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
if (isset($_POST['task'])) {
    if ($_POST['task'] == 'COUNT') {
        $query = "SELECT COUNT(notificationID) as nCount FROM NOTIFICATIONS WHERE userID = $currID AND status = 0";
        $res = mysqli_query($conn, $query);
        $cnt = 0;
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $cnt = $row['nCount'];
        }
        echo $cnt;
    }
    if ($_POST['task'] == 'GET') {
        $limit = $_POST['limit'];
        $query = "SELECT * FROM NOTIFICATIONS WHERE userID = $currID ORDER BY timeCreated DESC";
        if ($limit == 'NEW') {
            $query .= " AND status = 0";
        }
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $makerName = getName($row['makerID']);
                $data = "<a class='text-decoration-none' href='user_profile.php?id=$row[makerID]'>$makerName</a>";
                if ($row['data'] == 'UPVOTE') {
                    $data .= " upvoted your";
                } else if ($row['data'] == 'DOWNVOTE') {
                    $data .= " downvoted your";
                } else if ($row['data'] == 'JOIN') {
                    $data .= " wants to join your";
                } else if ($row['data'] == 'ACCEPT') {
                    $data .= " accepted your request to join";
                } else if ($row['data'] == 'REJECT') {
                    $data .= " rejected your request to join";
                } else {
                    $data .= " commented on your";
                }
                $data .= " <a class='text-decoration-none' href='post.php?postID=$row[postID]'>post $row[postID].</a>";
                $timeElapsed = time_elapsed_string($row['timeCreated']);
                $imageURL = getPath($row['makerID']);
                include "../../Model/notification_view.php";
            }
        }
        $query = "UPDATE NOTIFICATIONS SET status = 1 WHERE userID = $currID AND status = 0";
        mysqli_query($conn, $query);
    }

    if ($_POST['task'] == 'MAKE') {

        $postID = $_POST['postID'];
        $userID = getCreatorID($postID);
        $data = $_POST['about'];
        if ($userID == $currID) {
            return;
        }
        if ($data == 'ACCEPT' || $data == 'REJECT') {
            $userID = $_POST['userID'];
        }
        $query = "INSERT INTO NOTIFICATIONS(userID, makerID, postID, data) VALUES($userID, $currID, $postID, '$data')";
        mysqli_query($conn, $query);
    }
}

//Utility Functions
function time_elapsed_string($tm)
{
    return $tm;
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
