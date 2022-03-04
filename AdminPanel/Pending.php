<?php
session_start();
if (isset($_SESSION['Rank'])) {
    if (!($_SESSION['Rank'] == 'ADMIN' || $_SESSION['Rank'] == 'MODERATOR')) {
        echo "<h1>404 Error </h1>
            <h4>Page not found1!</h4>";
        return;
    }
} else {
    echo "<h1>404 Error</h1>
            <h4>Page not found2!</h4>";
    return;
}
include "../Model/Database.php";
require '../PHPMailer-master/mail.php';
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
        //echo "Email Sent!";
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
    <!--Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!--Font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--Datatable-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Assets/css/dataTable.css">

    <!--Custom CSS-->
    <link rel="stylesheet" href="../Assets/css/adminDeclaration.css">
    <link rel="stylesheet" href="../Assets/css/adminLayout.css">
    <link rel="stylesheet" href="../Assets/css/adminStyle.css">
    <link rel="stylesheet" href="../Assets/css/adminResponsive.css">

   


</head>

<body>
    <div class="main-wrapper">
        <!---navbar start-->
        <div class="header-container fixed-top">
            <header class="header  navbar navbar-expand-sm expand-header">
                <div class="header-left d-flex">
                    <div class="logo">
                         Travelling Buddy
                    </div>
                    <a href="#" class="sidebarCollapse" data-placement="bottom" id="toogleSidebar">
                        <span class="fas fa-bars"></span>
                    </a>
                </div>
                <ul class="navbar-item flex-row ml-auto">

                    <li class="nav-item dropdown user-profile-dropdown">
                        <a href="" class="nav-link user" id="Notify" data-bs-toggle="dropdown">
                            <img src="../Images/2.png" alt="" class="icon">
                        </a>
                    </li>

                </ul>
            </header>
        </div>
        <!---navbar end--->

        <!--------sidebar start---------->
        <div class="left-menu">
            <div class="menubar-content">
                <nav class="animated bounceInDown">
                    <ul id="sidebar">
                        <li class="active">
                            <a href="#"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="DataTable.php"><i class="fa-solid fa-users"></i>All Users</a>
                        </li>
                        <li>
                            <a href="Pending.php"><i class="fa-solid fa-user-check"></i>Pending Users</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-brands fa-expeditedssl"></i>Banned Users</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-user-tie"></i>Admin List</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-brands fa-expeditedssl"></i>Moderator List</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-envelope-open"></i>Email</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-regular fa-note-sticky"></i>Reports</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-user-gear"></i>Make Moderator</a>
                        </li>

                        <li class="sub-menu">
                            <a href="#"> <i class="fas fa-cogs"></i> Settings
                                <div class="fa fa-caret-down right"></div>
                            </a>
                            <ul class="left-menu-dp">
                                <li><a href=""><i class="fas fa-user-circle"></i>Account</a></li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
        <!--------sidebar end------------>
        <div class="content-wrapper">
            <section>
                <div class="all-admin my-5">
                    <div class="container-fluid">
                        <div class="row">
                            <!--Ekhane new user dekhabo-->
                            <div class="col-md-12 col-sm-12">
                                <div class="admin-list">                                  
                                    <div class="data-table-section table-responsive">
                                        <table id="userTable" class="table table-striped" style="width:100%">
                                            <thead>
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
                                            </thead>
                                            <tbody>
                                                <?php
                                                $db = new database();
                                                $query = "SELECT * from User where not (Rank = 'ADMIN' or Rank = 'MODERATOR')";
                                                $res = mysqli_query($db->connect(), $query);
                                                if (mysqli_num_rows($res) > 0) {

                                                    while ($row = mysqli_fetch_array($res)) {
                                                        include "../Model/user_row.php";
                                                    }
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--End of Ekhane new user dekhabo-->


                        </div>
                    </div>
                </div>
            </section>
        </div>


    </div>



    <!--Bootstrap 5-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!--JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

     <!--Custom JS-->                                           
    <script src="../Assets/scripts/main.js"></script>
    <!--Datatable-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                // responsive: true
            });
            //new $.fn.dataTable.FixedHeader(table);
        });

        function Approve(userID) {
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