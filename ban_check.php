<?php
$checkID = $_SESSION['UserID'];
$conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
$query = "SELECT COUNT(UserID) as cntID FROM USER WHERE UserID = $checkID AND Rank = 'BANNED'";
$res = mysqli_query($conn, $query);
$row = "";

if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
}
if($row['cntID'] > 0) {
    header("location:UserLogin/Logout.php");
    echo "<h1 style='margin-left:40%;margin-right:auto'>ACCESS DENIED</h1>";
    
    die;
}
?>