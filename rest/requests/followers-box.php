<?php session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/3/2017
 * Time: 11:01 PM
 */
require_once "/../../rest/custom/func.php";
require_once "/../../rest/classes/following.php";
require_once "/../../rest/classes/User.php";

$uF = new Following();

//print '<div class="gist-main">';

    print '<div class="gist-container" style="padding: 0px;">';
        print '<ol class="breadcrumb">';
            print '<li class="breadcrumb-item"><a href="/">Home</a></li>';
            print '<li class="breadcrumb-item"><a href="profile?guser='.$_GET['guid'].'">'.$_GET['guser'].'</a></li>';
            print '<li class="breadcrumb-item"><a href="#">followers</a></li>';
        print '</ol>';
    print '</div>';

    $uFJson = json_decode($uF->getByFollowedId($_GET['guid']));
    if(sizeof($uFJson->following) > 0):
        print '<ul class="gist-container media-list media-list-users list-group no--padding">';
            $counter = (sizeof($uFJson->following) > 20)? 20:sizeof($uFJson->following);
            for ($i = 0; $i < $counter; $i++)
            {
                $u = new User();
                $userJson = json_decode($u->getById($uFJson->following[$i]->followers_id));
                for($j = 0; $j < sizeof($userJson->users); $j++)
                {
                    print '<li class="list-group-item">';
                        print '<div class="media w-100">';
                            print '<a href="/profile/'.$userJson->users[$j]->username.'/'.$userJson->users[$j]->id.'" style="display: inline-flex; width: 100%;">';
                                print '<img class="media-object rounded-circle mr-3" src="/'.$userJson->users[$j]->user_avatar.'" style="width: 40px; height: 40px;">';
                                print '<div class="media-body align-self-center">';
                                    print '<strong>'.$userJson->users[$j]->fullname.'</strong><br />';
                                    print '<small>@'.$userJson->users[$j]->username.'</small>';
                                print '</div>';
                            print '</a>';

                            $getFollowedId = json_decode($uF->getByFollowedAndFollowerId($_GET['guid'], $userJson->users[$j]->id));
                            if(sizeof($getFollowedId->following) > 0):
                                if($uFJson->following[$i]->followers_id === $userJson->users[$j]->id):
                                    print '<button class="btn btn-outline-success btn-sm float-right hover-shadow" id="following-btn" data-role="user" data-purpose="unfollow" data-sess="'.$_SESSION['id'].'" data-follow="'.$userJson->users[$j]->id.'" style="padding-right: 15px; border-radius: 25px;">';
                                        print '<span id="follow-btn-icon" class="mdi mdi-account-check"></span> Following';
                                    print '</button>';
                                else:
                                    print '<button class="btn btn-outline-primary btn-sm float-right hover-shadow" id="follow-btn" data-role="user" data-purpose="follow" data-sess="'.$_SESSION['id'].'" data-follow="'.$userJson->users[$j]->id.'" style="padding-right: 15px; border-radius: 25px;">';
                                        print '<span id="follow-btn-icon" class="mdi mdi-account-plus"></span> Follow';
                                    print '</button>';
                                endif;
                            else:
                                print '<button class="btn btn-outline-primary btn-sm float-right hover-shadow" id="follow-btn" data-role="user" data-purpose="accept" data-sess="'.$_SESSION['id'].'" data-follow="'.$userJson->users[$j]->id.'" style="padding-right: 15px; border-radius: 25px;">';
                                    print '<span id="follow-btn-icon" class="mdi mdi-account-plus"></span> Follow';
                                print '</button>';
                            endif;
                        print '</div>';
                    print '</li>';
                }
            }
        print '</ul>';
    else:
        print '<div class="gist-container" style="background: transparent;box-shadow: none;text-align: center;color: #CCC;">';
            print '<h1 style="width: 70%;margin: 10px auto;">You have no followers yet...!!!</h1>';
        print '</div>';
    endif;
//print '</div>';