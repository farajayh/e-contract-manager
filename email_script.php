<?php
include "dbConfig.php";
$query = "SELECT * FROM contracts";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row['user_id'];
    $query2 = "SELECT * FROM users WHERE user_id='$user_id'";
    $result2 = mysqli_query($db, $query2);
    $row2 = mysqli_fetch_assoc($result2);
    $user_email = $row2['email'];
    $d1 = new datetime();
    $datetime2 = new DateTime($row['end_date']);
    $interval = $d1->diff($datetime2);
    if ($interval->format('%R%m') == 2) {
        if ($row['mail_status'] == 0) {
            //send mail
            $to = $row['contractor_email'];
            $subject = "Contract Reminder";
            $message = "You have two months to the deadline on the contract you are handling for Lagos State University\n Contract: {$row['title']}";
            $headers = 'From:mail@website.com'."\r\n";
            mail($to, $subject, $message, $headers);
            $to = $user_email;
            $subject = "Contract Reminder";
            $message = "You have two months to the deadline on the contract you gave to {$row['contractor']}\n Contract: {$row['title']}";
            $headers = 'From:mail@website.com'."\r\n";
            mail($to, $subject, $message, $headers);
            //update mail status to 1
            $contract_id = $row['contract_id'];
            $update_query = "UPDATE contracts SET mail_status = '1' WHERE contract_id = '$contract_id'";
            $update_result = mysqli_query($db, $update_query);
        }
    } else {
        if ($interval->format('%R%m') == 1) {
            if ($row['mail_status'] != 2) {
                //send mail
                $to = $row['contractor_email'];
                $subject = "Contract Reminder";
                $message = "You have one month to the deadline on the contract you are handling for Lagos State University\n Contract: {$row['title']}";
                $headers = 'From:mail@website.com'."\r\n";
                mail($to, $subject, $message, $headers);
                $to = $user_email;
                $subject = "Contract Reminder";
                $message = "You have one month to the deadline on the contract you gave to {$row['contractor']}\n Contract: {$row['title']}";
                $headers = 'From:mail@website.com'."\r\n";
                mail($to, $subject, $message, $headers);
                //update mail status to 2
                $contract_id = $row['contract_id'];
                $update_query = "UPDATE contracts SET mail_status = '2' WHERE contract_id = '$contract_id'";
                $update_result = mysqli_query($db, $update_query);
            }
        }
    }
}
