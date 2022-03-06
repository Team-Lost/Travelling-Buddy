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
                            <a href="Admin.php"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="UserList.php"><i class="fa-solid fa-users"></i>All Users</a>
                        </li>
                        <li>
                            <a href="Pending.php"><i class="fa-solid fa-user-check"></i>Pending Users<span class="mx-2" id="cntPending"><?php echo $countPending ?></span></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-brands fa-expeditedssl"></i>Banned Users</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-brands fa-expeditedssl"></i>Moderator List</a>
                        </li>
                        <li>
                            <a href="ShowContact.php"><i class="fa-solid fa-envelope-open"></i>Contact</a>
                        </li>
                        <li>
                            <a href="Reports.php"><i class="fa-regular fa-note-sticky"></i>Reports<span class="mx-2" id="cntReport"><?php echo $countReport ?></span></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-user-gear"></i>Make Moderator</a>
                        </li>

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
                            <div class="col-md-12 col-sm-12">
                                <div class="show-table">
                                    <div class="data-table-section table-responsive">
                                        <table class="table table-striped table-hover" style="width:100%" id="contactTable">
                                            <thead>
                                                <th>Contact ID</th>
                                                <th>Contact Name</th>
                                                <th>Contact Mail</th>
                                                <th>Contact Subject</th>
                                                <th>Contact Message</th>
                                                <th>Contact Status</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $db = new Database();
                                                $query = "SELECT * from Contact Order by contactID Desc";
                                                $res = mysqli_query($db->connect(), $query);
                                                if (mysqli_num_rows($res) > 0) {
                                                    while ($row = mysqli_fetch_array($res)) {
                                                        include "../Model/contact_list.php";
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


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

        function sendMail(contactMail, contactID) {
            $("[data-bs-dismiss=modal]").trigger({ type: "click" });
            $.ajax({
                type: 'post',
                url: '../Assets/api/reply_contact.php',
                data: {
                    task: "reply",
                    contactMail: contactMail,
                    contactID: contactID,
                    contactReply: document.getElementById('reply' + contactID).value
                }
            });
            document.getElementById('status' + contactID).innerText = "REPLIED";
        }
    </script>
</body>

</html>