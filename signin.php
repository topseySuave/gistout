<?php session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/23/2017
 * Time: 2:42 PM
 */
require_once 'rest/classes/User.php';
require_once 'rest/classes/Session.php';
require_once 'rest/custom/func.php';

$user = new User();
$s = new Session();

if($_SERVER["REQUEST_METHOD"] == 'POST'):
    $username = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    if(isset($_POST['remember']) && $_POST['remember'] == 'on'):
        $remember = true;
    else:
        $remember = false;
    endif;
    $userExits = json_decode($user->getByEmailAndPassword($username, hashPassword($password)));
    if(sizeof($userExits->users) > 0 && $userExits->users[0]->email == $username):
        //set the $_SESSION['signed_in'] variable to TRUE
        $_SESSION['signed_in'] = true;
        //we also put the user_id and user_name values in the $_SESSION, so we can use it at various page
        $_SESSION['id'] = $userExits->users[0]->id;
        $_SESSION['email'] = $userExits->users[0]->email;
        $_SESSION['username'] = $userExits->users[0]->username;
        $_SESSION['user_key'] = $userExits->users[0]->user_key;
        $onlineStatus = $user->updateByOnline($userExits->users[0]->id, 1);
        if($remember):
            require_once 'rest/classes/Session.php';
            $s = new Session();
            $salt = 'gIsTDa4CkouT';
            $token = sha1($salt . sha1($_SESSION['id'] . $salt));
            $key = sha1(uniqid(rand()));
            $expire = time() + 60 * 60 * 24 * 30 * 12;
            setcookie('_gist', "$token:$key", $expire, '/');
            //Insert the session data to the user table for auto login access
            $addSession = $s->addNew($_SESSION['id'], $key, $token, $expire);
            if($addSession):
                print 3;// login was successful.
            else:
                print 4; // cookie settings was unsuccessful.
            endif;
        else:
             print 1; // login was successful.
        endif;
    else:
        print 0; // user exists.
    endif;
else:
    print 2; // invalid request.
endif;