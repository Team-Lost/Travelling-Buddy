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
    include "navbar_user.php";
    $linkID = $_GET['id'];
    if (strlen(trim($linkID)) == 0) {
        echo "<p>Invalid User ID</p>";
        die;
    }
    $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
    $query = "SELECT UserName, Mail, Phone, Gender, creationDate FROM USER WHERE UserID = $linkID";
    $result = mysqli_query($conn, $query);
    $user;
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "<p>NONE User ID</p>";
        die;
    }
    ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-5">


                <div class="container container-fitter mt-p-10-5">
                    <div class="row justify-content-md-center my-4">
                        <div class="col-4 px-3">
                            <img src="profile_picture.jpg" class="img-fluid thumbnail rounded-circle img-fixed">
                        </div>
                        <div class="col-8">
                            <p class="fw-bold h3 text-left"><?php echo $user['UserName'] ?></p>
                            <table class="table-clear">
                                <tr>
                                    <td class="image-center"><i class="fas fa-envelope"></i></td>
                                    <td><span style="font-weight: 500;" class="mx-2"><?php echo $user['Mail'] ?></span></td>
                                </tr>
                                <tr>
                                    <td class="image-center"><i class="fas fa-phone-alt"></i></td>
                                    <td><span style="font-weight: 500;" class="mx-2"><?php echo $user['Phone'] ?></span></td>
                                </tr>
                                <tr>
                                    <td class="image-center"><i class="fas fa-flag"></i></td>
                                    <td><span style="font-weight: 500;" class="mx-2"><?php echo $user['Gender'] ?></span></td>
                                </tr>
                                <tr>
                                    <td class="image-center"><i class="fab fa-github"></i></td>
                                    <td><span style="font-weight: 500;" class="mx-2"><?php echo $user['creationDate'] ?></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                $currID = $linkID;
                $query = "SELECT user.UserID, user.UserName, posts.postID, posts.location, posts.budget, posts.description, posts.startingTime, posts.endingTime, tempVotes.voteCount" .
                    " FROM user" .
                    " RIGHT JOIN posts ON user.UserID = posts.posterID" .
                    " LEFT JOIN (SELECT SUM(voteStatus) as voteCount, postID FROM votes GROUP BY(postID)) AS tempVotes ON posts.postID = tempVotes.postID" .
                    " WHERE user.userID = $currID";
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
</body>

</html>