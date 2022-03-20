<button type="button" class="btn btn-info btn-h40" data-bs-toggle="modal" data-bs-target="#Modal<?php echo $userPost['postID'] ?>">Report</button>
<div class="modal fade" id="Modal<?php echo $userPost['postID'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="select<?php echo $userPost['postID'] ?>">Please select a problem:</label>
                <select class="form-select form-select-sm my-2" aria-label=".form-select-sm example" id="select<?php echo $userPost['postID'] ?>">
                    <option selected>False Information</option>
                    <option value="1">Harrassment</option>
                    <option value="2">Spam</option>
                    <option value="3">Hate Speech</option>
                    <option value="4">Something Else</option>
                </select>
                <label for="details<?php echo $userPost['postID'] ?>">Details:</label>
                <textarea id="details<?php echo $userPost['postID'] ?>" name="details" class="form-control bottom-input" rows="5" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="reportPost(<?php echo $userPost['postID'] ?>)">Report</button>
            </div>
        </div>
    </div>
</div>