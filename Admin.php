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
include "navbar_user.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Admin</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            list-style-type: none;
            text-decoration: none;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            background: #65C18C;
            overflow: hidden;

        }

        .sidebar-brand {
            font-size: 30px;
            padding: 1rem 0rem 1rem 2rem;
            color: #fff;
        }

        .sidebar-brand span {
            display: inline-block;
            padding-right: 1rem;
        }

        .sidebar-menu li {
            width: 100%;
            margin-bottom: 1.7rem;
            margin-left: 1.1rem;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .sidebar-menu li:hover {
            width: 100%;
            background: #fff;
            margin-bottom: 1.7rem;
            border-radius: 30px 0px 0px 30px;
        }

        .sidebar-menu a {
            display: block;
            color: white;
            font-size: 17px;
            text-decoration: none;
            padding-left: 1rem;
        }

        .sidebar-menu a:hover {
            color: #65C18C;
        }
    </style>
</head>

<body>
    <!--sidebar-->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h1><span class="las la-user-shield"></span>Admin</h1>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li id="textHover1">
                    <a href=""><span class="las la-igloo"></span>
                        <span>Dashboard</span></a>
                </li>
                <li id="textHover2">
                    <a href="UserList.php"><span class="las la-users"></span>
                        <span>User List</span></a>
                </li>
                <li id="textHover3">
                    <a href="DataTable.php"><span class="las la-th-list"></span>
                        <span>Pending</span></a>
                </li>
            </ul>
        </div>
    </div>
    <!--sidebar-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var dashboardHoverA1 = document.querySelector('#textHover1 a')
        var dashboardHover1 = document.getElementById('textHover1')

        function onHoverA1() {
            dashboardHoverA1.style.color = "#65C18C";
        }

        function outHoverA1() {
            dashboardHoverA1.style.color = "#fff";
        }
        dashboardHover1.addEventListener('mouseover', onHoverA1)
        dashboardHover1.addEventListener('mouseout', outHoverA1)

        var dashboardHoverA2 = document.querySelector('#textHover2 a')
        var dashboardHover2 = document.getElementById('textHover2')

        function onHoverA2() {
            dashboardHoverA2.style.color = "#65C18C";
        }

        function outHoverA2() {
            dashboardHoverA2.style.color = "#fff";
        }
        dashboardHover2.addEventListener('mouseover', onHoverA2)
        dashboardHover2.addEventListener('mouseout', outHoverA2)

        var dashboardHoverA3 = document.querySelector('#textHover3 a')
        var dashboardHover3 = document.getElementById('textHover3')

        function onHoverA3() {
            dashboardHoverA3.style.color = "#65C18C";
        }

        function outHoverA3() {
            dashboardHoverA3.style.color = "#fff";
        }
        dashboardHover3.addEventListener('mouseover', onHoverA3)
        dashboardHover3.addEventListener('mouseout', outHoverA3)
    </script>
</body>

</html>