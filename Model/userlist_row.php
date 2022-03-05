<tr>    
    <td><?php echo $row['UserName']; ?></td>
    <td><?php echo $row['Phone']; ?></td>
    <td><a href="mailto:"><?php echo $row['Mail']; ?><a></td>
    <td><?php echo $row['Gender']; ?></td>
    <td><?php echo $row['Rank']; ?></td>
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
</tr>