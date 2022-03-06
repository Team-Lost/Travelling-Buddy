<div class="d-flex p-0 flex-row justify-content-start">
    <div class="p-2 bd-highlight"><img src="<?php echo $imgPath ?>" style="max-height: 4rem; max-width: 4rem" class="img-fluid thumbnail rounded-circle"></div>
    <div class="d-flex flex-column">
        <div class="bd-highlight">
            <a href="user_profile.php?id=<?php echo $row['UserID'] ?>"><?php echo $row['UserName'] ?></a>
        </div>
        <div class="bd-highlight">
            <?php echo $row['Mail'] ?>
        </div>
        <div class="bd-highlight">
            <?php echo $row['Phone'] ?>
        </div>
    </div>
</div>