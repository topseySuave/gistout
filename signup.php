<?php session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/23/2017
 * Time: 2:46 PM
 */

require_once 'rest/classes/User.php';
require_once 'rest/custom/func.php';
require_once 'rest/classes/Session.php';

$user = new User();
$sess = new Session();

$randomAvatar = 'https://api.adorable.io/avatars/450/gabriel-ogechukwu-micah@adorable.png';

if($_SERVER["REQUEST_METHOD"] == 'POST'):
    $name = test_input($_POST["name"]);
    $username = test_input($_POST["username"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $confirmPassword = test_input($_POST["confirmPassword"]);
    $acceptTerms = test_input($_POST["acceptTerms"]);

    //First of Check if username or email exists before proceeding
    $usernameExist = json_decode($user->getByUserName($username));
    $emailExist = json_decode($user->getByEmail($email));
    if(sizeof($usernameExist->users) > 0):
        print 2; // username exist already
    elseif(sizeof($emailExist->users) > 0):
        print 3; // email exist already
    else:
        $addUser = $user->addNew(randomKey(), $name, $email, $username, hashPassword($password), hashString($email), randColor(), defaultImage($username));
        if($addUser):
//            $to = $email;
//            $subject="Email verification";
//            $body='Hi, <br/> <br/> We need to make sure you are human. Please verify your email and get started using this link. <br/> <br/> <a href="https://gistout.com/activation?email='.$email.'&activation_key='.hashString($email).'">https://gistout.com/activation?email='.$email.'&activation_key='.hashString($email).'</a>';
//            $header = "From: noreply@gistout.com\r\n";
//            $header.= "MIME-Version: 1.0\r\n";
//            $header.= "Content-Type: text/html; charset=UTF-8\r\n";
//            $header.= "X-Priority: 1\r\n";
//
//            $mailed = mail($to, $subject, $body, $header);
            $userExist = json_decode($user->getById($addUser));
            //set the $_SESSION['signed_in'] variable to TRUE
            $_SESSION['signed_in'] = true;
            //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
            $_SESSION['id'] = $userExist->users[0]->id;
            $_SESSION['email'] = $userExist->users[0]->email;
            $_SESSION['username'] = $userExist->users[0]->username;
            $_SESSION['user_key'] = $userExist->users[0]->user_key;
            $updateUserPoints = $userExist->users[0]->user_points + userBonus()['register'];
            $onlineStatus = $user->updateByOnline($userExist->users[0]->id, 1);
            $updateUserPoints = $user->updateByUserPoint($sess, $updateUserPoints);
            print 1;
        else:
            print 0;
        endif;
    endif;
else:
endif;