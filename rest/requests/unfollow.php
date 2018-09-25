<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 3/31/2017
 * Time: 2:46 PM
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

$gisID = json_decode($fg->getByGistId($gist_id));
$del = $fg->deleteById($gisID->followed_gists[0]->id);

//print $addNew;
if($del == true)
{
    $newFollowers = $followers - 1;
    $upDate = $gist->updateByFollowers($gist_id, $newFollowers);

    $notyGistId = json_decode($n->getByGistId($gist_id));
    $addNoti = $n->deleteById($notyGistId->notification[0]->id);
    if($addNoti == true)
        print 1;
    else
        print 0;
}
else
{
    print 2;
}
