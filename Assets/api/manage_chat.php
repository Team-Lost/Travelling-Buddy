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
        $query = "SELECT postID, data, senderID, MAX(sentTime) FROM MESSAGES WHERE postID IN ((SELECT postID FROM POSTS where posterID = $currID) UNION".
        " (SELECT postID FROM CHATS WHERE userID = $currID AND STATUS = 'IN')) ORDER BY messageID";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                echo json_encode($row);
            }
        }
    }
}
