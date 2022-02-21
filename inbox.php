<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.bootstrap.min.css">
    <style>
        .scroll-y {
            overflow-y: scroll;
        }

        .wrap-overflow {
            overflow: hidden;
        }

        .b-line-below {
            border: 1px solid gray;
        }
    </style>
</head>

<body>
    <?php include "navbar_user.php" ?>
    <div class="container-fluid">
        <div class="row justify-content-left">
            <div class="col-2 m-100 scroll-y">
                <?php
                $currID = $_SESSION['UserID'];
                $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
                $query = "SELECT postID FROM CHATS WHERE userID = $currID";
                $res = mysqli_query($conn, $query);
                if(mysqli_num_rows($res)) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        include "chat_box.php";
                    }
                }
                ?>
            </div>
            <div class="col-8">

            </div>
        </div>
    </div>
</body>

</html>