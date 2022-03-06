<?php
include "Model/Database.php";
require 'PHPMailer-master/mail.php';
$showError = "";
if (isset($_POST['submit'])) {
    $error = false;
    if (empty($_POST['mail']) || empty($_POST['name']) || empty($_POST['subject']) ||  empty($_POST['message'])) {
        $showError = "You need to fill out all the text";
        $error = true;
    }
    if (is_numeric($_POST['name']) || !preg_match('/^[a-zA-Z ]+$/', $_POST['name'])) {
        $showError = "Username can only contain letters!";
        $error = true;
    }
  

    //---check mail---//
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) || empty($_POST['mail']) || !preg_match('/^([a-zA-Z\d\.-]+)@([a-zA-Z\d-]+)\.([a-zA-Z]{2,3})(\.[a-zA-Z]{2,3})?$/', $_POST['mail'])) {
        $showError = "Please enter a valid email";
        $error = true;
    }
    if (!$error) {
        $name = trim($_POST['name']);
        $mail = trim($_POST['mail']);
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);
        $db = new Database();
        $query = "INSERT INTO CONTACT(contactName, contactMail, contactSubject, contactMessage) VALUES ('$name', '$mail', '$subject','$message')";
        //echo $query;
        //echo "data inserted succesfully";
        $db->updateTable($query);
        $to = 'travellingbuddy2908@gmail.com'; 
        ?>
         <script>
            Swal.fire({               
                icon: 'success',
                title: 'Thanks for contacting us.Our admin will see the matter',
                showConfirmButton: false,
                timer: 1500
              })
            </script>
        <?php  
        /*         
        if(contact($to,  $mail,  $subject, $message))
        {

        } */      
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/css/contactUs.css">
    <title>Document</title>
</head>

<body>
    <div class="wrapper" style="background-image: url('Images/bgContact.jpg');">
        <div class="inner">
            <form action="#" method="POST">
                <h3>Contact Us</h3>

                <div class="form-wrapper">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" name="name" required minlength=3 maxlength=100 required pattern="^[a-zA-Z ]+$">
                </div>

                <div class="form-wrapper">
                    <label for="mail">Email</label>
                    <input type="email" class="form-control" name="mail" required>
                </div>
                <div class="form-wrapper">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" name="subject" required>
                </div>
                <div class="form-wrapper">
                    <label for="">Your Message Here</label>
                    <textarea name="message" class="form-control" id="" cols="30" rows="10" required></textarea>
                </div>
                <input type="submit" value="Submit" name="submit">

            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>