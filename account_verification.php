<?php
include "dbConfig.php";
$email = urldecode($_GET['email']);
$key = urldecode($_GET['key']);
$query = "SELECT * FROM users WHERE email = '$email' and key = $key";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) == 1) {
    $query = "UPDATE users SET status = 'active' WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    if($result)
    {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['logged_in'] = 1;
        header("location: index.php");
    }
}
?>