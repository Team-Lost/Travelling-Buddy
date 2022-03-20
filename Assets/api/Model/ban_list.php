<tr id = "banRow<?php echo $row['UserID'];?>">
    <td><?php echo $row['UserName']; ?></td>
    <td><?php echo $row['Mail']; ?></td>  
    <td>
        <a href="<?php echo "javascript:removeBan($row[UserID], '$row[Mail]')";?>">Remove Ban</a>
    </td>
</tr>