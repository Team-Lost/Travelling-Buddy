<?php
include "Model/Database.php";
//  require 'PHPMailer-master/mail.php';
$db = new database();
$query = "SELECT * from User";
$res = mysqli_query($db->connect(), $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.bootstrap.min.css">

</head>

<body>
    <div class="container mb-3 mt-3">
        <table class="table table-striped table-bordered" style="width: 100%" id="userTable">
            <thead>
                <th>UserID</th>
                <th>UserName</th>
                <th>Phone</th>
                <th>Mail</th>
                <th>Gender</th>
                <th>Rank</th>
                <th>IDFile</th>
                <th>Join Date</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($res) > 0) {

                    while ($row = mysqli_fetch_array($res)) {

                        ?> 
                                <tr>  
                                    <td><?php echo $row['UserID'];?></td>  
                                    <td><?php echo $row['UserName'];?></td>  
                                    <td><?php echo $row['Phone'];?></td>  
                                    <td><a href="mailto:"><?php echo $row['Mail'];?><a></td>  
                                    <td><?php echo$row['Gender'];?></td>
                                    <td><?php echo$row['Rank'];?></td>  
                                    <td><?php echo$row['IDFile'];?></td>
                                    <td><?php echo $row['creationDate'];?></td>
                                    <td><a href="Approve">Approve</a>
                                     <a href="Reject">Reject</a></td>      
                               </tr>  
                     <?php          
                    }
                }
                ?>
              

            </tbody>
        </table>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
               // responsive: true
            });
            //new $.fn.dataTable.FixedHeader(table);
        });
    </script>
</body>

</html>