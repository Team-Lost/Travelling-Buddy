function loadPost($postID) {
    location.replace("post.php?postID=" + $postID);
}

function reportPost(postID) {
    var selectOpt = document.getElementById("select" + postID);
    var selectedOpt = selectOpt.options[selectOpt.selectedIndex].text;
    var detailsOpt = document.getElementById("details" + postID);
    $.ajax({
        type: 'post',
        data: {
            task: 'reportPost',
            postID: postID,
            reason: selectedOpt,
            details: detailsOpt.value
        },
    });
    $("[data-bs-dismiss=modal]").trigger({ type: "click" });
}

function votePost(taskName, postID) {
    alert(taskName);
    var iconUpvote = document.getElementById('upvote-' + postID);
    var iconDownvote = document.getElementById('downvote-' + postID);
    var vote = iconUpvote.getAttribute('vote');
    var change = 0;
    if (taskName.toString() == 'upvote') {
        if (vote == 1) {
            vote = 0;
            change = -1;
        } else if (vote == -1) {
            vote = 1;
            change = 2;
        } else {
            vote = 1;
            change = 1;
        }
    } else {
        if (vote == -1) {
            vote = 0;
            change = 1;
        } else if (vote == 1) {
            vote = -1;
            change = -2;
        } else {
            vote = -1;
            change = -1;
        }
    }

    iconUpvote.setAttribute("vote", vote);
    iconDownvote.setAttribute("vote", vote);
    if (vote == -1) {
        iconUpvote.setAttribute("class", "fa-regular fa-thumbs-up fa-xl");
        iconDownvote.setAttribute("class", "fa-solid fa-thumbs-down fa-xl");
    } else if (vote == 0) {
        iconUpvote.setAttribute("class", "fa-regular fa-thumbs-up fa-xl");
        iconDownvote.setAttribute("class", "fa-regular fa-thumbs-down fa-xl");
    } else {
        iconUpvote.setAttribute("class", "fa-solid fa-thumbs-up fa-xl");
        iconDownvote.setAttribute("class", "fa-regular fa-thumbs-down fa-xl");
    }
    var counter = document.getElementById('count-' + postID);
    var currCount = parseInt(counter.innerText) + change;
    counter.innerText = currCount;
    $.ajax({
        type: 'post',
        data: {
            task: 'updateVote',
            postID: postID,
            vote: vote
        }
    });
}