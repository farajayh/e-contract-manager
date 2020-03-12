<?php
ob_start();
include "dbConfig.php";
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $details =  $_POST['details'];
    $s_date = $_POST['s_date'];
    $s_time = $_POST['s_time'];
    $e_date =  $_POST['e_date'];
    $e_time =  $_POST['e_time'];
    $query = "INSERT INTO contracts (`title` , `details`,`start_date` ,`start_time`, `end_date`, `end_time`, `status`) 
    VALUES ('$title','$details','$s_date','$s_time','$e_date', '$e_time', '1')";
    $result = mysqli_query($db, $query);
    if (!$result) {
        print_r(mysqli_error_list($db));
    } else {
        header("location: index.php");
    }
}
ob_end_flush();
