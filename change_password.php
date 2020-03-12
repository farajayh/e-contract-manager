<?php
session_start();
ob_start();
    if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] != 1) {
        header("location: login.php");
    }
$email = "";
$msg = "";
include "dbConfig.php";
function validate($data)
{
    global $db;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($db, $data);
    return $data;
}
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_pass'];
    $old_password = sha1($old_password);
    $query = "SELECT * FROM users WHERE user_id = '$user_id' AND password = '$old_password'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) < 1) {
        $msg = "Incorrect Password";
    } else {
        $new_password = $_POST['new_pass'];
        $c_password = $_POST['conf_pass'];
        if ($new_password != $c_password) {
            $msg = "Passwords do not match";
        } else {
            $new_password = sha1($new_password);
            $query = "UPDATE users SET password = '$new_password' WHERE user_id = '$user_id'";
            $result = mysqli_query($db, $query);
            if ($result) {
                header("location: index.php");
            }
        }
    }
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Change Password</title>
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
  </div>
</nav>
<div style="min-height: 650px; max-height: 3000000px;">
<div class="kp"> 
<div class="row">
                 <div class="col-sm-6 col-sm-offset-3 form-box">
                 <div class="alert-danger"> <?php echo $msg;?> </div>
                 </div>
                 </div>
    <div class="container">
        <h4 class="text-center">Change Password </h4>
        <form class="form-horizontal" role="form"  action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
            <div class="form-group">
                <label class="control-label col-sm-2" for="old_pass">Old Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="old_pass" placeholder="Old Password" name="old_pass" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="title">New Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="new_password"  placeholder="New Password" name="new_pass" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="title">Confirm New Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="conf_pass"  placeholder="Confirm Password" name="conf_pass" required>
                </div>
            </div>
            <div class="form-group"> 
                 <div class="col-sm-offset-6 col-sm-10">
                      <button type="submit" class="btn btn-primary" name="submit">Change</button>
                 </div>
            </div>
        </form>
    </div>
    </div>
    <div>
    <style>
  .center{
    text-align:center;
  }
  #footer{
    height:220px; margin:0px; padding:4em; text-align:center; background:#000000; color:#D4E6F4;
  }
</style>
<div id="footer"> Copyright, <?php echo date("Y");?> /div>
<body>
</html>
<?php ob_end_flush();?>