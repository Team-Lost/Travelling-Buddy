<?php
$data;
session_start();
if (!isset($_POST['id'])) {
    $data['status'] = 0;
    $data['response'] = "404<br>NOT FOUND";
} else {
    $editPostID = $_POST['id'];
    $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
    $query = "SELECT * FROM POSTS WHERE postID = $editPostID";
    $result = mysqli_query($conn, $query);
    $row;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
    if ($_SESSION['UserID'] != $row['posterID']) {
        $data['status'] = 0;
        $data['response'] = "ACCESS DENIED!";
    } else {
        $data['status'] = 1;
        $data['location'] = $row['location'];
        $data['budget'] = $row['budget'];
        $data['description'] = $row['description'];
        $data['startingTime'] = $row['startingTime'];
        $data['endingTime'] = $row['endingTime'];
    }
}
echo json_encode($data);
?>