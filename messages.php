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

<body>
    <?php
    include "navbar_user.php"
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 sticky-pane">
                <div class="container-fitter container-fluid shadow" id="chat-heads">

                </div>
            </div>
        </div>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            loadChatHeads();
        });

        function loadChatHeads() {
            $.ajax({
                type: 'POST',
                url: "Assets/api/manage_chat.php",
                data: {
                    task: 'GET_LIST'
                },
                success: function(data) {
                    document.getElementById('chat-heads').innerHTML = data;
                }
            })
        }
    </script>
</body>

</html>