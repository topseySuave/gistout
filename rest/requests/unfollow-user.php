<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/5/2017
 * Time: 11:04 PM
 */
require_once "../custom/func.php";
require_once "../classes/following.php";
require_once "../classes/User.php";
require_once "../classes/notification.php";

$user = new User();
$f = new Following();
$n = new Notification();

$sess = $_POST['sess'];
$follower = $_POST['follow'];
$purpose = $_POST['purpose'];

if($purpose == 'unfollow'):
    //delete from table...
//    $followedUser = json_decode($f->getByFollowedAndFollowerId($follower, $sess)); // $follower =  4 = follower and $sess = 1 = followed
    $fol = json_decode($f->getByFollowedAndFollowerId($sess, $follower)); //$sess = follower and $follower = followed
//    if($followedUser->following[0]->followers_id == $follower && $followedUser->following[0]->followed_id == $sess):
//        print 'yes';
    if($fol->following[0]->followers_id == $sess && $fol->following[0]->followed_id == $follower):
        $delete = $f->deleteById($fol->following[0]->id);
        if($delete == true):
            $getUser = json_decode($user->getById($follower));
            $getCurrentUser = json_decode($user->getById($sess));

            $updateUser = $getUser->users[0]->followers - 1;
            $updateCurrentUser = $getCurrentUser->users[0]->following - 1;

//            print $updateUser. ' ' .$updateCurrentUser . '<br>';
            $upUser = json_decode($user->updateByfollowers($follower, $updateUser));
            $upCurrentUser = json_decode($user->updateByfollowing($sess, $updateCurrentUser));

//            print $upUser. ' ' .$upCurrentUser;
            if(($upUser && $upCurrentUser) == true):
                print 1;
            else:
                print 2;
            endif;
        else:
            print 0;
        endif;
    endif;
endif;