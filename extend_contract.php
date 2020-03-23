<?php
ob_start();
session_start();

//check if user is logged in
if(!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] != 1)
{
  header("location: login.php");
}

//include database and project object files
require "config/db_connection.php";
require "projects/project.php";
require "users/users.php";

//initialise the database
$database = new Database();
$db = $database->get_conn();

//initialise project and user objects
$project = new Project($db);
$user = new User($db);

$id = $_GET['id'];
$msg = "";

$project->contract_id = $id;

$result = $project->view_one();

if ($result->rowCount() < 1) {
  $msg = "The project does not exist";
  header("location: index.php");
}

$row = $result->fetch(PDO::FETCH_ASSOC);
$prev_deadline = $row['end_date'];

if (isset($_POST['done'])) {
    $new_deadline = $_POST['new_deadline'];
    if ($new_deadline > $prev_deadline) {
        $project->end_date = $new_deadline;
        $user->user_id =  $_SESSION['user_id'];
        $user_result = $user->get_user();
        $row = $user_result->fetch(PDO::FETCH_ASSOC);
        $name = $row['surname']." ".$row['first_name'];
        $project->last_modified_by = $name;  
        if ($project->extend()) {
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
<body>
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