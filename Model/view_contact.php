<button type="button" class="btn btn-info btn-h40" data-bs-toggle="modal" data-bs-target="#Modal<?php echo $row['contactID'] ?>">View</button>
<div class="modal fade" id="Modal<?php echo $row['contactID'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Contact View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="subject<?php echo $row['contactSubject'] ?>">Subject:</label>                
                <input id="subject<?php echo $row['contactSubject'] ?>" type = "text" name="subject" class="form-control bottom-input"disabled value = "<?php echo $row['contactSubject']?>">
                <label for="message<?php echo $row['contactMessage'] ?>">Message:</label>   
                <textarea id="message<?php echo $row['contactMessage'] ?>" name="message" class="form-control bottom-input" rows="5" disabled><?php echo $row['contactMessage'] ?></textarea>
                <label for="reply<?php echo $row['contactID'] ?>">Reply:</label>
                <textarea id="reply<?php echo $row['contactID'] ?>" name="reply" class="form-control bottom-input" rows="5" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="sendMail(<?php echo "\'$row[contactMail]\', $row[contactID]"; ?>)">Reply</button>
            </div>
        </div>
    </div>
</div>