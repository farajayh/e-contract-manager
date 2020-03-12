<?php
ob_start();
include "dbConfig.php";
function random_string($max = 20)
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

$msg = "";

if (isset($_POST['submit'])) {
    $email = validate($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format";
    } else {
        $query = "SELECT * FROM users WHERE email ='$email'";
        // generate random verification string
        // store email, verification string and expiration date in recovery table of database
        // send recovery link to user's mail
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) > 0) {
            $verification_key = random_string();
            $exp_date = time()+(60);
            //$exp_date = time()+(60*60*24);
            $query = "INSERT INTO pass_reset (`email` , `verification_key`,`exp_date`) 
            VALUES ('$email','$verification_key','$exp_date')";
            $result = mysqli_query($db, $query);
            if($result){
                $url = "localhost/e-contract/password_recovery?key=".$verification_key;
                $to = $email;
                $subject = "Password Recover";
                $message = "Click on this link to reset your password: ".$url;
                $headers = 'From:mail@website.com'."\r\n";
                //mail($to, $subject, $message, $headers);
                $msg = "A password reset link has been sent to your email. Click the link to reset your password";
            }
        }else{
            $msg = "There is no user with the email you entered";
        }
    }
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Forgot Password</title>
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
                 <div class="col-sm-offset-6 col-sm-2">
                 <div class="alert-danger"> <?php echo $msg;?> </div>
                 </div>
                 </div>
    <div class="container">
        <form class="form-horizontal" role="form"  action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
            <div class="form-group">
                <label class="control-label col-sm-2" for="title">Email:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" placeholder="Email" name="email" required>
                </div>
            </div>
            <div class="form-group"> 
                 <div class="col-sm-offset-6 col-sm-10">
                      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                 </div>
            </div>
        </form>
    </div>
    </div>
    <div>
<body>
<style>
  .center{
    text-align:center;
  }
  #footer{
    height:100px; margin:0px; padding:4em; text-align:center; background:#000000; color:#D4E6F4;
  }
</style>
</html>
<?php ob_end_flush();?>