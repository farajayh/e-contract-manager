<?php
session_start();
ob_start();
$_SESSION['user_id'] = "";
$_SESSION['longged_in'] = 0;
if(isset($_COOKIE[session_name()]))
{
   setcookie(session_name(), '', time()-20000);
}
session_destroy();
header("location: index.php");
ob_end_flush();
?>