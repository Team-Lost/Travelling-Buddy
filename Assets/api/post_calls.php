<?php
if (isset($_POST['task'])) {
    if ($_POST['task'] == 'join') {
        $postID = $_POST['postID'];
        $query = "INSERT INTO CHATS VALUES($postID, $currID)";
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
    if ($_POST['task'] == 'reportPost') {
        $postID = $_POST['postID'];
        $reason = $_POST['reason'];
        $details = $_POST['details'];
        $query = "INSERT INTO REPORTS(reportType, reportedID, reportedBy, reason, details) VALUES('POST', $postID, $currID, '$reason', '$details')";
        mysqli_query($conn, $query);
    }
    if ($_POST['task'] == 'joinPost') {
        $postID = $_POST['postID'];
        $todo = $_POST['todo'];
        $query = "INSERT INTO CHATS VALUES($postID, $currID, 'PENDING')";
        if ($todo == 'REMOVE') {
            $query = "DELETE FROM CHATS WHERE userID = $currID";
        }
        mysqli_query($conn, $query);
    }
}
if (isset($_POST['btn-comment'])) {
    $comment = $_POST['comment'];
    $query = "INSERT INTO COMMENTS(postID, userID, comment) VALUES($postID, $currID, '$comment')";
    mysqli_query($conn, $query);
}
?>