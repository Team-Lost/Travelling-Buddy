<?php
session_start();
if (isset($_POST['task'])) {
    if ($_POST['task'] == 'REPORT_ID') {
        $conn = mysqli_connect("localhost", "root", "", "TravellingBuddy");
        $currID = $_SESSION['UserID'];
        $userID = $_POST['userID'];
        $reason = $_POST['reason'];
        $details = $_POST['details'];
        $query = "INSERT INTO REPORTS(reportType, reportedID, reportedBy, reason, details)" .
            " VALUES('USER', $userID, $currID, '$reason', '$details')";
        mysqli_query($conn, $query);
    }
}
