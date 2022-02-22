<?php
if (isset($_POST['ajax'])) {
    echo "$here";
    if ($_POST['task'] == 'join') {
        $postID = $_POST['postID'];
        $query = "INSERT INTO CHATS VALUES($postID, $currID)";
        echo $query;
        mysqli_query($conn, $query);
    }
    if ($_POST['task'] == 'updateVote') {
        $postID = $_POST['postID'];
        $vote = $_POST['vote'];
        $query = "";
        $query = "DELETE FROM VOTES WHERE postID = $postID AND voterID = $currID";
        mysqli_query($conn, $query);
        if ($vote != 0) {
            $query = "INSERT INTO VOTES VALUES($postID, $currID, $vote)";
            mysqli_query($conn, $query);
        }
    }
}
if (isset($_POST['btn-comment'])) {
    $comment = $_POST['comment'];
    $query = "INSERT INTO COMMENTS(postID, userID, comment) VALUES($postID, $currID, '$comment')";
    mysqli_query($conn, $query);
}
?>