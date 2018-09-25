<?php

require_once "../custom/func.php";
require_once "../classes/gist.php";
require_once "../classes/post.php";
require_once "../classes/category.php";
require_once "../classes/like.php";

$like = new Likes();
$gist = new Gists();

$gistID = $_POST['gistID'];
// $gUserID = $_POST['gUserID'];
$sessUserID = $_POST['sessUserID'];
$postID = $_POST['postID'];
$postUserID = $_POST['postUserID'];

// print $postID.' '.$postUserID;
$lik = json_decode($like->getByGistId($gistID));

$likeRes = $like->deleteById($lik->like[0]->id);

//get total amount of likes from the post table and add 1 before updating the post table.
if($likeRes == true)
    $p = json_decode($gist->getById($gistID));
    $UpRes = $p->gists[0]->likes - 1;

//        print $p->gists[0]->likes;
    $p = $gist->updateByLikes($gistID, $UpRes);
    // print $likeRes;
    if($p == true)
        print '1';
    else
        print '0';