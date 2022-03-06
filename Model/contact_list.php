<tr>    
    <td><?php echo $row['contactID']; ?></td>
    <td><?php echo $row['contactName']; ?></td>
    <td><?php echo $row['contactMail']; ?><a></td>
    <td><?php echo $row['contactSubject']; ?></td>
    <td><?php echo $row['contactMessage']; ?></td>
    <td><?php echo $row['contactStatus']; ?></td>   
    <td>     
        <?php include "view_contact.php" ?>
    </td>   
</tr>