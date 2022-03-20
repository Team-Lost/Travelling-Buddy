<div class="d-flex p-0 flex-row justify-content-start">
    <div class="p-2 bd-highlight"><img src="profile_picture.png" style="max-height: 4rem; max-width: 4rem" class="img-fluid thumbnail rounded-circle"></div>
    <div class="d-flex flex-column">
        <div class="p-2 bd-highlight">
            <a href="user_profile.php?id=<?php echo $row['UserID'] ?>"><?php echo $row['UserName'] ?></a> wants to join your <a href="post.php?postID=<?php echo $row['postID'] ?>">Plan <?php echo $row['postID'] ?></a>
        </div>
        <div class="d-flex flex-row">
            <button type="button" onclick="acceptUser(<?php echo $row['UserID'] . ',' . $row['postID'] ?>)" class="btn btn-primary mx-2">Accept</button>
            <button type="button" onclick="rejectUser(<?php echo $row['UserID'] . ',' . $row['postID'] ?>)" class="btn btn-secondary mx-2">Reject</button>
        </div>
    </div>
</div>