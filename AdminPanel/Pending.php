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
include "../Model/Functions.php";
//in function class
$countPending = countPending();
$countReport = countReport();


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

                    <li class="nav-item btn-back">
                        <a href="../home.php">
                            Back to home
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
                        <li> 
                            <a href="UserList.php"><i class="fa-solid fa-users"></i>All Users</a>
                        </li>
                        <li class = "active">
                            <a href="#"><i class="fa-solid fa-user-check"></i>Pending Users<span class="mx-2" id="cntPending"><?php echo $countPending ?></span></a>
                        </li>
                        <li>
                            <a href="BannedUser.php"><i class="fa-brands fa-expeditedssl"></i>Banned Users</a>
                        </li>
                        <li>
                            <a href="ModeratorList.php"><i class="fa-solid fa-user-tie"></i>Moderator List</a>
                        </li>                      
                        <li>
                            <a href="ShowContact.php"><i class="fa-solid fa-envelope-open"></i>Contact</a>
                        </li>
                        <li>
                            <a href="Reports.php"><i class="fa-regular fa-note-sticky"></i>Reports<span class="mx-2" id="cntReport"><?php echo $countReport ?></span></a>
                        </li>
                        <?php
                        if ($_SESSION['Rank'] == 'ADMIN') {
                            echo "<li>
                            <a href='MakeModerator.php'><i class='fa-solid fa-plus'></i>Make Moderator</a>
                            </li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
        <!--------sidebar end------------>
        <div class="content-wrapper">
            <section>
                <div class="style-table my-5">
                    <div class="container-fluid">
                        <div class="row">
                            <!--Ekhane new user dekhabo-->
                            <div class="col-md-12 col-sm-12">
                                <div class="show-table">
                                    <div class="data-table-section table-responsive">
                                        <table class="table table-striped" style="width:100%" id="userTable">
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
                                                $query = "SELECT * from User where Rank = 'PENDING'";
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
    </script>

    <script>
        function Approve(userID) {   
            document.getElementById('rank' + userID).parentElement.innerHTML = "";
            document.getElementById('cntPending').innerText -= 1; 
            $.ajax({
                type: 'post',
                url: '../Assets/api/update_user_rank.php',
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
                    document.getElementById('rank' + userID).parentElement.innerHTML = "";
                    document.getElementById('cntPending').innerText -= 1; 
                    $.ajax({
                        type: 'post',
                        url: '../Assets/api/update_user_rank.php',
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