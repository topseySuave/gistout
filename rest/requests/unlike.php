<?php

require_once "../custom/func.php";
require_once "../classes/gist.php";
require_once "../classes/post.php";
require_once "../classes/category.php";
require_once "../classes/like.php";

$like = new Likes();
$post = new Posts();

$gistID = $_POST['gistID'];
// $gUserID = $_POST['gUserID'];
$sessUserID = $_POST['sessUserID'];
$postID = $_POST['postID'];
$postUserID = $_POST['postUserID'];

// print $postID.' '.$postUserID;
$lik = json_decode($like->getByPostId($postID));

$likeRes = $like->deleteById($lik->like[0]->id);

//get total amount of likes from the post table and add 1 before updating the post table.
if($likeRes == true)
    $p = json_decode($post->getById($postID));
    $UpRes = $p->posts[0]->likes - 1;

//    print $p->posts[0]->likes;
    $p = $post->updateByLikes($postID, $UpRes);
    // print $likeRes;
    if($p == true)
        print '1';
    else
        print '0';