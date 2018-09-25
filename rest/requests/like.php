<?php session_start();

require_once "../custom/func.php";
require_once "../classes/gist.php";
require_once "../classes/post.php";
require_once "../classes/category.php";
require_once "../classes/like.php";
require_once "../classes/User.php";
require_once "../classes/notification.php";

$like = new Likes();
$post = new Posts();
$user = new User();
$noti = new Notification();

$gistID = $_POST['gistID'];
// $gUserID = $_POST['gUserID'];
$sessUserID = $_POST['sessUserID'];
$postID = $_POST['postID'];
$postUserID = $_POST['postUserID'];

// print $postID.' '.$postUserID;
$likeRes = $like->addNew($postID, $sessUserID, null);

$getUser4UpdatePoints = json_decode($user->getById($sessUserID));
$updateUserPoints = $getUser4UpdatePoints->users[0]->user_points + userBonus()['like'];
$updateUserPoints = $user->updateByUserPoint($sessUserID, $updateUserPoints);

//get total amount of likes from the post table and add 1 before updating the post table.
if($likeRes == true)
    if($postUserID !== $_SESSION['id']){
        $notified = $noti->addNew($postUserID, $sessUserID, 0, $postID, 'like', 'post');
    }
    $p = json_decode($post->getById($postID));
    $pid = $p->posts[0]->likes + 1;
    
    $p = $post->updateByLikes($postID, $pid);
    if($p == true)
        print 1;
    else
        print 0;