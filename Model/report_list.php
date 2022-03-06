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
    <td id = "status<?php echo $row['reportID'] ?>"><?php echo $row['status']; ?></td>
    <td>       
        <!----ReportID----ReportedID------ReportedType---------ReportedBy-->       
        <a href="<?php echo "javascript:Ban($row[reportID], $row[reportedID], '$row[reportType]', $row[reportedBy])";?>">Ban</a>
        <!--ReportID------ReportedType---------ReportedBy-->
        <a href="<?php echo "javascript:Dismiss($row[reportID], $row[reportedID], '$row[reportType]', $row[reportedBy])";?>">Dismiss</a>
    </td>
</tr>