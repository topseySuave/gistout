<?php session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 3/13/2017
 * Time: 8:59 PM
 */
?>
<?php

require_once "../../rest/custom/func.php";
require_once "../../rest/classes/notification.php";
require_once "../../rest/classes/following.php";
require_once "../../rest/classes/User.php";

$not = new Notification();

//print '<div id="" class="gist-main">';
    print '<div class="gist-container" style="padding: 0px;">';
        print '<ol class="breadcrumb">';
            print '<li class="breadcrumb-item"><a href="/">Home</a></li>';
            print '<li class="breadcrumb-item"><a href="#">Notifications</a></li>';
            print '<li class="breadcrumb-item"><a href="#">'.$_GET['guser'].'</a></li>';
        print '</ol>';
    print '</div><!--End breadcrumbs-->';

    $notify = json_decode($not->getByReceiverId($_GET['guid']));
    if(sizeof($notify->notification) > 0)
    {
        print '<div class="gist-container" id="notifyList" style="padding: 10px 0px;">';
        print '<ul class="media-list media-list-users list-group">';
        for ($noti = 0; $noti < sizeof($notify->notification); $noti++)
        {
            $sender_not = new User();
            $sender = json_decode($sender_not->getById($notify->notification[$noti]->sender_id));
            for($s = 0; $s < sizeof($sender->users); $s++)
            {
                if($_SESSION['id'] != $sender->users[$s]->id):
                    print '<li class="list-group-item notification-list-item">';
                        print '<div class="media w-100">';
                            print '<a href="profile/'.$sender->users[$s]->username.'/'.$sender->users[$s]->id.'" style="display: flex; width: 100%;">';
                                print '<img class="media-object rounded-circle mr-3" src="/'.$sender->users[$s]->user_avatar.'" style="width: 40px; height: 40px;">';
                                print '<div class="media-body align-self-center">';
                                    print '<strong style="margin-right: 10px;">'.$sender->users[$s]->fullname.'</strong>';
                                    print '<small>@'.$sender->users[$s]->username.'</small>';

                                    //GIst Notification types
                                    if($notify->notification[$noti]->notification_spec == 'gist' && $notify->notification[$noti]->notification_type == 'following')
                                    {
                                        print '<p><i class="mdi mdi-account-multiple-plus" style="color: #00b0ff; font-size: 15px; padding: 0px 5px;"></i><b>Started Following</b> your gist</p>';
                                    }
                                    elseif($notify->notification[$noti]->notification_spec == 'gist' && $notify->notification[$noti]->notification_type == 'like')
                                    {
                                        print '<p><img src="/docs/img/png/1f44d.png" class="emoji-img" alt=""/><b>Liked</b> your gist</p>';
                                    }
                                    elseif($notify->notification[$noti]->notification_spec == 'gist' && $notify->notification[$noti]->notification_type == 'share')
                                    {
                                        print '<p><img src="/docs/img/share-5.png" class="emoji-img" alt=""/><b>Shared</b> your gist</p>';
                                    }
                                    elseif ($notify->notification[$noti]->notification_spec == 'post' && $notify->notification[$noti]->notification_type == 'like')
                                    {
                                        print '<p><img src="/docs/img/png/1f44d.png" class="emoji-img" alt=""/> Liked Your Post</p>';
                                        $noti_post = new Posts();
                                        $n_p = json_decode($noti_post->getById($notify->notification[$noti]->post_id));
                                        for($p = 0; $p < sizeof($n_p->posts); $p++)
                                        {
                                            print '<div class="gist-container gist--max-h no--padding" style="border-left: 5px solid '.$user->users[0]->color.';">';
                                                print '<ul class="media-list media-list-users list-group">';
                                                    print '<li class="list-group-item notification-list-item wow bounceInRight" style="border: none; padding: 10px; display: flex;">';
                                                        print '<div class="media w-100">';
                                                            print '<a href="#" style="width: 100%;display: flex;">';
                                                                print '<img class="media-object rounded-circle mr-3" src="/'.$user->users[0]->user_avatar.'" style="width: 40px; height: 40px;">';
                                                                print '<div class="media-body align-self-center">';
                                                                    print '<strong style="margin-right: 10px; color: '.$user->users[0]->color.';">'.$user->users[0]->fullname.'</strong>';
                                                                    print '<small style="color: '.$user->users[0]->color.';">@'.$user->users[0]->username.' - </small>';
                                                                    print '<small style="color: '.$user->users[0]->color.';">'.date('D d M Y', strtotime($n_p->posts[$p]->created)).'</small>';
                                                                    print '<p style="line-height: 22px;">'.$n_p->posts[$p]->content.'</p>';
                                                                print '</div>';
                                                            print '</a>';
                                                        print '</div>';
                                                    print '</li>';
                                                print '</ul>';
                                            print '</div><!--End quote gist-container-->';
                                        }
                                    }
                                    elseif ($notify->notification[$noti]->notification_spec == 'post' && $notify->notification[$noti]->notification_type == 'share')
                                    {
                                        print '<p><img src="/docs/img/png/1f44d.png" class="emoji-img" alt=""/> Shared Your Post</p>';
                                        $noti_post = new Posts();
                                        $n_p = json_decode($noti_post->getById($notify->notification[$noti]->post_id));
                                        for($p = 0; $p < sizeof($n_p->posts); $p++)
                                        {
                                            print '<div class="gist-container" style="margin: 0px; border-left: 5px solid ' . $user->users[0]->color . ';">';
                                            print '<div class="gist-header">';

                                            $noti_user = new User();
                                            $nu = json_decode($noti_user->getById($n_p->posts[$p]->user_id));
                                            for($un = 0; $un < sizeof($nu); $un++)
                                            {
                                                print '<img src="' . $nu->users[$un]->user_avatar . '" alt="' . $nu->users[$un]->username . '" />';
                                                print '<p style="color: ' . $nu->users[$un]->color . ';">' . $nu->users[$un]->fullname . '</p>';
                                                print '<p class="gist-time-ago" style="padding-left: 0px; color: ' . $nu->users[$un]->color . ';">' . date('D d M Y', strtotime($n_p->posts[$p]->created)) . '</p>';
                                            }
                                            print '</div><!--End gist-header-->';
                                            print '<div class="gist-body gist-quoted">';
                                            print '<p>' . $n_p->posts[$p]->content . '</p>';
                                            print '</div><!--End gist-body-->';
                                            print '</div>';
                                        }
                                    }
                                    elseif($notify->notification[$noti]->notification_spec == 'post' && $notify->notification[$noti]->notification_type == 'report')
                                    {
                                        print '<p><img src="/docs/img/png/" class="emoji-img" alt=""/> Reported Your Post</p>';
                                        $noti_post = new Posts();
                                        $n_p = json_decode($noti_post->getById($notify->notification[$noti]->post_id));
                                        for($p = 0; $p < sizeof($n_p->posts); $p++)
                                        {
                                            print '<div class="gist-container" style="margin: 0px; border-left: 5px solid ' . $user->users[0]->color . ';">';
                                            print '<div class="gist-header">';

                                            $noti_user = new User();
                                            $nu = json_decode($noti_user->getById($n_p->posts[$p]->user_id));
                                            for($un = 0; $un < sizeof($nu); $un++)
                                            {
                                                print '<img src="' . $nu->users[$un]->user_avatar . '" alt="' . $nu->users[$un]->username . '" />';
                                                print '<p style="color: ' . $nu->users[$un]->color . ';">' . $nu->users[$un]->fullname . '</p>';
                                                print '<p class="gist-time-ago" style="padding-left: 0px; color: ' . $nu->users[$un]->color . ';">' . date('D d M Y', strtotime($n_p->posts[$p]->created)) . '</p>';
                                            }
                                            print '</div><!--End gist-header-->';
                                            print '<div class="gist-body gist-quoted">';
                                            print '<p>' . $n_p->posts[$p]->content . '</p>';
                                            print '</div><!--End gist-body-->';
                                            print '</div>';
                                        }
                                    }
                                    elseif($notify->notification[$noti]->notification_spec == 'user' && $notify->notification[$noti]->notification_type == 'following')
                                    {
                                        print '<p><i class="mdi mdi-account-multiple-plus" style="color: #00b0ff; font-size: 15px; padding: 0px 5px;"></i><b>Started Following</b> you</p>';
                                        $following = new Following;
                                        $getFollowedId = json_decode($following->getByFollowedAndFollowerId($_GET['guid'], $notify->notification[$noti]->sender_id));
//                                        $getFollowerId = json_decode($following->getByFollowedAndFollowerId($notify->notification[$noti]->sender_id, $_GET['guid']));
                                        if(sizeof($getFollowedId->following) > 0):
                                            if($getFollowedId->following[0]->followed_id == $notify->notification[$noti]->sender_id):
                                                print '<button class="btn btn-outline-success btn-sm float-right hover-shadow" id="following-btn" data-role="user" data-purpose="unfollow" data-sess="'.$_SESSION['id'].'" data-follow="'.$notify->notification[$noti]->sender_id.'" style="padding-right: 15px; border-radius: 25px; position: absolute; right: 10px; top: 0px;">';
                                                    print '<span id="follow-btn-icon" class="mdi mdi-account-check"></span> Following';
                                                print '</button>';
                                            else:
                                                print '<button class="btn btn-outline-primary btn-sm float-right hover-shadow" id="follow-btn" data-role="user" data-purpose="follow" data-sess="'.$_SESSION['id'].'" data-follow="'.$notify->notification[$noti]->sender_id.'" style="padding-right: 15px; border-radius: 25px; position: absolute; right: 10px; top: 0px;">';
                                                    print '<span id="follow-btn-icon" class="mdi mdi-account-plus"></span> Follow';
                                                print '</button>';
                                            endif;
                                        else:
                                            print '<button class="btn btn-outline-primary btn-sm float-right hover-shadow" id="follow-btn" data-role="user" data-purpose="accept" data-sess="'.$_SESSION['id'].'" data-follow="'.$notify->notification[$noti]->sender_id.'" style="padding-right: 15px; border-radius: 25px; position: absolute; right: 10px; top: 0px;">';
                                                print '<span id="follow-btn-icon" class="mdi mdi-account-plus"></span> Follow';
                                            print '</button>';
                                        endif;
                                    }
                                print '</div>';
                            print '</a>';
                        print '</div>';
                    print '</li>';
                else:
                endif;
            }
        }
        print '</ul>';
        print '</div><!--End gist container-->';

        print '<input type="hidden" id="utm_response"/>';
    }
    else
    {
        print '<div class="gist-container" style="background: transparent;box-shadow: none;text-align: center;color: #CCC;">';
            print '<h1 style="width: 70%;margin: 10px auto;">You have an Empty Notification...!!!</h1>';
        print '</div>';
    }
//print '</div><!--End gist main for profile-->';
