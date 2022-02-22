<?php
session_start();
if (isset($_SESSION['Rank'])) {
    if (!($_SESSION['Rank'] == trim('ADMIN') || $_SESSION['Rank'] == 'MODERATOR')) {
        echo "<h1>404 Error </h1>
            <h4>Page not found1!</h4>";
        return;
    }
} else {
    echo "<h1>404 Error</h1>
            <h4>Page not found2!</h4>";
    return;
}
include "Model/Database.php";
require 'PHPMailer-master/mail.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">   

</head>

<body>
    <?php include "navbar_user.php" ?>    
    <div class="container-fluid justify-content-center">
        <table class="table table-striped table-bordered" id="userTable">
            <thead>
                <th>UserID</th>
                <th>UserName</th>
                <th>Phone</th>
                <th>Mail</th>
                <th>Gender</th>
                <th>Rank</th>
                <th>IDFile</th>
                <th>Join Date</th>               
            </thead>
            <tbody>
                <?php
                $db = new database();
                $query = "SELECT * from User";
                $res = mysqli_query($db->connect(), $query);
                if (mysqli_num_rows($res) > 0) {

                    while ($row = mysqli_fetch_array($res)) {
                        include "Model/userlist_row.php";
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
 
   

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                // responsive: true
            });
            //new $.fn.dataTable.FixedHeader(table);
        });

    </script>

</body>

</html>