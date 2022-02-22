<?php
session_start();
if (isset($_SESSION['Rank'])) {
    if ($_SESSION['Rank'] != 'ADMIN' || $_SESSION['Rank'] != 'MODERATOR') {
        echo "<h1>404 Error</h1>
            <h4>Page not found!</h4>";
        return;
    }
} else {
    echo "<h1>404 Error</h1>
            <h4>Page not found!</h4>";
    return;
}
include "Model/Database.php";
require 'PHPMailer-master/mail.php';
function getMail($userID)
{
    $db = new database();
    $query = "Select Mail from User where UserID = $userID";
    $res = mysqli_query($db->connect(), $query);
    if (mysqli_num_rows($res) > 0) {
        if ($row = mysqli_fetch_assoc($res)) {
            return $row['Mail'];
        }
    }
}
if (isset($_POST['task'])) {
    $db = new database();
    if ($_POST['task'] == "approve") {
        $url = "http://localhost/Travelling-Buddy/UserLogin/Login.php?";
        $userID = $_POST['userID'];
        $query = "Update User Set Rank = 'USER' where UserID = $userID";
        $db->updateTable($query);
        $receipient = getMail($userID);
        $subject = "Approve Confirmation";
        $message = '<h2>Welcome to Travelling Buddy!</h2><br><br>
                       You are now part of the community of travellers.Here you can plan a trip with fellow travellers according to your ease and choice.Enjoy!<br><br>
                       <a href = "' . $url . '">Get Started</a><br><br>
                       Sincerely,<br>
                       Travelling Buddy team
                       </p><br><br>                       
                       <small>If you are having trouble clicking on the link,copy and paste the link below in your browser</small>
                       <br><p>' . $url . '</p>';
    }
    //reject dile ki hoy?
    if ($_POST['task'] == "reject") {
        $userID = $_POST['userID'];
        $receipient = getMail($userID);
        $subject = "Rejected Account";
        $message = '<p>Hello there,<br><br>
                       Your account was not approved.Please provide valid informations.<br><br>
                       Sincerely,<br>
                       Travelling Buddy team
                       </p><br><br>';
        $query = "Delete from User where UserID = $userID";
        $db->updateTable($query);
    }
    if (sendMail($receipient, $subject, $message)) {
        echo "Email Sent!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.bootstrap.min.css">

</head>

<body>
    <div class="container mb-3 mt-3">
        <table class="table table-striped table-bordered" style="width: 100%" id="userTable">
            <thead>
                <th>UserID</th>
                <th>UserName</th>
                <th>Phone</th>
                <th>Mail</th>
                <th>Gender</th>
                <th>Rank</th>
                <th>IDFile</th>
                <th>Join Date</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                $db = new database();
                $query = "SELECT * from User";
                $res = mysqli_query($db->connect(), $query);
                if (mysqli_num_rows($res) > 0) {

                    while ($row = mysqli_fetch_array($res)) {
                        include "Model/user_row.php";
                    }
                }
                ?>
            </tbody>
        </table>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                // responsive: true
            });
            //new $.fn.dataTable.FixedHeader(table);
        });

        function Approve(userID) {
            alert(userID);
            $.ajax({
                type: 'post',
                data: {
                    task: "approve",
                    userID: userID
                }
            });
        }

        function Reject(userID) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    alert(userID);
                    $.ajax({
                        type: 'post',
                        data: {
                            task: "reject",
                            userID: userID
                        }
                    });
                    Swal.fire(

                        'Deleted!',
                        'Approve request has been rejected.',
                        'success'
                    )
                }
            })


        }
    </script>
</body>

</html>