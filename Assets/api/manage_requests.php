<?php
$response = 0;
if(isset($_POST['task'])) {
    $userID = $_POST['userID'];
    $postID = $_POST['postID'];
    $query = "";
    if($_POST['task'] == "ACCEPT") {
        $query = "UPDATE CHATS SET status = 'IN' WHERE postID = $postID AND userID = $userID";
    } else {
        $query = "DELETE FROM CHATS WHERE postID = $postID AND userID = $userID";
    }
    $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
    mysqli_query($conn, $query);
    $response = 1;
}
mysqli_close($conn);
echo $response;