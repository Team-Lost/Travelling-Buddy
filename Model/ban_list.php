<tr>
    <td><?php echo $row['UserID']; ?></td>
    <td><?php echo $row['Mail']; ?></td>  
    <td>
        <a href="<?php echo "javascript:removeBan($row[UserID], '$row[Mail]')";?>">Remove Ban</a>
    </td>
</tr>