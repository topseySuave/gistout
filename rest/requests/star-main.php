<?php session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/14/2017
 * Time: 10:58 PM
 */
require_once "/../../rest/custom/func.php";
require_once "/../../rest/classes/User.php";
require_once "/../../rest/classes/post.php";
require_once "/../../rest/classes/StarredPost.php";

    print '<div class="gist-container" style="padding: 0px;">';
        print '<ol class="breadcrumb">';
            print '<li class="breadcrumb-item"><a href="/">Home</a></li>';
            print '<li class="breadcrumb-item"><a href="#">starred</a></li>';
            print '<li class="breadcrumb-item"><a href="#">'.$_GET['guser'].'\'s starred posts</a></li>';
        print '</ol>';
    print '</div>';

$sp = new StarredPost();
$starred = json_decode($sp->getByUserId($_GET['guid']));
if(sizeof($starred->starred_post) > 0):
    //getting and looping the starred posts.....
    print '<div class="gist-container" style="padding: 0px 0px;">';
        print '<ul class="media-list media-list-users list-group" id="list-group-container">';
            $count = (sizeof($starred->starred_post) > 20)? 20: sizeof($starred->starred_post);
            for ($stars = 0; $stars < $count; $stars++)
            {
                //getting and looping the posts.....
                $post = new Posts();
                $p = json_decode($post->getById($starred->starred_post[$stars]->post_id));
                if(sizeof($p->posts) > 0)
                {
                    $counter = (sizeof($p->posts) > 20)? 20:sizeof($p->posts);
                    for ($i = 0; $i < $counter; $i++)
                    {
                        print '<li class="list-group-item notification-list-item wow slideInUp" id="list-group-'.$p->posts[$i]->id.'" style="padding-bottom: 0px;">';
                        print '<div class="media w-100">';
                        $pU = new User();
                        $u = json_decode($pU->getById($p->posts[$i]->user_id));
                        for($j= 0; $j < sizeof($u->users); $j++)
                        {
                            print '<a href="profile/'.$u->users[$j]->username.'/'.$u->users[$j]->id.'">';
                            print '<img class="media-object rounded-circle mr-3" src="/'.$u->users[$j]->user_avatar.'" style="width: 40px; height: 40px;">';
                            print '</a>';
                            print '<div class="media-body align-self-center">';
                            print '<a href="profile'.$u->users[$j]->username.'/'.$u->users[$j]->id.'">';
                            print '<strong style="margin-right: 10px; color: '.$u->users[$j]->color.';">'.$u->users[$j]->fullname.'</strong>';
                            print '<small style="color: '.$u->users[$j]->color.';">@'.$u->users[$j]->username.' - </small>';
                            print '<small style="color: '.$u->users[$j]->color.';">'.date('D d M Y', strtotime($p->posts[$i]->created)).'</small>';
                            print '</a>';

                            $sp = new StarredPost();
                            $rsp = json_decode($sp->getByPostIdAndUserId($p->posts[$i]->id, $_SESSION['id']));
                            if(sizeof($rsp->starred_post) > 0):
                                if($rsp->starred_post[0]->post_id == $p->posts[$i]->id && $rsp->starred_post[0]->user_id == $_SESSION['id']):
                                    print '<div id="gist-sd-p" class="gist-star-post" data-id="'.$p->posts[$i]->id.'" data-sess="'.$_SESSION['id'].'" data-post-user="'.$u->users[$j]->id.'" style="display: inherit !important;">';
                                    print '<i class="mdi mdi-star" style="color:  '.$u->users[$j]->color.';"></i>';
                                    print '<span class="gist-star-tip">unstar this post</span>';
                                    print '</div>';
                                else:
                                    print '<div id="gist-s-p" class="gist-star-post" data-id="'.$p->posts[$i]->id.'" data-sess="'.$_SESSION['id'].'" data-post-user="'.$u->users[$j]->id.'">';
                                    print '<i class="mdi mdi-star-outline" style="color:  '.$u->users[$j]->color.';"></i>';
                                    print '<span class="gist-star-tip">Star this post</span>';
                                    print '</div>';
                                endif;
                            else:
                                print '<div id="gist-s-p" class="gist-star-post" data-id="'.$p->posts[$i]->id.'" data-sess="'.$_SESSION['id'].'" data-post-user="'.$u->users[$j]->id.'">';
                                print '<i class="mdi mdi-star-outline" style="color:  '.$u->users[$j]->color.';"></i>';
                                print '<span class="gist-star-tip">Star this post</span>';
                                print '</div>';
                            endif;

                            if($p->posts[$i]->quotes > 0)
                            {
                                $po = new Posts();
                                $pt = json_decode($po->getByQuoteId($p->posts[$i]->quote_id));
                                for ($h = 0; $h < sizeof($pt->posts); $h++)
                                {
                                    $quser = new User();
                                    $qu = json_decode($quser->getById($pt->posts[$h]->user_id));
                                    for ($g=0; $g < sizeof($qu->users); $g++)
                                    {
                                        print '<div class="gist-container gist--max-h" style="padding: 0px; border-left: 5px solid ' . $qu->users[$g]->color . ';">';
                                        print '<ul class="media-list media-list-users list-group">';
                                        print '<li class="list-group-item notification-list-item wow slideInUp" style="border: none; padding: 10px; display: flex;">';
                                        print '<div class="media w-100">';
                                        print '<a href="#list-group-'.$pt->posts[$h]->id.'" style="display: flex;">';
                                        print '<img class="media-object rounded-circle mr-3" src="/' . $qu->users[$g]->user_avatar . '" style="width: 40px; height: 40px;">';
                                        print '<div class="media-body align-self-center">';
                                        print '<strong style="margin-right: 10px; color: ' . $qu->users[$g]->color . ';">' . $qu->users[$g]->fullname . '</strong>';
                                        print '<small style="color: ' . $qu->users[$g]->color . ';">@' . $qu->users[$g]->username . ' - </small>';
                                        print '<small style="color: ' . $qu->users[$g]->color . ';">' . date('D d M Y', strtotime($pt->posts[$h]->created)) . '</small>';
                                        print '<p style="line-height: 22px;">' . htmlspecialchars_decode(stripslashes(convertHashTag(convertMentions(nl2br($pt->posts[$h]->content))))) . '</p>';
                                        print '</div>';
                                        print '</a>';
                                        print '</div>';
                                        print '</li>';
                                        print '</ul>';
                                        print '</div><!--End quote gist-container-->';
                                    }
                                }
                            }
                            print '<div class="gist--post-content">';
                            print '<p>'.htmlspecialchars_decode(stripslashes(convertHashTag(convertMentions(nl2br($p->posts[$i]->content))))).'</p>';
                            print '</div>';

                            print '</div>';
                        }
                        print '</div>';
                        print '</li>';
                    }
                    if(sizeof($p->posts) > 20)
                    {
                        $last_id = $p->posts[$counter-1]->id;
                        print '<div class="gist-container no-margin margin-top no-shadow" id="gist-l-m" data-last-id="'.$last_id.'" data-gist="'.$gist->gists[0]->id.'">';
                            print '<p>Load More</p>';
                        print '</div><!--End Load more button -->';
                    }
                }
                else
                {
                }
            }
        print '</ul>';
    print '</div><!--End gist container-->';
else:
    print '<div class="gist-container" style="background: transparent !important; box-shadow: none; text-align: center;color: #CCC;">';
        print '<h1 style="width: 70%;margin: 10px auto;">Your starred posts is Empty</h1>';
    print '</div>';
endif;