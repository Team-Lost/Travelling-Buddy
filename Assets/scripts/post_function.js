$('button').click(function() {
    var curr = $(this),
        postID = curr.attr('post-id'),
        btnID = curr.attr('id');
    if (btnID.toString() == 'btn-join') {
        $.ajax({
            type: 'post',
            data: {
                ajax: 1,
                task: 'join',
                postID: postID,
            }
        });
    }
    if (btnID.toString() == 'btn-upvote' || btnID.toString() == 'btn-downvote') {
        var curr = $(this);
        var name = curr.attr('id').split('-')[1];
        var iconUpvote = document.getElementById('upvote-' + postID);
        var iconDownvote = document.getElementById('downvote-' + postID);
        var vote = iconUpvote.getAttribute('vote');
        var change = 0;
        if (name.toString() == 'upvote') {
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
                ajax: 1,
                task: 'updateVote',
                postID: postID,
                vote: vote
            }
        });
    }
});

function loadPost($postID) {
    location.replace("post.php?postID=" + $postID);
}