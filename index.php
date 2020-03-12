<?php
session_start();
ob_start();
if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] != 1) {
    header("location: login.php");
}
 include "dbConfig.php";
 $msg = "";
 function random_string($max = 8)
 {
     $rtn = "";
     $chars = explode(" ", "a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9");
     for ($i = 0; $i < $max; $i++) {
         $rnd = array_rand($chars);
         $rtn = base64_encode(md5($chars[$rnd]));
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
$title = "";
$details =  "";
$contractor = "";
$cont_email =  "";
$cont_phone_num =  "";
$s_date ="";
$e_date =  "";
//$current_date = date("Y-m-d");
  if (isset($_POST['add'])) {
      $title = validate($_POST['title']);
      $details =  validate($_POST['details']);
      $contractor =  validate($_POST['contractor']);
      $cont_email =  validate($_POST['cont_email']);
      if (!filter_var($cont_email, FILTER_VALIDATE_EMAIL)) {
          $msg = "Invalid email format";
      } else {
          $cont_phone_num =  validate($_POST['cont_phone_num']);
          $contract_id = random_string();
          $s_date = $_POST['s_date'];
          $e_date =  $_POST['e_date'];
          $current_date = new datetime(date("d-m-Y"));
          $d1 = new datetime($s_date);
          $datetime2 = new DateTime($e_date);
          if ($d1 < $current_date) {
              $msg = "Please input correct date";
          } elseif ($d1 >= $datetime2) {
              $msg = "Please input correct dates";
          } else {
              $user_id = $_SESSION['user_id'];
              $query = "INSERT INTO contracts (`contract_id`,`title` , `details`,`start_date`, `end_date`, `user_id`,`contractor`, `contractor_email`,`contractor_phone_number`) 
      VALUES ('$contract_id','$title','$details','$s_date','$e_date', '$user_id','$contractor','$cont_email','$cont_phone_num')";
              $result = mysqli_query($db, $query);
              $query_id = mysqli_insert_id($db);
              $new_contract_id = substr($contract_id,0,3).$query_id.substr($contract_id,3,5);
              $query = "UPDATE contracts SET contract_id = '$new_contract_id' WHERE contract_id = '$contract_id'";
              $result = mysqli_query($db, $query);
              if ($result) {
                  header("location: index.php");
              }
          }
      }
  }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Home</title>
    <link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
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
    <ul class="nav navbar-right">
      <li class="btn"><a href="change_password.php">Change Password</a></li>
    </ul>
  </div>
</nav>
<div style="min-height: 650px; max-height: 3000000px;">
<div class="row">
                 <div class="col-sm-offset-6 col-sm-2">
                 <div class="alert-danger"> <?php echo $msg;?> </div>
                 </div>
                 </div>
<div class="container">
<div class="text-center">
<u><h4>ADD NEW CONTRACT</h4></u>
</div>
<form class="form-horizontal" role="form"  action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
 <div class="form-group">
    <label class="control-label col-sm-2" for="title">Title:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="title" placeholder="Contract Tile" name="title" value="<?php echo $title;?>" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="details">Details:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="details" placeholder="Contract details" name="details"  required><?php echo $details;?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="contractor">Contractor:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="contractor" placeholder="Contractor" name="contractor" required><?php echo $contractor;?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="cont_email">Contractor's Email Address:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="cont_email" placeholder="Contractor's Email Address" name="cont_email" required><?php echo $cont_email;?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="con_phone_num">Contractor's Phone Number:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="cont_phone_num" placeholder="Contractor's Phone Number" name="cont_phone_num" required><?php echo $cont_phone_num;?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="date"> Start Date:</label>
    <div class="col-sm-10"> 
      <input type="date" class="form-control" id="date" name="s_date" value="<?php echo $s_date;?>" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="date"> End Date:</label>
    <div class="col-sm-10"> 
      <input type="date" class="form-control" id="date" name="e_date" value="<?php echo $e_date;?>" required>
    </div>
  </div>
  <div class="form-group"> 
  </div>
  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary" name="add">Add</button>
    </div>
  </div>
  </div>
</form>
<div class="text-center">
<u><h3> CONTRACTS </h3></u>
<?php
$query = "SELECT * FROM contracts";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) < 1) {
    echo "<h4>No contract has been addded</h4>";
}
?>
<div class="container">
<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>S/N</th>
						<th>Event Name</th>
                        <th>Start</th>
                        <th>End</th>
						<th>Date Added</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
                     $x = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                          <?php $d1 = new datetime();
                            $datetime2 = new DateTime($row['end_date']);
                            $interval = $d1->diff($datetime2);
                            if ($d1 >= $datetime2) {
                                $class = "danger";
                            } else {
                                if ($interval->format('%R%m') <= 2) {
                                    $class = "warning";
                                } else {
                                    $class = "success";
                                    //  $msg = "      UPCOMING EVENT:\\n".$row['title']." on ".date('D', strtotime($row['start_date']))." ".$row['start_date'];
                                  //  echo "<script>";
                                  //  echo "alert('$msg')";
                                  //  echo "</script>";
                                }
                            }
                            //echo $interval->format('%R%m');
                            // print_r($interval);?>
							<tr class="<?php echo $class; ?>">
							<th><?php echo $x; ?></th>
							<th><?php echo'<a href="single_contract.php?id='.$row['contract_id'].'">'. $row['title'].'</a>'; ?></th>
							<th>
								<?php echo $row['start_date']; ?>
							</th>
                            <th>
								<?php echo $row['end_date']; ?>
							</th>
                            <th>
								<?php echo $row['date_created']; ?>
							</th>
								<th>
									<a href="<?php echo "extend_contract.php?id=".$row['contract_id']; ?>" id="">
										<i class="fa fa-trash fa-1x"></i>   Extend Deadline
									</a>
								</th>
							</tr>
					<?php
                      $x += 1;
                        }
                    ?>
				</tbody>
			</table>
		</div>
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