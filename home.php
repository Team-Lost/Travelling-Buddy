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
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-3 sticky-pane">
                <div class="container-fluid mt-p-10-5 container-fitter">
                    <form action="#" method="post" id="search_form">
                        <div class="form-group" id="input_fields">
                            <label for="keyword">Keyword:</label>
                            <input type="text" id="keyword" name="" class="form-control bottom-input">
                            <label for="minBudget">Minimum Budget:</label>
                            <input type="number" id="minBudget" name="" class="form-control bottom-input">
                            <label for="maxBudget">Maximum Budget:</label>
                            <input type="number" id="maxBudget" name="" class="form-control bottom-input">
                            <label for="location">Location:</label>
                            <input type="text" id="location" name="" class="form-control bottom-input">
                            <label for="startTime">Starts after:</label>
                            <input type="datetime-local" id="startTime" name="startTime" class="form-control">
                            <label for="endTime">Ends before:</label>
                            <input type="datetime-local" id="endTime" name="endTime" class="form-control">
                        </div>
                        <button type="button" id="filter" class="btn btn-primary form-control my-2" name="filter">Filter Posts</button>
                    </form>
                </div>
            </div>
            <div class="col-5" id="post-column">
                <?php
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

                ?>
            </div>
        </div>
    </div>
    <?php
    include "Assets/api/post_calls.php";
    ?>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="Assets/scripts/post_function.js"></script>
    <script>
        var btnFilter = document.getElementById("filter");
        btnFilter.addEventListener("click", reloadPosts)

        function reloadPosts() {
            var keyword = document.getElementById("keyword").value;
            var minBudget = document.getElementById("minBudget").value;
            var maxBudget = document.getElementById("maxBudget").value;
            var location = document.getElementById("location").value;
            var startTime = document.getElementById("startTime").value;
            var endTime = document.getElementById("endTime").value;

            keyword = '%' + keyword + '%';
            if (minBudget.trim().length == 0) {
                minBudget = 0;
            }
            if (maxBudget.trim().length == 0) {
                maxBudget = 9999999;
            }
            if (minBudget > maxBudget) {
                alert("Minimum budget can't be lower than maximum budget!");
            }
            location = '%' + location + '%';
            if (startTime > endTime) {
                alert("Can't start something after it ends!");
            }
            if (startTime.trim().length == 0) {
                startTime = "1000-01-01 00:00:00"
            }
            if (endTime.trim().length == 0) {
                endTime = "9999-12-31 11:59:59"
            }

            var extraQuery = "WHERE description LIKE '" + keyword + "' AND budget >= " + minBudget +
                " AND budget <= " + maxBudget + " AND location LIKE '" + location + "' AND startingTime >= '" +
                startTime.replace('T', ' ') + "' AND endingTime <= '" +
                endTime.replace('T', ' ') + "'";


            document.getElementById("post-column").innerHTML = "";
            $.ajax({
                type: 'POST',
                url: "Assets/api/load_posts.php",
                data: {
                    task: "UPDATE_POST",
                    extraQuery: extraQuery
                },
                success: function(data) {
                    document.getElementById("post-column").innerHTML = data;
                }
            });


        }
    </script>

</body>

</html>