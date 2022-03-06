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
            <div class="col-5">
                <div class="container container-fitter mt-p-10-5">
                    <div class="row justify-content-md-center my-4">
                        <div class="col-4 px-3 btn-parent">
                            <img src="<?php echo getPath($linkID) ?>" class="img-fluid thumbnail rounded-circle" style="width:auto, height:auto">
                            <?php
                            if ($linkID == $_SESSION['UserID']) {
                                echo '<button type="button" class="btn btn-secondary btn-img" onclick="document.getElementById("file").click()">Change Photo</button>';
                                echo '<input type="file" name="file" id="file" accept="image/png,image/jpeg,image/jpg" onchange="uploadImage()" style="display:none">';
                            }
                            ?>
                        </div>
                        <div class="col-8">
                            <p class="fw-bold h3 text-left"><?php echo $user['UserName'] ?><span>
                                    <?php if ($linkID != $_SESSION['UserID']) {
                                        include "Model/report_button_user.php";
                                    }
                                    ?></span></p>
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
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="Assets/scripts/post_function.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function uploadImage() {
            var files = document.getElementById("file").files;

            if (files.length > 0) {

                var formData = new FormData();
                formData.append("file", files[0]);
                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "image_uploader.php", true);
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = this.responseText;
                        if (response == 1) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Uploaded!',
                                text: 'Picture uploaded successfully!'
                            });
                        } else {
                            showError("Error encountered during upload!");
                        }
                    }
                };
                xhttp.send(formData);
            } else {
                showError("Please select a file");
            }
        }

        function reportID(userID) {
            var selectOpt = document.getElementById("select" + userID);
            var selectedOpt = selectOpt.options[selectOpt.selectedIndex].text;
            var detailsOpt = document.getElementById("details" + userID);
            $.ajax({
                type: 'post',
                url: "Assets/api/make_user_reports.php",
                data: {
                    task: 'REPORT_ID',
                    userID: userID,
                    reason: selectedOpt,
                    details: detailsOpt.value
                }
            });
            $("[data-bs-dismiss=modal]").trigger({
                type: "click"
            });
        }

        function showError(errorText) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorText
            })
        }
    </script>

</body>

</html>