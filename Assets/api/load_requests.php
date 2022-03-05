<?php
session_start();
$currID = $_SESSION['UserID'];
$conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
$query = "SELECT user.UserName, user.UserID, chats.postID FROM chats" .
    " LEFT JOIN user ON user.UserID = chats.userID" .
    " WHERE status = 'PENDING' AND postID IN (SELECT postID FROM posts WHERE posterID = $currID)";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "<div class='d-flex flex-column mt-p-10-5 container-fitter'>";
    while ($row = mysqli_fetch_assoc($result)) {
        include "../../Model/pending_request.php";
    }
    echo "</div>";
}
mysqli_close($conn);