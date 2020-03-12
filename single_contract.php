<?php
session_start();
ob_start();
if(!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] != 1)
{
  header("location: login.php");
}
include "dbConfig.php";
$id = $_GET['id'];
$msg = "";
$query = "SELECT * FROM contracts WHERE contract_id='$id'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $row['title']?></title>
    <link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
</body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">E-Contract Manager</a>
    </div>
    <ul class="nav navbar-right">
      <li class="btn"><a href="logout.php">Log Out</a></li>
    </ul>
  </div>
</nav>
<div style="min-height: 650px; max-height: 3000000px;">
<div class="container">
   <h4> Event Title: </h4><div class="well well-large"><?php echo $row['title']?></div>
    <?php
    $user_id = $row['user_id'];
    $query2 = "SELECT * FROM users WHERE user_id='$user_id'";
    $result2 = mysqli_query($db, $query2);
    $row2 = mysqli_fetch_assoc($result2);
    ?>
    <h4>Date Created:</h4><div class="well well-large"> <?php echo $row['date_created'];?> by <?php echo $row2['surname']. ' '.$row2['first_name'];?></div>
    <h4>Starts: </h4><div class="well well-large"><?php echo $row['start_date']?></div>
    <h4>Ends: </h4><div class="well well-large"><?php echo $row['end_date']?></div>
    <?php 
     if ($row['last_modified_by'] != null) {
         echo "<h4> Last Modified: </h4>";
         echo '<div class="well well-large">Last Modified on '.$row['last_modified'].' by '.$row['last_modified_by'].'</div>';
     }
    ?>
    </br>
    <h4>Details: </h4><div class="well well-large"><?php echo nl2br($row['details'])?></div>
</div>
</div>
<style>
  .center{
    text-align:center;
  }
  #footer{
    height:100px; margin:0px; padding:4em; text-align:center; background:#000000; color:#D4E6F4;
  }
</style>
<div id="footer"> Copyright, <?php echo date("Y");?></div>
</body>
</html>
<?php ob_end_flush();?>