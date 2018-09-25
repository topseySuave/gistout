<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/18/2017
 * Time: 3:16 PM
 */

require_once "/../custom/func.php";
require_once "/../classes/post.php";
require_once "/../classes/gist.php";
require_once "/../classes/User.php";
require_once "/../classes/category.php";
require_once "/../classes/trending-hashtag.php";
require_once "/../classes/StarredPost.php";
require_once "/../classes/following.php";

$g = new Gists();
$user = new User();
$post = new Posts();
$n = new TrendingHashtags();
$uF = new Following();

$userJson = $user->getUserLike($_GET['q']);
//if(sizeof($userJson->users) > 0):
    print $userJson->users[0]->id;
//else:
//    print 'No result found for '.$_GET['q'];
//endif;

$trht = $n->getByhashtagLike($_GET['q']);
//if(sizeof($trht->trending_hashtag) > 0):
    print $trht->trending_hashtag[0]->hashtag;
//else:
//    print 'No result found for '.$_GET['q'];
//endif;