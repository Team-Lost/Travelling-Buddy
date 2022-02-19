<?php
function check_login()
{
    if(!isset($_SESSION['UserID']))
    {
        header("Location: Login.php");
    }    
 
}
?>