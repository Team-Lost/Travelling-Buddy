<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location:UserLogin/Login.php");
}
$currID = $_SESSION['UserID'];
$extraQuery = $_POST['extraQuery'];
$conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
$query = "SELECT user.UserID, user.UserName, posts.postID, posts.location, posts.budget, posts.description, posts.startingTime, posts.endingTime, tempVotes.voteCount" .
    " FROM user" .
    " RIGHT JOIN posts ON user.UserID = posts.posterID" .
    " LEFT JOIN (SELECT SUM(voteStatus) as voteCount, postID FROM votes GROUP BY(postID)) AS tempVotes ON posts.postID = tempVotes.postID" .
    " $extraQuery";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    while ($userPost = mysqli_fetch_assoc($result)) {
        include "../../Model/post_view.php";
    }
}

?>