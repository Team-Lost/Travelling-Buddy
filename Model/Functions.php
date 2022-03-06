<?php

function check_login()
{
    if (!isset($_SESSION['UserID'])) {
        header("Location: Login.php");
    }
}
function countPending()
{
    $db = new Database();
    $query = "SELECT count(Rank) from User where Rank = 'PENDING'";
    $res = mysqli_query($db->connect(), $query);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_array($res)) {
            return $row['count(Rank)'];
        }
    };
}
function countReport()
{
    //----Count Pending and Ranked----//
    $db = new Database();
    $query = "SELECT count(Status) from Reports where Status = 'UNRESOLVED'";
    $res = mysqli_query($db->connect(), $query);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_array($res)) {
            return $row['count(Status)'];
        }
    }
}
