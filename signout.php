<?php session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/23/2017
 * Time: 10:28 PM
 */

include "rest/classes/User.php";
include "rest/classes/Session.php";
include_once 'rest/custom/func.php';

$sess = new Session();
$user = new User();

if(isset($_SESSION['id'])):
    $res = json_decode($sess->getByUserId($_SESSION['id']));
    if(sizeof($res->session) > 0){
        $res = $sess->deleteByUserId($res->session[0]->sess_id);
    }else{
        $res = true;
    }
    $onlineStatus = $user->updateByOnline($_SESSION['id'], 0);
    $lastSeen = $user->updateByLastSeen($_SESSION['id']);
    if($res):
        $_SESSION['signed_in'] = false;
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        unset($_SESSION['username']);
        unset($_SESSION['user_key']);
        session_destroy();
        $expire = time() - 60 * 60 * 24 * 30 * 12;
        setcookie('_gist', '', $expire);
        if(isset($_SESSION['id'])):
            print $_SESSION['id'];
        else:
            print 1;
        endif;
    else:
        print 0;
    endif;
endif;