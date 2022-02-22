<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location:UserLogin/Login.php");
}
?>

<html>

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
    include "navbar_user.php";
    $currID = $_SESSION['UserID'];
    $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
    $query = "SELECT user.UserID, user.UserName, posts.postID, posts.location, posts.budget, posts.description, posts.startingTime, posts.endingTime, tempVotes.voteCount" .
        " FROM user" .
        " RIGHT JOIN posts ON user.UserID = posts.posterID" .
        " LEFT JOIN (SELECT SUM(voteStatus) as voteCount, postID FROM votes GROUP BY(postID)) AS tempVotes ON posts.postID = tempVotes.postID";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($userPost = mysqli_fetch_assoc($result)) {
            include "Model/post_view.php";
        }
    }
    include "Assets/api/post_calls.php";
    ?>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="Assets/scripts/post_function.js"></script>

</body>

</html>