<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 3/29/2017
 * Time: 9:54 PM
 */

require_once "../custom/func.php";
require_once "../classes/followed-gist.php";
require_once "../classes/gist.php";
require_once "../classes/User.php";
require_once "../classes/notification.php";

$gist = new Gists();
$user = new User();
$fg = new FollowedGist();
$n = new Notification();

$gist_id = $_POST['gistId'];
$sess = $_POST['sess'];
$gistUser = $_POST['gistUser'];
$followers = $_POST['followers'];

$addNew = $fg->addNew($gist_id, $gistUser, $sess);
$getUser4UpdatePoints = json_decode($user->getById($sess));
$updateUserPoints = $getUser4UpdatePoints->users[0]->user_points + userBonus()['follow'];
$updateUserPoints = $user->updateByUserPoint($sess, $updateUserPoints);

//print $addNew;
if($addNew == true)
{
    $newFollowers = $followers + 1;
    $upDate = $gist->updateByFollowers($gist_id, $newFollowers);

    $addNoti = $n->addNew($gistUser, $sess, $gist_id, 0, 'following', 'gist');
    if($addNoti == true)
        print 1;
    else
        print 0;
}
else
{
    print 2;
}