<?php

require_once "../custom/func.php";
require_once "../classes/gist.php";
require_once "../classes/post.php";
require_once "../classes/category.php";
require_once "../classes/like.php";
require_once "../classes/User.php";

$like = new Likes();
$gist = new Gists();
$user = new User();

$gistID = $_POST['gistID'];
// $gUserID = $_POST['gUserID'];
$sessUserID = $_POST['sessUserID'];
$postID = $_POST['postID'];
$postUserID = $_POST['postUserID'];

// print $postID.' '.$postUserID;
$likeRes = $like->addNew(null, $sessUserID, $gistID);
$getUser4UpdatePoints = json_decode($user->getById($sessUserID));
$updateUserPoints = $getUser4UpdatePoints->users[0]->user_points + userBonus()['like'];
$updateUserPoints = $user->updateByUserPoint($sessUserID, $updateUserPoints);
//get total amount of likes from the post table and add 1 before updating the post table.
if($likeRes == true)
    if($postUserID !== $_SESSION['id']){
        $notified = $noti->addNew($postUserID, $sessUserID, $gistID, $postID, 'like', 'post');
    }
    $g = json_decode($gist->getById($gistID));
    $pid = $g->gists[0]->likes + 1;

    $g = $gist->updateByLikes($gistID, $pid);
    // print $likeRes;
    if($g == true)
        return 1;
    else
        return 0;