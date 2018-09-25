<?php session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/27/2017
 * Time: 11:01 AM
 */
require 'rest/custom/func.php';
require 'rest/classes/User.php';

$u = new User();
$arr = [];
$post_data = file_get_contents("php://input");
$arr[0] = json_decode($post_data);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
//    print $arr[0]->InputFullName;
    $bioData = test_input($arr[0]->inputBio);
    $fullname = test_input($arr[0]->InputFullName);
    $username = test_input($arr[0]->InputNickname);
    $email = test_input($arr[0]->InputEmail);
    $website = test_input($arr[0]->InputWebsite);
    $dob = test_input($arr[0]->Dob);
    $password = test_input($arr[0]->InputPassword);
    $user_id = $_SESSION['id'];
    $msg = [];

    if($username !== ''){
        $updateUsername = $u->updateByUserName($user_id, $username);
        ($updateUsername)? $msg[0] = 'Updated-Username' : $msg[0] = 1;
    }
    if($email !== '') {
        $updateEmail = $u->updateByEmail($user_id, $email);
        ($updateEmail)? $msg[1] = 'Updated-email' : $msg[1] = 2;
    }
    if ($bioData !== ''){
        $updateBioData = $u->updateByBio($user_id, $bioData);
        ($updateBioData)? $msg[2] = 'Updated-biodata' : $msg[2] = $updateBioData;
    }
    if ($fullname !== ''){
        $updateFullname = $u->updateByFullname($user_id, $fullname);
        ($updateFullname)? $msg[3] = 'Updated-fullname' : $msg[3] = 4;
    }
    if ($website !== ''){
        $updateWebsite = $u->updateByWebsite($user_id, $website);
        ($updateWebsite)? $msg[4] = 'Updated-website' : $msg[4] = 5;
    }
    if ($dob !== ''){
        $updateDob = $u->updateByDob($user_id, $dob);
        ($updateDob)? $msg[5] = 'Updated-dob' : $msg[5] = 6;
    }
    if ($password !== ''){
        $updatePassword = $u->updateByPassword($user_id, hashPassword($password));
        ($updatePassword)? $msg[6] = 'Updated-password' : $msg[6] = 7;
    }
} else {
    print 0;
}