<?php session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 3/13/2017
 * Time: 5:47 PM
 */
?>
<?php

require_once "../classes/trending-hashtag.php";
require_once "../classes/hashtag-posts.php";
require_once "../classes/post.php";
require_once "../classes/User.php";
require_once "../custom/func.php";
require_once "../classes/StarredPost.php";

$t = new TrendingHashtags();
$u = new User();
$post = new Posts();
$HashtagPosts = new HashtagPosts();

//print '<div id="" class="gist-main">';
    print '<div class="gist-container" style="padding: 0px;">';
        print '<ol class="breadcrumb">';
            print '<li class="breadcrumb-item"><a href="/">Home</a></li>';
            print '<li class="breadcrumb-item"><a href="#">tag</a></li>';
            print '<li class="breadcrumb-item"><a href="#">'.$_GET['gtag'].'</a></li>';
        print '</ol>';
    print '</div>';

    $tag = json_decode($t->getByhashtag($_GET['gtag']));
    if(sizeof($tag->trending_hashtag) > 0)
    {
        $count = (sizeof($tag->trending_hashtag) > 20)? 20: sizeof($tag->trending_hashtag);
        for ($e = 0; $e < $count; $e++)
        {
            $hp = json_decode($HashtagPosts->getByHashTagId($tag->trending_hashtag[$e]->id));
            $cnt = (sizeof($hp->hashtag_post) > 20)? 20: sizeof($hp->hashtag_post);
            for ($htp = 0; $htp < $cnt; $htp++)
            {
                //getting and looping the posts.....
                $p = json_decode($post->getById($hp->hashtag_post[$htp]->post_id));
                if(sizeof($p->posts) > 0)
                {
                    print '<div class="gist-container" style="padding: 10px 0px;">';
                    print '<ul class="media-list media-list-users list-group" id="list-group-container">';
                    $counter = (sizeof($p->posts) > 20)? 20:sizeof($p->posts);
                    for ($i = 0; $i < $counter; $i++)
                    {
                        print '<li class="list-group-item notification-list-item wow slideInUp" id="list-group-'.$p->posts[$i]->id.'" style="border: none; padding-bottom: 0px;">';
                        print '<div class="media w-100">';
                        $pU = new User();
                        $u = json_decode($pU->getById($p->posts[$i]->user_id));
                        for($j= 0; $j < sizeof($u->users); $j++)
                        {
                            print '<a href="profile/'.$u->users[$j]->username.'/'.$u->users[$j]->id.'">';
                            print '<img class="media-object rounded-circle mr-3" src="/'.$u->users[$j]->user_avatar.'" style="width: 40px; height: 40px;">';
                            print '</a>';
                            print '<div class="media-body align-self-center">';
                            print '<a href="profile?guser='.$u->users[$j]->username.'">';
                            print '<strong style="margin-right: 10px; color: '.$u->users[$j]->color.';">'.$u->users[$j]->fullname.'</strong>';
                            print '<small style="color: '.$u->users[$j]->color.';">@'.$u->users[$j]->username.' - </small>';
                            print '<small style="color: '.$u->users[$j]->color.';">'.date('D d M Y', strtotime($p->posts[$i]->created)).'</small>';
                            print '</a>';

                            $sp = new StarredPost();
                            $rsp = json_decode($sp->getByPostId($p->posts[$i]->id));
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
                    print '</ul>';
                    print '</div><!--End gist container-->';
                }
                else
                {
                    print '<div class="gist-container" style="background: transparent;box-shadow: none;text-align: center;color: #CCC;">';
                        print '<h1 style="width: 70%;margin: 10px auto;">There are no posts on this Gist...!!!</h1>';
                    print '</div>';
                }
            }
        }
    }
    else
    {
        print '<div class="gist-container" style="background: transparent;box-shadow: none;text-align: center;color: #CCC;">';
            print '<h1 style="width: 70%;margin: 10px auto;">There are no tags with <b>'.$_GET['gtag'].'</b></h1>';
        print '</div>';
    }
//print '</div><!--End gist container-->';
//print '<!--End gist main for profile-->';

