<div class="container mt-p-10-5 container-fitter">
    <div class="row justify-content-center">
        <div class="col-1">
            <img src="profile_picture.jpg" class="img-fluid thumbnail rounded-circle img-fixed">
        </div>
        <div class="col-11 text-center-v">
            <p class="text-center-v"><?php echo $userPost['UserName'] ?></p>
        </div>
    </div>
    <div class="row justify-content-center my-2">
        <div class="col-12 gap-gray"></div>
    </div>
    <div class="row justify-content-center my-2">
        <div class="col-12">
            <span class="badge bg-info text-dark">Location</span>
            <p class="margin-1-2">
                <?php echo $userPost['location'] ?>
            </p>
            <span class="badge bg-info text-dark">Budget</span>
            <p class="margin-1-2">
                <?php echo $userPost['budget'] ?>
            </p>
            <span class="badge bg-info text-dark">Details</span>
            <p class="margin-1-2 text-justify"><?php echo $userPost['description'] ?></p>
            <span class="badge bg-info text-dark">Time</span>
            <p class="margin-1-2">
                <?php echo $userPost['startingTime'] . " - " . $userPost['endingTime'] ?>
            </p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 gap-gray"></div>
    </div>
    <div class="row justify-content-left my-2">
        <div class="col-1 text-center text-center-v">
            <p id="count-<?php echo $userPost['postID'] ?>" class="text-center-v"><?php echo $userPost['voteCount'] ?></p>
        </div>
        <div class="col-2 text-center text-center-v">
            <div class="btn-group" role="group">
                <button id="btn-upvote" post-id="<?php echo $userPost['postID'] ?>" type="button" class="btn btn-info">
                    <i id="upvote-<?php echo $userPost['postID'] ?>" vote="<?php echo $voteStatus ?>" class="<?php echo $upvoteIconClass ?>"></i>
                </button>
                <button id="btn-downvote" post-id="<?php echo $userPost['postID'] ?>" type="button" class="btn btn-info">
                    <i id="downvote-<?php echo $userPost['postID'] ?>" vote="<?php echo $voteStatus ?>" class="<?php echo $downvoteIconClass ?>"></i>
                </button>
            </div>
        </div>
        <div class="col-8">
            <div class="btn-group" role="group">
                <button id="btn-join" type="button" post-id="<?php echo $userPost['postID'] ?>" class="btn btn-info">
                    <i class="fa-regular fa-square-check fa-xl"></i>
                    <span class="mx-1">Join</span></button>
                <button type="button" class="btn btn-info">
                    <i class="fa-regular fa-comment-dots fa-xl"></i>
                    <span class="mx-1">Comment</span></button>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</div>