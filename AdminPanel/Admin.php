<?php
session_start();
$countPending = 0;
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
$db = new Database();
$query = "SELECT count(Rank) from User where Rank = 'PENDING'";
$res = mysqli_query($db->connect(), $query);
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_array($res)) {
        $countPending = $row['count(Rank)'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <title>Admin Panel Using Php</title>
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
                            <a href="UserList.php"><i class="fa-solid fa-users"></i>All Users</a>
                        </li>
                        <li>
                            <a href="Pending.php"><i class="fa-solid fa-user-check"></i>Pending Users<?php echo $countPending ?></a>
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
                            <a href="https://mail.google.com/mail/u/2/#inbox"><i class="fa-solid fa-envelope-open"></i>Email</a>
                        </li>
                        <li>
                            <a href="Reports.php"><i class="fa-regular fa-note-sticky"></i>Reports</a>
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
            <!-----Chart Section----->
            <section class="dashboard-top-sec">
                <div class="container-fluid">

                    <div class="row">
                        <!--Start of Line chart-->
                        <div class="col-lg-8">
                            <div class="bg-white top-chart-earn">
                                <div class="row">
                                    <!--Description Part Start-->
                                    <div class="col-sm-4">


                                        <div class="last-month">
                                            <h5>Dashboard</h5>
                                            <p>Overview of Latest Month</p>

                                            <div class="earn">
                                                <h2>$3367.98</h2>
                                                <p>Current Month Sales</p>
                                            </div>
                                            <div class="sale mb-3">
                                                <h2>95</h2>
                                                <p>Current Month Sales</p>
                                            </div>


                                            <a href="" class="di-btn purple-gradient">Last Month Summary</a>
                                        </div>

                                    </div>
                                    <!--Description Part End-->

                                    <div class="col-sm-8 my-2 ps-0">
                                        <!----Chart and Tab part Start----->
                                        <div class="classic-tabs">
                                            <!-- ------Nav Tabs====== -->
                                            <div class="tabs-wrapper">
                                                <ul class="nav nav-pills chart-header-tab mb-3" id="pills-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link chart-nav active" id="pills-week-tab" data-bs-toggle="pill" data-bs-target="#pills-week" type="button" role="tab" aria-controls="pills-week" aria-selected="true">Week</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link chart-nav" id="pills-month-tab" data-bs-toggle="pill" data-bs-target="#pills-month" type="button" role="tab" aria-controls="pills-month" aria-selected="false">Month</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link chart-nav" id="pills-year-tab" data-bs-toggle="pill" data-bs-target="#pills-year" type="button" role="tab" aria-controls="pills-year" aria-selected="false">year</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pills-week" role="tabpanel" aria-labelledby="pills-week-tab">
                                                        Week
                                                        <div class="widget-content">
                                                            <div id="weekly"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
                                                        Month
                                                        <div class="widget-content">
                                                            <div id="monthly"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-year" role="tabpanel" aria-labelledby="pills-year-tab">
                                                        Years
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!----Chart and Tab part End----->


                                    </div>
                                </div>

                                <!----Chart verview in text--->
                                <div class="wrapper-sec">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-6 my-1 borderCls">
                                            <div class="earn-view">
                                                <span class="fas fa-crown earn-icon wallet"></span>
                                                <div class="earn-view-text">
                                                    <p class="name-text">Wallet Balance</p>
                                                    <h6 class="balance-text">$1684.54</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-6 my-1 border-cls">
                                            <div class="earn-view">
                                                <span class="fas fa-crown earn-icon wallet2"></span>
                                                <div class="earn-view-text">
                                                    <p class="name-text">Wallet Balance</p>
                                                    <h6 class="balance-text">$1684.54</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-6 my-1 border-cls">
                                            <div class="earn-view">
                                                <span class="fas fa-crown earn-icon wallet3"></span>
                                                <div class="earn-view-text">
                                                    <p class="name-text">Wallet Balance</p>
                                                    <h6 class="balance-text">$1684.54</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-6 my-1 border-cls">
                                            <div class="earn-view">
                                                <span class="fas fa-crown earn-icon wallet4"></span>
                                                <div class="earn-view-text">
                                                    <p class="name-text">Wallet Balance</p>
                                                    <h6 class="balance-text">$1684.54</h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!----Chart verview in text--->
                            </div>
                        </div>
                        <!--End of Line chart-->

                        <!--Start of Line chart-->
                        <div class="col-lg-4">
                            <div class="bg-white top-chart-earn">
                                <div class="traffic-title">
                                    <p>Traffic</p>
                                </div>
                                <div class="traffic">
                                    <div id="chart-2">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--End of Pie chart-->
                    </div>

                </div>
            </section>
            <!-----End of Chart Section----->

            <!--Mini Chart Section-->
            <section>
                <div class="sm-chart-sec my-5">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                                <div class="revinue revinue-one_hybrid">
                                    <div class="revinue-hedding">
                                        <div class="w-title">
                                            <div class="w-icon">
                                                <span class="fas fa-users"></span>
                                            </div>
                                            <div class="sm-chart-text">
                                                <p class="w-value">31.9k</p>
                                                <h5>Flollowers</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="revinue-content">
                                        <div id="hybrid_followers"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                                <div class="revinue page-one_hybrid">
                                    <div class="revinue-hedding">
                                        <div class="w-title">
                                            <div class="sm-chart-text">
                                                <p class="w-value">654k</p>
                                                <h5>Page View</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="revinue-content">
                                        <div id="hybrid_followers1"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                                <div class="revinue bonuce-one_hybrid">
                                    <div class="revinue-hedding">
                                        <div class="w-title">
                                            <div class="sm-chart-text">
                                                <p class="w-value">$432</p>
                                                <h5>Bonuce Rate</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="revinue-content">
                                        <div id="hybrid_followers3"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                                <div class="revinue rv-status-one_hybrid">
                                    <div class="revinue-hedding">
                                        <div class="w-title">
                                            <div class="sm-chart-text">
                                                <p class="w-value">$ 765 <small>Jan 01 - Jan 10</small></p>
                                                <h5>Revinue Status</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="revinue-content">
                                        <div id="rv_status_chart4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--End of Mini Chart Section-->

            <!------admin show and order status table--------->
            <section>
            <div class="style-table my-5">
                    <div class="container-fluid">
                        <div class="row">
                            <!--Admin Active Status-->
                            <div class="col-md-4 col-sm-6">
                                <div class="admin-list">
                                    <p class="admin-ac-title">All Admin</p>
                                    <ul class="admin-ul">
                                        <li class="admin-li">
                                            <img src="../Images/2.png" alt="" class="admin-image">
                                            <div class="admin-ac-details">
                                                <div>
                                                    <a href="#" class="admin-name">Helal Uddin</a>
                                                    <p class="activaty-text">Active Now</p>
                                                </div>
                                                <div class="status bg-success"></div>

                                            </div>
                                        </li>

                                        <li class="admin-li">
                                            <img src="../Images/2.png" alt="" class="admin-image">
                                            <div class="admin-ac-details">
                                                <div>
                                                    <a href="" class="admin-name">Rocky Islam</a>
                                                    <p class="activaty-text">Active 15 min ago</p>
                                                </div>
                                                <div class="status bg-primary"></div>

                                            </div>
                                        </li>
                                        <li class="admin-li">
                                            <img src="../Images/2.png" alt="" class="admin-image">
                                            <div class="admin-ac-details">
                                                <div>
                                                    <a href="" class="admin-name">Jewel Khan</a>
                                                    <p class="activaty-text">Active 20 min ago</p>
                                                </div>
                                                <div class="status bg-warning"></div>

                                            </div>
                                        </li>
                                        <li class="admin-li">
                                            <img src="../Images/2.png" alt="" class="admin-image">
                                            <div class="admin-ac-details">
                                                <div>
                                                    <a href="" class="admin-name">Afjal Sohel</a>
                                                    <p class="activaty-text">Active 2 Days ago</p>
                                                </div>
                                                <div class="status bg-danger"></div>

                                            </div>
                                        </li>
                                        <li class="admin-li">
                                            <img src="../Images/2.png" alt="" class="admin-image">
                                            <div class="admin-ac-details">
                                                <div>
                                                    <a href="" class="admin-name">Devingine</a>
                                                    <p class="activaty-text">Active 12 min ago </p>
                                                </div>
                                                <div class="status bg-success"></div>

                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--End of Admin Active Status-->

                            <!--Ekhane new user dekhabo-->
                            <div class="col-md-8 col-sm-6">
                            <div class="show-table">
                                    <p class="order-acc-title">Order Status</p>
                                    <div class="data-table-section table-responsive">
                                        <table id="tableNewUser" class="table table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Office</th>
                                                    <th>Age</th>
                                                    <th>Start date</th>
                                                    <th>Salary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Tiger Nixon</td>
                                                    <td>System Architect</td>
                                                    <td>Edinburgh</td>
                                                    <td>61</td>
                                                    <td>2011/04/25</td>
                                                    <td>$320,800</td>
                                                </tr>
                                                <tr>
                                                    <td>Garrett Winters</td>
                                                    <td>Accountant</td>
                                                    <td>Tokyo</td>
                                                    <td>63</td>
                                                    <td>2011/07/25</td>
                                                    <td>$170,750</td>
                                                </tr>
                                                <tr>
                                                    <td>Ashton Cox</td>
                                                    <td>Junior Technical Author</td>
                                                    <td>San Francisco</td>
                                                    <td>66</td>
                                                    <td>2009/01/12</td>
                                                    <td>$86,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Cedric Kelly</td>
                                                    <td>Senior Javascript Developer</td>
                                                    <td>Edinburgh</td>
                                                    <td>22</td>
                                                    <td>2012/03/29</td>
                                                    <td>$433,060</td>
                                                </tr>
                                                <tr>
                                                    <td>Airi Satou</td>
                                                    <td>Accountant</td>
                                                    <td>Tokyo</td>
                                                    <td>33</td>
                                                    <td>2008/11/28</td>
                                                    <td>$162,700</td>
                                                </tr>
                                                <tr>
                                                    <td>Brielle Williamson</td>
                                                    <td>Integration Specialist</td>
                                                    <td>New York</td>
                                                    <td>61</td>
                                                    <td>2012/12/02</td>
                                                    <td>$372,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Herrod Chandler</td>
                                                    <td>Sales Assistant</td>
                                                    <td>San Francisco</td>
                                                    <td>59</td>
                                                    <td>2012/08/06</td>
                                                    <td>$137,500</td>
                                                </tr>
                                                <tr>
                                                    <td>Rhona Davidson</td>
                                                    <td>Integration Specialist</td>
                                                    <td>Tokyo</td>
                                                    <td>55</td>
                                                    <td>2010/10/14</td>
                                                    <td>$327,900</td>
                                                </tr>
                                                <tr>
                                                    <td>Colleen Hurst</td>
                                                    <td>Javascript Developer</td>
                                                    <td>San Francisco</td>
                                                    <td>39</td>
                                                    <td>2009/09/15</td>
                                                    <td>$205,500</td>
                                                </tr>
                                                <tr>
                                                    <td>Sonya Frost</td>
                                                    <td>Software Engineer</td>
                                                    <td>Edinburgh</td>
                                                    <td>23</td>
                                                    <td>2008/12/13</td>
                                                    <td>$103,600</td>
                                                </tr>
                                                <tr>
                                                    <td>Jena Gaines</td>
                                                    <td>Office Manager</td>
                                                    <td>London</td>
                                                    <td>30</td>
                                                    <td>2008/12/19</td>
                                                    <td>$90,560</td>
                                                </tr>
                                                <tr>
                                                    <td>Quinn Flynn</td>
                                                    <td>Support Lead</td>
                                                    <td>Edinburgh</td>
                                                    <td>22</td>
                                                    <td>2013/03/03</td>
                                                    <td>$342,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Charde Marshall</td>
                                                    <td>Regional Director</td>
                                                    <td>San Francisco</td>
                                                    <td>36</td>
                                                    <td>2008/10/16</td>
                                                    <td>$470,600</td>
                                                </tr>
                                                <tr>
                                                    <td>Haley Kennedy</td>
                                                    <td>Senior Marketing Designer</td>
                                                    <td>London</td>
                                                    <td>43</td>
                                                    <td>2012/12/18</td>
                                                    <td>$313,500</td>
                                                </tr>
                                                <tr>
                                                    <td>Tatyana Fitzpatrick</td>
                                                    <td>Regional Director</td>
                                                    <td>London</td>
                                                    <td>19</td>
                                                    <td>2010/03/17</td>
                                                    <td>$385,750</td>
                                                </tr>
                                                <tr>
                                                    <td>Michael Silva</td>
                                                    <td>Marketing Designer</td>
                                                    <td>London</td>
                                                    <td>66</td>
                                                    <td>2012/11/27</td>
                                                    <td>$198,500</td>
                                                </tr>
                                                <tr>
                                                    <td>Paul Byrd</td>
                                                    <td>Chief Financial Officer (CFO)</td>
                                                    <td>New York</td>
                                                    <td>64</td>
                                                    <td>2010/06/09</td>
                                                    <td>$725,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Gloria Little</td>
                                                    <td>Systems Administrator</td>
                                                    <td>New York</td>
                                                    <td>59</td>
                                                    <td>2009/04/10</td>
                                                    <td>$237,500</td>
                                                </tr>
                                                <tr>
                                                    <td>Bradley Greer</td>
                                                    <td>Software Engineer</td>
                                                    <td>London</td>
                                                    <td>41</td>
                                                    <td>2012/10/13</td>
                                                    <td>$132,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Dai Rios</td>
                                                    <td>Personnel Lead</td>
                                                    <td>Edinburgh</td>
                                                    <td>35</td>
                                                    <td>2012/09/26</td>
                                                    <td>$217,500</td>
                                                </tr>
                                                <tr>
                                                    <td>Jenette Caldwell</td>
                                                    <td>Development Lead</td>
                                                    <td>New York</td>
                                                    <td>30</td>
                                                    <td>2011/09/03</td>
                                                    <td>$345,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Yuri Berry</td>
                                                    <td>Chief Marketing Officer (CMO)</td>
                                                    <td>New York</td>
                                                    <td>40</td>
                                                    <td>2009/06/25</td>
                                                    <td>$675,000</td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--End of Ekhane new user dekhabo-->


                        </div>
                    </div>
                </div>
            </section>
            <!-----------admin show and order status table end------------->
        </div>
    </div>










    <!--Bootstrap 5-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!--JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--Custom JS-->
    <script src="../Assets/scripts/main.js"></script>
    <!--Chart-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.33.2/apexcharts.min.js" integrity="sha512-iBEfFld2z1SAXCPmgoA40VQtqGP0cEJw4fy+t3ARW30uEfzf8hyrmm4mc5qdth3wZRPdKTv/auk5WH52klRVDg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../Assets/scripts/chart.js"></script>
    <!--Initialize Chart-->
    <script>
        const myChart = new Chart(
            document.getElementById('#weekly'),
            config
        );
    </script>
    <!--Datatable-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>