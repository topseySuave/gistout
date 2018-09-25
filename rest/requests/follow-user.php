<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/4/2017
 * Time: 4:07 PM
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

if($purpose == 'accept'):
//    print 'accept';
    $addNew = $f->addNew($sess, $follower);
    $getUser4UpdatePoints = json_decode($user->getById($sess));
    $updateUserPoints = $getUser4UpdatePoints->users[0]->user_points + userBonus()['follow'];
    $updateUserPoints = $user->updateByUserPoint($sess, $updateUserPoints);
    if($addNew == true):
        //should delete from notification where receiver id = session user id and sender id = followers id.....
        $getUser = json_decode($user->getById($follower)); //1
        $getCurrentUser = json_decode($user->getById($sess)); //4

        $updateUser = $getUser->users[0]->followers + 1;
        $updateCurrentUser = $getCurrentUser->users[0]->following + 1;

        $upUser = json_decode($user->updateByfollowers($follower, $updateUser));
        $upCurrentUser = json_decode($user->updateByfollowing($sess, $updateCurrentUser));

        if(($upUser && $upCurrentUser) == true):
            $addNoti = json_decode($n->addNew($follower, $sess, 0, 0, 'following', 'user'));
            if($addNoti == true):
                print 1;
            endif;
        endif;
    else:
        print 2;
    endif;
else:
//    print 'follow';
    $addNew = $f->addNew($sess, $follower);
    $getUser4UpdatePoints = json_decode($user->getById($sess));
    $updateUserPoints = $getUser4UpdatePoints->users[0]->user_points + userBonus()['follow'];
    $updateUserPoints = $user->updateByUserPoint($sess, $updateUserPoints);
    if($addNew == true):
        $getUser = json_decode($user->getById($follower));
        $getCurrentUser = json_decode($user->getById($sess));

        $updateUserFollower = $getUser->users[0]->followers + 1;
        $updateCurrentUserFollowing = $getCurrentUser->users[0]->following + 1;

        $upUser = json_decode($user->updateByfollowers($follower, $updateUserFollower));
        $upUser = json_decode($user->updateByfollowing($sess, $updateCurrentUserFollowing));

        if($upUser == true):
            $addNoti = json_decode($n->addNew($follower, $sess, 0, 0, 'following', 'user'));
            if($addNoti == true):
                print 1;
            endif;
        endif;
    else:
        print 2;
    endif;
//else:
//    $fol = json_decode($f->getByFollowedAndFollowerId($sess, $follower));
//    if(sizeof($fol->following) > 0):
//        if($fol->following[0]->followers_id == $sess):
//            $getFollower = json_decode($f->getByFollowerId($sess));
//            $delThisFollower = $f->deleteById($getFollower->following[0]->id);
//            if($delThisFollower == true):
//                print 1;
//            else:
//                print 2;
//            endif;
//        elseif($fol->following[0]->followers_id == $follower):
//            $getFollower = json_decode($f->getByFollowerId($follower));
//            $delThisFollower = $f->deleteById($getFollower->following[0]->id);
//            if($delThisFollower == true):
//                print 1;
//            else:
//                print 2;
//            endif;
//        endif;
//    endif;
endif;