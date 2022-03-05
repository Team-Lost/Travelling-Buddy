<tr>
    <td><?php echo $row['UserID']; ?></td>
    <td><?php echo $row['UserName']; ?></td>
    <td><?php echo $row['Phone']; ?></td>
    <td><a href="mailto:"><?php echo $row['Mail']; ?><a></td>
    <td><?php echo $row['Gender']; ?></td>
    <td id = "rank<?php echo $row['UserID'] ?>"><?php echo $row['Rank']; ?></td>
    <?php    
    $fileName = explode('.', $row['IDFile']);
    if (end($fileName) == "pdf") {
        $fileDestination = 'UserIdentification/Documents/' . $row['IDFile'];
    } else {
        $fileDestination = 'UserIdentification/Images/' . $row['IDFile'];
    }
    ?>
    <td><a href="<?php echo $fileDestination; ?>"><?php echo $row['IDFile']; ?></a></td>   
    <td><?php echo $row['creationDate']; ?></td>   
    <td>
        <a href="<?php echo "javascript:Approve($row[UserID])";?>">Approve</a>
         <a href="<?php echo "javascript:Reject($row[UserID])";?>">Reject</a>
    </td>
</tr>