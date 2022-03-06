<nav class="navbar navbar-expand-lg navbar-light bg-light" style="position: sticky; top: 0rem; align-self: start; z-index: 1;">
    <div>
        <ul class="navbar-nav mx-3">
            <li class="nav-item active">
                Hello, <?php echo $_SESSION['UserName'] ?>!
            </li>
        </ul>
    </div>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="home.php">Home</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="create_post.php">Create Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user_profile.php?id=<?php echo $_SESSION['UserID'] ?>">My Profile</a>
            </li>
            <li id="ddNotification" class="nav-item dropdown my-2">
                <a class="text-body text-decoration-none dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Notifications <span id="notificationCount"></span>
                </a>
                <ul id="panelNotification" class="shadow my-4 dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 25rem; left: 50%;transform: translateX(-50%);">

                </ul>
            </li>
            <?php
            if ($_SESSION['Rank'] == 'ADMIN' || $_SESSION['Rank'] == 'MODERATOR') {
                echo "<li class='nav-item'>
                    <a class='nav-link' href='AdminPanel/UserList.php'>Admin Panel</a>
                    </li>";
            }
            ?>
        </ul>
    </div>
    <div>
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="UserLogin/Logout.php">Sign Out</a>
            </li>
        </ul>
    </div>
</nav>

<script>
    function checkNotification() {
        $.ajax({
            type: 'POST',
            url: "Assets/api/manage_notification.php",
            data: {
                task: "COUNT"
            },
            success: function(data) {
                document.getElementById("notificationCount").innerText = "(" + data + ")";
            }
        });
    }

    setInterval(checkNotification, 5000);

    $('#ddNotification').on('show.bs.dropdown', function() {
        $.ajax({
            type: 'POST',
            url: "Assets/api/manage_notification.php",
            data: {
                task: "GET",
                limit: "ALL"
            },
            success: function(data) {
                document.getElementById("panelNotification").innerHTML = data;
            }
        });
    })
</script>