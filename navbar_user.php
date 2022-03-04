<nav class="navbar navbar-expand-lg navbar-light bg-light" style="position: sticky; top: 0rem; align-self: start">
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
            <li class="nav-item">
                <a class="nav-link" href="#">Messages</a>
            </li>
            <?php
            if ($_SESSION['Rank'] == 'ADMIN') {
                echo "<li class='nav-item'>
                    <a class='nav-link' href='AdminPanel/Admin.php'>Admin Panel</a>
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