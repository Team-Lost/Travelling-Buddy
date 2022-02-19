<?php
    include 'mail.php';
   // sendMail($receipient, $subject, $message);
   if(sendMail("190104101@aust.edu", "Test1", "Hello there!"))
   {
        echo "Send Mail Called";
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>