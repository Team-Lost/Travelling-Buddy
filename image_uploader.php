<?php
session_start();
function deletePreviousFile($directory)
{
    $files = glob($directory . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deletePreviousFile($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}

function showJSError($message)
{
    echo "<script type=\"text/javascript\">" .
        "showError($message);" .
        "</script>";
}

$currID = $_SESSION['UserID'];
$response = 0;
if(isset($_FILES['file']['name'])){
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpDestination = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png');
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 8000000) {
                $fileDestination = "ProfilePictures/$currID/$currID.$fileActualExt";
                deletePreviousFile("ProfilePictures/$currID/");
                mkdir("ProfilePictures/$currID/");
                move_uploaded_file($fileTmpDestination, $fileDestination);
                $response = 1;
            } else {
                showJSError("Image size is too big!");
            }
        } else {
            showJSError("Error uploading your picture!");
        }
    } else {
        showJSError("Unsupported file format!");
    }
    echo $response;
}
?>