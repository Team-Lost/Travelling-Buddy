<?php
$voteStatus = 0;
$voteQuery = "SELECT * FROM `votes` WHERE postID = " . $userPost['postID'] . " AND voterID = $currID";
$upvoteIconClass = $downvoteIconClass = "";
$res = mysqli_query($conn, $voteQuery);
if (mysqli_num_rows($res) > 0) {
    while ($currRow = mysqli_fetch_assoc($res)) {
        $voteStatus = $currRow['voteStatus'];
    }
}

if ($voteStatus == -1) {
    $upvoteIconClass = "fa-regular fa-thumbs-up fa-xl";
    $downvoteIconClass = "fa-solid fa-thumbs-down fa-xl";
} else if ($voteStatus == 0) {
    $upvoteIconClass = "fa-regular fa-thumbs-up fa-xl";
    $downvoteIconClass = "fa-regular fa-thumbs-down fa-xl";
} else {
    $upvoteIconClass = "fa-solid fa-thumbs-up fa-xl";
    $downvoteIconClass = "fa-regular fa-thumbs-down fa-xl";
}
if (is_null($userPost['voteCount'])) {
    $userPost['voteCount'] = 0;
}
?>
<div class="container-fluid mt-p-10-5 container-fitter">
    <div class="row justify-content-center">
        <div class="col-1">
            <img src="<?php echo getPath($userPost['UserID']) ?>" class="img-fluid thumbnail rounded-circle img-fixed">
        </div>
        <div class="col-11 text-center-v">
            <a href="user_profile.php?id=<?php echo $userPost['UserID'] ?>">
                <p class="text-center-v"><?php echo $userPost['UserName'] ?></p>
            </a>
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
        <div class="col-3 text-center text-center-v">
            <div class="btn-group" role="group">
                <button onclick="votePost('upvote', <?php echo $userPost['postID'] ?>)" type="button" class="btn btn-info btn-h40">
                    <i id="upvote-<?php echo $userPost['postID'] ?>" vote="<?php echo $voteStatus ?>" class="<?php echo $upvoteIconClass ?>"></i>
                </button>
                <button onclick="votePost('downvote', <?php echo $userPost['postID'] ?>)" type="button" class="btn btn-info btn-h40">
                    <i id="downvote-<?php echo $userPost['postID'] ?>" vote="<?php echo $voteStatus ?>" class="<?php echo $downvoteIconClass ?>"></i>
                </button>
            </div>
        </div>
        <div class="col-6">
            <div class="btn-group" role="group">
                <button id="btn-join" type="button" post-id="<?php echo $userPost['postID'] ?>" class="btn btn-info btn-h40">
                    <i class="fa-regular fa-square-check fa-xl"></i>
                    <span class="mx-1">Join</span></button>
                <button type="button" class="btn btn-info btn-h40" onclick="javascript:reportPost(<?php echo $userPost['postID'] ?>)">
                    <i class="fa-regular fa-comment-dots fa-xl"></i>
                    <span class="mx-1">Comment</span></button>
            </div>
        </div>
        <div class="col-2">
            <?php
                if($userPost['UserID'] != $currID) {
                    include "Model/report_button.php";
                } else {
                    $editPostID = $userPost['postID'];
                    echo "<button type='button' class='btn btn-info btn-h40' onclick='editPost($editPostID)'>Edit</button>";
                }
            ?>
        </div>
    </div>
</div>