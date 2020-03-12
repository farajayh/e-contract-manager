<?php
session_start();
ob_start();
include "dbConfig.php";
$msg = "";
$class = "";
$surname = "";
$firstname = "";
$middlename = "";
$email = "";
$staff_id = "";
$phone_num = "";
$dept = "";
function random_string($max = 8)
{
    $rtn = "";
    $chars = explode(" ", "a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9");
    for ($i = 0; $i < $max; $i++) {
        $rnd = array_rand($chars);
        $rtn .= base64_encode(md5($chars[$rnd]));
    }
    return substr(str_shuffle(strtolower($rtn)), 0, $max);
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
if (isset($_POST['register'])) {
    $surname = validate($_POST['surname']);
    $firstname = validate($_POST['firstname']);
    $middlename = validate($_POST['middlename']);
    $email =  validate($_POST['email']);
    $staff_id = validate($_POST['staff_id']);
    $phone_num = validate($_POST['phone_num']);
    $user_id = mysqli_insert_id($db).random_string();
    //$phone_num = FILTER_SANITIZE_NUM_INT($phone_num);
    $dept = validate($_POST['dept']);
    $password = validate($_POST['password']);
    $c_password = validate($_POST['c_password']);
    $status = "pending";
    $key = random_string();
    $to = $email;
    $subject = "Account Verification";
    $message = "click on the link below to verify your account\n"; 
    $message .= urldecode("http://website.com/account_verification.php?email='$email'&key='$key'");
    $headers = 'From:mail@website.com'."\r\n";
    if ($password != $c_password) {
        $msg = "Passwords do not match";
    } else {
        $password = sha1($password);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Invalid email format";
            $class = "alert-danger";
        } else {
            $query = "SELECT * from users WHERE email = '$email'";
            $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) > 0) {
                $msg = "A user with that email already exist";
            } else {
                $query = "INSERT INTO users (`user_id`,`staff_id`,`first_name`,`middle_name` , `surname`, `department`,`phone_num`,`email`,`password`,`status`,`verification_code`) 
    VALUES ('$user_id','$staff_id','$firstname','$middlename','$surname', '$dept','$phone_num','$email','$password','$status','$key')";
                $result = mysqli_query($db, $query);
                if ($result) {
                    mail($to, $subject, $message, $headers);
                    $msg = "Registeration successful, an email has been sent to you. Click on the link to verify your account.";
                    $class = "alert-success";
                } else {
                    print_r(mysqli_error_list($db));
                }
            }
        }
    }
}
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Register</title>
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
<div class="text-center"> <h4>Create an Account</h4>
<div class="row">
                 <div class="col-sm-offset-6 col-sm-2">
                 <div class="<?php echo $class;?>"> <?php echo $msg;?> </div>
                 </div>
                 </div>
    <div class="container">
        <form class="form-horizontal" role="form"  action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
            <div class="form-group">
                <label class="control-label col-sm-2" for="tit">Surname:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="surnmae" placeholder="surname" name="surname" value="<?php echo $surname;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="firstname">First Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="firstname" placeholder="First Name" name="firstname" value="<?php echo $firstname;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="middlename">Middle Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="middlename" placeholder="Middle Name" name="middlename" value="<?php echo $middlename;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $email;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="staff_id">Staff ID:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="staff_id" placeholder="Staff ID" name="staff_id" value="<?php echo $staff_id;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="phone_num">Phone Number:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="phone_num" placeholder="Phone Number" name="phone_num"  value="<?php echo $phone_num;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="dept">Department:</label>
                <div class="col-sm-10">
                <select class="form-control" id="dept" name="dept">
                    <option>Registry</option>
                    <option>Legal</option>
                </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="password">Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="c_password">Confirm Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="c_password" placeholder="Password" name="c_password" required>
                </div>
            </div>
            <div class="form-group"> 
                 <div class="col-sm-offset-1 col-sm-10">
                      <button type="submit" class="btn btn-primary" name="register">Register</button>
                 </div>
            </div>
        </form>
    </div>
    </div>
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