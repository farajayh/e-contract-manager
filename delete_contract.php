<?php
ob_start();
include "dbConfig.php";
if(isset($_GET['id']))
{ 
    $id = $_GET['id'];
    $query = "DELETE  from events WHERE id = $id";
    $result = mysqli_query($db,$query);
    if(!$result)
    {
        header("location: index.php");
    }
    else
    {
        header("location: index.php");
    }
}
ob_end_flush();
?>