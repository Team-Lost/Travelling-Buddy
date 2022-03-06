<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location:UserLogin/Login.php");
}
include "ban_check.php";

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
    function getPath($UserID)
    {
        $path = "profile_picture.png";
        if (file_exists("ProfilePictures/$UserID/")) {
            $files = scandir("ProfilePictures/$UserID/", 1);
            if (sizeof($files) > 2) {
                $path = "ProfilePictures/$UserID/$files[0]";
            }
        }
        return $path;
    }
    ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-3"></div>
            <div class="col-6">
                <?php
                $postID = $_GET['postID'];
                $currID = $_SESSION['UserID'];
                $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
                $query = "SELECT user.UserID, user.UserName, posts.posterID, posts.postID, posts.location, posts.budget, posts.description, posts.startingTime, posts.endingTime, tempVotes.voteCount" .
                    " FROM user" .
                    " RIGHT JOIN posts ON user.UserID = posts.posterID" .
                    " LEFT JOIN (SELECT SUM(voteStatus) as voteCount, postID FROM votes GROUP BY(postID)) AS tempVotes ON posts.postID = tempVotes.postID" .
                    " WHERE posts.postID = $postID";
                $res = mysqli_query($conn, $query);
                if (mysqli_num_rows($res) > 0) {
                    if ($userPost = mysqli_fetch_assoc($res)) {
                        include "Model/post_view.php";
                    }
                }
                include "Assets/api/post_calls.php";

                ?>
                <div class="container mt-p-10-5 container-fitter">
                    <form action="#" method="post" id="inp_form">
                        <textarea id="comment" placeholder="Write your comment here..." name="comment" class="form-control bottom-input margin-1-2" rows="3"></textarea>
                        <button type="submit" name="btn-comment" id="btn-comment" class="btn btn-info btn-h40 form-control margin-1-2">Comment</button>
                    </form>
                </div>

                <div id="div-comment" class="container-fluid p-0">
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
            </div>
            <div class="col-3">
                <div class="container-fitter mt-p-10-5 container-fluid shadow">
                    <p class="text-center fw-bold">Joined Travellers<br>
                        <span class="text-danger" id="span-no-perm" style="display: none;">You don't have permission to Traveller list</span>
                    </p>
                </div>
                <div class="container-fitter mt-p-10-5 container-fluid shadow" id="joined-members">

                </div>
            </div>
        </div>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
        </script>
        <script src="Assets/scripts/post_function.js"></script>
        <script>
            $(document).ready(function() {
                loadMembers();
            });

            function loadMembers() {
                let params = new URLSearchParams(location.search);
                $.ajax({
                    type: 'post',
                    url: "Assets/api/get_join_member.php",
                    data: {
                        postID: params.get('postID')
                    },
                    success: function(data) {
                        if (data == 'INVALID') {
                            document.getElementById("span-no-perm").setAttribute("style", "display: block;");
                        } else {
                            document.getElementById("joined-members").innerHTML = data;
                        }
                    }
                });
            }
        </script>

</body>

</html>