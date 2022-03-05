<tr>
    <td>
    <?php
    if ($row['reportType'] == 'POST') {
        echo "
            <a href='../post.php?postID=$row[reportedID]' target='_blank'>Post</a>
        ";
    }
    else
    {
        echo "
            <a href='../user_profile.php?id=$row[reportedID]' target='_blank'>Profile</a>
        ";
    }
    ?>
    </td>  
    <td><?php echo $row['reportedID']; ?></td> 
    <td><?php echo $row['reason']; ?></td>
    <td><?php echo $row['details']; ?></td>
    <td><?php echo $row['status']; ?></td>
    <td>
        <a href="<?php echo "javascript:Ban($row[reportedID], $row[reportType])";?>">Ban</a>
        <a href="<?php echo "javascript:Dismiss($row[reportedID], $row[reportType])";?>">Reject</a>
    </td>
</tr>