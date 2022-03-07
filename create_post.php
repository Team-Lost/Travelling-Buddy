<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location:UserLogin/Login.php");
}
include "Model/Database.php";
include "ban_check.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/cee0f4dddc.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="Assets\css\home.css" rel="stylesheet">
</head>

<body class="body-ssp-fb">
    <?php
    include "navbar_user.php";
    ?>
    <div class="container mt-p-10-5 container-fitter">
        <form action="#" method="post" id="inp_form">
            <div class="form-group" id="input_fields">
                <label for="startTime">Start time:</label>
                <input type="datetime-local" id="startTime" name="startTime" class="form-control" required>
                <label for="endTime">End Time:</label>
                <input type="datetime-local" id="endTime" name="endTime" class="form-control" required>
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control bottom-input" rows="3"></textarea>
                <label for="budget">Budget:</label>
                <input type="number" id="budget" name="budget" class="form-control bottom-input" required>
                <label for="location">Location</label>
                <input type="text" id="location" name="location[]" class="form-control bottom-input" required>
            </div>
            <button type="button" class="btn btn-info form-control my-2" id="addLocation" name="addLocation">Add Location</button>
            <button type="submit" class="btn btn-primary form-control" name="Submit">Create Post</button>
        </form>
    </div>
    <?php
    $currID = $_SESSION['UserID'];
    if (isset($_POST['Submit'])) {
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $description = $_POST['description'];
        if (is_null(trim($description))) {
            $description = " ";
        }
        $budget = $_POST['budget'];
        $location = "";
        foreach ($_POST['location'] as $key => $value) {
            $location = $location . ' >> ' . $value;
        }
        $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
        $query = "INSERT INTO POSTS(posterID, location, budget, description, startingTime, endingTime) VALUES" .
            "($currID, '$location', $budget, '$description', '$startTime', '$endTime')";
        //echo $query . '<br>';
        mysqli_query($conn, $query);
    }

    ?>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <script>
        var inputBox = "<input type='text' id='location' name='location[]' class='form-control margin-t5'>";
        var btnAddLoc = document.getElementById("addLocation");
        $("#addLocation").on("click", function() {
            $("#input_fields").append(inputBox);
        });
    </script>
</body>

</html>