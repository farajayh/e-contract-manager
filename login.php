<?php
session_start();
ob_start();
$email = "";
$msg = "";
include "dbConfig.php";
if (isset($_SESSION['logged_in'])) {
    $user_id =  $_SESSION['user_id'];
    header("location: index.php");
}

function validate($data)
{
    global $db;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($db, $data);
    return $data;
}
if (isset($_POST['login'])) {
    if (isset($_POST['email']) and isset($_POST['password'])) {
        $email = $_POST['email'];
        $email = validate($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Invalid email format";
        } else {
            $password = validate($_POST['password']);
            $password = sha1($password);
            $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
            $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result);
                if ($row['status'] == "pending") {
                    $msg = "You need to verify your account first";
                } else {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['logged_in'] = 1;
                    header("location: index.php");
                }
            } else {
                $msg = "Incorrect Login Details";
            }
        }
    }
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login</title>
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
<div style="min-height: 200px; max-height: 3000000px;">
<div class="kp"> 
<div class="row">
                 <div class="col-sm-6 col-sm-offset-3 form-box">
                 <div class="alert-danger"> <?php echo $msg;?> </div>
                 </div>
                 </div>
    <div class="container">
        <form class="form-horizontal" role="form"  action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
            <div class="form-group">
                <label class="control-label col-sm-2" for="title">Email:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" placeholder="Email" name="email" value="<?php echo $email;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="title">Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password"  placeholder="password" name="password" required>
                </div>
            </div>
            <div class="form-group"> 
                 <div class="col-sm-offset-6 col-sm-6">
                      <button type="submit" class="btn btn-primary" name="login">Login</button>
                 </div>
            </div>
        </form>
        <a href="register.php">Create an account</a>
        </br>
        <a href="forgot_password.php">Forgot password?</a>
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