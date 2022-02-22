<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location:UserLogin/Login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/cee0f4dddc.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="Assets/css/home.css" rel="stylesheet">
</head>

<body class="body-ssp-fb">
    <?php
    if (!isset($_GET['postID'])) {
        echo "<p class='text-center'>404 Not Found!</p>";
        return;
    }
    include "navbar_user.php";
    $postID = $_GET['postID'];
    $currID = $_SESSION['UserID'];
    $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
    $query = "SELECT user.UserID, user.UserName, posts.postID, posts.location, posts.budget, posts.description, posts.startingTime, posts.endingTime, tempVotes.voteCount" .
        " FROM user" .
        " RIGHT JOIN posts ON user.UserID = posts.posterID" .
        " LEFT JOIN (SELECT SUM(voteStatus) as voteCount, postID FROM votes GROUP BY(postID)) AS tempVotes ON posts.postID = tempVotes.postID" .
        " WHERE posts.postID = $postID";
    $res = mysqli_query($conn, $query);
    if (mysqli_num_rows($res) > 0) {
        if ($userPost = mysqli_fetch_assoc($res)) {
            $voteStatus = 0;
            $voteQuery = "SELECT * FROM `votes` WHERE postID = " . $userPost['postID'] . " AND voterID = $currID";
            $upvoteIconClass = $downvoteIconClass = "";
            $res = mysqli_query($conn, $voteQuery);
            if (mysqli_num_rows($res) > 0) {
                while ($currRow = mysqli_fetch_assoc($res)) {
                    $voteStatus = $currRow['voteStatus'];
                }
            }

            if ($voteStatus == -1) {
                $upvoteIconClass = "fa-regular fa-thumbs-up fa-xl";
                $downvoteIconClass = "fa-solid fa-thumbs-down fa-xl";
            } else if ($voteStatus == 0) {
                $upvoteIconClass = "fa-regular fa-thumbs-up fa-xl";
                $downvoteIconClass = "fa-regular fa-thumbs-down fa-xl";
            } else {
                $upvoteIconClass = "fa-solid fa-thumbs-up fa-xl";
                $downvoteIconClass = "fa-regular fa-thumbs-down fa-xl";
            }
            if (is_null($userPost['voteCount'])) {
                $userPost['voteCount'] = 0;
            }

            include "Model/post_view.php";
        }
    }
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
    <div class="container mt-p-10-5 container-fitter">
        <form action="#" method="post" id="inp_form">
            <textarea id="comment" placeholder="Write your comment here..." name="comment" class="form-control bottom-input margin-1-2" rows="3"></textarea>
            <button type="submit" name="btn-comment" id="btn-comment" class="btn btn-info btn-h40 form-control margin-1-2">Comment</button>
        </form>
    </div>

    <div id="div-comment" class="container-fluid mt-p-10-5 bg-inherit">
        <?php
        $query = "SELECT user.UserName, comments.commentID, comments.postID, comments.userID, comments.comment, comments.time, comments.replyID
            FROM comments
            JOIN user
            ON comments.userID = user.UserID
            WHERE comments.postID = $postID";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                include "Model/comment_view.php";
            }
        }

        ?>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script>
        $('button').click(function() {
            var curr = $(this),
                postID = curr.attr('post-id'),
                btnID = curr.attr('id');
            if (btnID.toString() == 'btn-join') {
                $.ajax({
                    type: 'post',
                    data: {
                        ajax: 1,
                        task: 'join',
                        postID: postID,
                    }
                });
            }
            if (btnID.toString() == 'btn-upvote' || btnID.toString() == 'btn-downvote') {
                var curr = $(this);
                var name = curr.attr('id').split('-')[1];
                var iconUpvote = document.getElementById('upvote-' + postID);
                var iconDownvote = document.getElementById('downvote-' + postID);
                var vote = iconUpvote.getAttribute('vote');
                var change = 0;
                if (name.toString() == 'upvote') {
                    if (vote == 1) {
                        vote = 0;
                        change = -1;
                    } else if (vote == -1) {
                        vote = 1;
                        change = 2;
                    } else {
                        vote = 1;
                        change = 1;
                    }
                } else {
                    if (vote == -1) {
                        vote = 0;
                        change = 1;
                    } else if (vote == 1) {
                        vote = -1;
                        change = -2;
                    } else {
                        vote = -1;
                        change = -1;
                    }
                }
                iconUpvote.setAttribute("vote", vote);
                iconDownvote.setAttribute("vote", vote);
                if (vote == -1) {
                    iconUpvote.setAttribute("class", "fa-regular fa-thumbs-up fa-xl");
                    iconDownvote.setAttribute("class", "fa-solid fa-thumbs-down fa-xl");
                } else if (vote == 0) {
                    iconUpvote.setAttribute("class", "fa-regular fa-thumbs-up fa-xl");
                    iconDownvote.setAttribute("class", "fa-regular fa-thumbs-down fa-xl");
                } else {
                    iconUpvote.setAttribute("class", "fa-solid fa-thumbs-up fa-xl");
                    iconDownvote.setAttribute("class", "fa-regular fa-thumbs-down fa-xl");
                }
                var counter = document.getElementById('count-' + postID);
                var currCount = parseInt(counter.innerText) + change;
                counter.innerText = currCount;
                $.ajax({
                    type: 'post',
                    data: {
                        ajax: 1,
                        task: 'updateVote',
                        postID: postID,
                        vote: vote
                    }
                });
            }
        });
    </script>

</body>

</html>