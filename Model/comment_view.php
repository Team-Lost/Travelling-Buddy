<div class="container m-0 p-0">
    <div class="row">
        <div class="col-1">
            <img src="profile_picture.jpg" class="img-fluid thumbnail rounded-circle img-fixed">
        </div>
        <div class="col-11 p-1">
            <p><?php echo $row['UserName'] ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 gap-gray"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <p><?php echo $row['comment'] ?></p>
        </div>
    </div>
</div>