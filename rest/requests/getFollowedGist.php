<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/8/2017
 * Time: 12:10 PM
 */
require_once "../custom/func.php";
require_once "../classes/User.php";
require_once "../classes/gist.php";
require_once "../classes/followed-gist.php";

$user = new User();
$g = new Gists();
$fg = new FollowedGist();

if(isset($_GET)):
    $fgU = json_decode($fg->getByUserId($_GET['u']));
    print '<div class="columnHoldeFollowedGists">';
        if (sizeof($fgU->followed_gists) > 0):
            $countFollowedGist = (sizeof($fgU->followed_gists) > 20)? 20: sizeof($fgU->followed_gists);
            print '<div class="card-columns animated fadeIn" id="cardColumnFollowedGist"><!-- Start card column-->';
            for($i = 0; $i < $countFollowedGist; $i++)
            {
                $gist = json_decode($g->getById($fgU->followed_gists[$i]->gist_id));
                if(sizeof($gist->gists) > 0):
                    $countGist = (sizeof($gist->gists) > 20)? 20: sizeof($gist->gists);
                    for ($h = 0; $h < $countGist; $h++)
                    {
                        if ($gist->gists[$h]->image == '') {
                            print '<a href="gist/' . urlencode($gist->gists[$h]->id) . '">';
                            print '<div class="card"><!--Card container-->';
                            print '<div class="card-block" style="display: inline-block; width: 100%;">';
                            print '<h6 class="card-title">' . $gist->gists[$h]->title . '</h6>';

                            print '<div class="avatar-list-item" style="width: 100%; margin: 0px; box-shadow: none; border-radius: inherit; display: inline-block;">';

                            $gistUser = json_decode($user->getById($gist->gists[$h]->user_id));
                            for ($j = 0; $j < count($gistUser->users); $j++) {
                                print '<a href="profile/' . $gistUser->users[$j]->username . '/' . $gistUser->users[$j]->id . '">';
                                print '<img class="rounded-circle" src="/' . $gistUser->users[$j]->user_avatar . '" style="float: left;">';
                                print '<div class="" style="margin-left: 10px; color:' . $gistUser->users[$j]->color . '; float: left;">';
                                print '<p class="card-text" style="margin: 0px;">' . $gistUser->users[$j]->username . '</p>';

                                print '<p class="card-text" style="margin-bottom: 0px; opacity: .8;"><small>' . timeago($gist->gists[$h]->created) . '</small></p>';
                                print '</div>';
                                print '</a>';
                            }
                            print '</div>';

                            print '<div class="pull-top" style="margin-bottom: 30px;">';
                                print '<p><img src="'.thumbUpImgIcon().'">'.countFormat($gist->gists[$h]->likes).'</p>';
                                print '<p><img src="'.viewImgIcon().'">'.countFormat($gist->gists[$h]->views).'</p>';
                                print '<p><img src="'.postImgIcon().'">'.countFormat($gist->gists[$h]->posts).'</p>';
                            print '</div>';

                            //                         print '<div class="pull-center">';
                            //                             print '<code class="tag-preview">#textMyServer</code>';
                            //                             print '<code class="tag-preview">#textMyServer</code>';
                            //                             print '<code class="tag-preview">#textMyServer</code>';
                            //                         print '</div>';

                            print '</div>';
                            print '</div>';
                            print '</a><!--End Card container-->';
                        } else {
                            print '<a href="gist/' . urlencode($gist->gists[$h]->id) . '">';
                            print '<div class="card">';
                            print '<img class="card-img-top img-fluid" src="/' . $gist->gists[$h]->image . '" alt="Card image cap">';
                            print '<div class="card-block" style="display: inline-block; width: 100%;">';
                            print '<h6 class="card-title">' . $gist->gists[$h]->title . '</h6>';

                            print '<div class="avatar-list-item" style="width: 100%; margin: 0px; box-shadow: none; border-radius: inherit; display: inline-block;">';
                            $gistUser = json_decode($user->getById($gist->gists[$h]->user_id));
                            for ($j = 0; $j < count($gistUser->users); $j++) {
                                print '<a href="profile/' . $gistUser->users[$j]->username . '/' . $gistUser->users[$j]->id . '">';
                                print '<img class="rounded-circle" src="/' . $gistUser->users[$j]->user_avatar . '" style="float: left;">';
                                print '<div class="" style="margin-left: 10px; color:' . $gistUser->users[$j]->color . '; float: left;">';
                                print '<p class="card-text" style="margin: 0px;">' . $gistUser->users[$j]->username . '</p>';

                                print '<p class="card-text" style="margin-bottom: 0px; opacity: .8;"><small>' . timeago($gist->gists[$h]->created) . '</small></p>';
                                print '</div>';
                                print '</a>';
                            }
                            print '</div>';

                            print '<div class="pull-top" style="margin-bottom: 30px;">';
                                print '<p><img src="'.thumbUpImgIcon().'">'.countFormat($gist->gists[$h]->likes).'</p>';
                                print '<p><img src="'.viewImgIcon().'">'.countFormat($gist->gists[$h]->views).'</p>';
                                print '<p><img src="'.postImgIcon().'">'.countFormat($gist->gists[$h]->posts).'</p>';
                            print '</div>';

                            // print '<div class="pull-center">';
                            //     print '<code class="tag-preview">#textMyServer</code>';
                            //     print '<code class="tag-preview">#textMyServer</code>';
                            //     print '<code class="tag-preview">#textMyServer</code>';
                            // print '</div>';

                            print '</div>';
                            print '</div>';
                            print '</a><!--End Card container-->';
                        }
                    }
                endif;
            }
            print '</div>';
        else:
            print '<div class="gist-container" style="background: transparent;box-shadow: none;text-align: center;color: #CCC;">';
                print '<h1 style="width: 70%;margin: 10px auto;">You Haven\'t Followed Any Gist Yet...!!!</h1>';
            print '</div>';
        endif;
    print '</div>';
else:
    header('location: 404.html');
endif;