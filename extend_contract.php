<?php
ob_start();
session_start();
if(!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] != 1)
{
  header("location: login.php");
}
include "dbConfig.php";
$id = $_GET['id'];
$msg = "";
$query = "SELECT * FROM contracts WHERE contract_id='$id'";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) == 1) {
  $row = mysqli_fetch_array($result);
  print_r($row);
}
if ($row) {
     
    $prev_deadline = $row['end_date'];
}
if (isset($_POST['done'])) {
    $new_deadline = $_POST['new_deadline'];
    if ($new_deadline > $prev_deadline) {
        $query = "UPDATE contracts SET end_date = '$new_deadline' WHERE contract_id = '$id'";
        $result = mysqli_query($db, $query);
        if(!$result){print_r(mysqli_error_list($db));}
        $user_id =  $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = '$user_id' ";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $name = $row['surname']." ".$row['first_name'];
        $time = date("y-m-d h:i:s");
        $query = "UPDATE contracts SET last_modified = '$time' WHERE contract_id = '$id'";
        $result = mysqli_query($db, $query);
        $query = "UPDATE contracts SET last_modified_by = '$name' WHERE contract_id = '$id'";
        $result = mysqli_query($db, $query);
        if ($result) {
          header('location: index.php');
        }
    }
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Extend Event</title>
    <link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <style>

.kp {
    margin-top: 200px;
    margin-bottom: 200px;
    margin-right: 150px;
    margin-left: 80px;
}
</style>
</head>
<body><!--
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">LASU E-Contract Manager</a>
    </div>
    <ul class="nav navbar-right">
      <li class="btn"><a href="logout.php">Log Out</a></li>
    </ul>
  </div>
</nav>-->
<div style="min-height: 200px; max-height: 3000000px;">
<div class="kp"> 
<div class="row">
                 <div class="col-sm-offset-6 col-sm-2">
                 <div class="alert-danger"> <?php echo $msg;?> </div>
                 </div>
                 </div>
    <div class="container">
        <form class="form-horizontal" role="form"  action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
            <div class="form-group">
                <label class="control-label col-sm-2" for="title">New Deadline:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="title" placeholder=" New Deadline" name="new_deadline" value="<?php //echo $email;?>" required>
                </div>
            </div>
            <div class="form-group"> 
                 <div class="col-sm-offset-6 col-sm-10">
                      <button type="submit" class="btn btn-primary" name="done">Done</button>
                 </div>
            </div>
        </form>
    </div>
    </div>
    </div>
    <style>
  .center{
    text-align:center;
  }
  #footer{
    height:200px; margin:0px; padding:4em; text-align:center; background:#000000; color:#D4E6F4;
  }
</style>
<div id="footer"> Copyright, <?php echo date("Y");?></div>
<body>
</html>
<?php ob_end_flush();?>