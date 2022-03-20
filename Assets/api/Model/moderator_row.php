<tr>   
    <td><?php echo $row['UserName']; ?></td>
    <td><?php echo $row['Phone']; ?></td>
    <td><a><?php echo $row['Mail']; ?><a></td>
    <td><?php echo $row['Gender']; ?></td>
    <td id = "rank<?php echo $row['UserID'] ?>"><?php echo $row['Rank']; ?></td>
    <?php    
    $fileName = explode('.', $row['IDFile']);
    if (end($fileName) == "pdf") {
        $fileDestination = '../UserIdentification/Documents/' . $row['IDFile'];
    } else {
        $fileDestination = '../UserIdentification/Images/' . $row['IDFile'];
    }
    ?>
    <td><a href="<?php echo $fileDestination; ?>"><?php echo $row['IDFile']; ?></a></td>   
    <td><?php echo $row['creationDate']; ?></td>   
    <td>
        <a href="<?php echo "javascript:makeModerator($row[UserID], '$row[Mail]')";?>">Add</a>      
    </td>
</tr>