<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 3/28/2017
 * Time: 12:09 AM
 */
session_start();

require_once "../custom/func.php";
require_once "../classes/quote.php";
require_once "../classes/gist.php";
require_once "../classes/User.php";
require_once "../classes/post.php";
require_once "../classes/like.php";

$post = new Posts();
$gist = new Gists();
$quote = new Quotes();

$postID = $_POST['last_id'];
$gist_id = $_POST['gist_id'];

$p = json_decode($post->getByIdGrt($gist_id, $postID));
$newGistForUpdate = json_decode($gist->getById($gist_id));
if(sizeof($p->posts) > 0)
{
    $counter = (sizeof($p->posts) > 20)? 20:sizeof($p->posts);
    for($i = 0; $i < $counter; $i++)
    {
        print '<li class="list-group-item notification-list-item wow slideInUp" id="list-group-' . $p->posts[$i]->id . '" style="padding-bottom: 0px;">';
            print '<div class="media w-100">';
            $pU = new User();
            $u = json_decode($pU->getById($p->posts[$i]->user_id));
            for ($j = 0; $j < sizeof($u->users); $j++) {
                print '<a href="profile/' . $u->users[$j]->username . '/' . $u->users[$j]->id . '">';
                    print '<img class="media-object rounded-circle mr-3" src="/' . $u->users[$j]->user_avatar . '" style="width: 40px; height: 40px;">';
                    print '<div class="media-body align-self-center">';
                        print '<strong style="margin-right: 10px; color: ' . $u->users[$j]->color . ';">' . $u->users[$j]->fullname . '</strong>';
                        print '<small style="color: ' . $u->users[$j]->color . ';">@' . $u->users[$j]->username . ' - </small>';
                        print '<small style="color: ' . $u->users[$j]->color . ';">' . date('D d M Y', strtotime($p->posts[$i]->created)) . '</small>';
                print '</a>';
                print '<div id="gist-s-p" class="gist-star-post">';
                    print '<i class="mdi mdi-star-outline" style="color:  ' . $u->users[$j]->color . ';"></i>';
                    print '<span class="gist-star-tip">Star this post</span>';
                print '</div>';
                
                    $sp = new StarredPost();
                    $rsp = json_decode($sp->getByPostIdAndUserId($p->posts[$i]->id, $_SESSION['id']));
                    if(sizeof($rsp->starred_post) > 0):
                        if($rsp->starred_post[0]->post_id == $p->posts[$i]->id && $rsp->starred_post[0]->user_id == $_SESSION['id']):
                            print '<div id="gist-sd-p" class="gist-star-post" data-id="'.$p->posts[$i]->id.'" data-sess="'.$_SESSION['id'].'" data-post-user="'.$p->posts[$i]->user_id.'" style="display: inherit !important;">';
                                print '<i class="mdi mdi-star" style="color:  '.$u->users[$j]->color.';"></i>';
                                print '<span class="gist-star-tip">unstar this post</span>';
                            print '</div>';
                        else:
                            print '<div id="gist-s-p" class="gist-star-post" data-id="'.$p->posts[$i]->id.'" data-sess="'.$_SESSION['id'].'" data-post-user="'.$p->posts[$i]->user_id.'">';
                                print '<i class="mdi mdi-star-outline" style="color:  '.$u->users[$j]->color.';"></i>';
                                print '<span class="gist-star-tip">Star this post</span>';
                            print '</div>';
                        endif;
                    else:
                        print '<div id="gist-s-p" class="gist-star-post" data-id="'.$p->posts[$i]->id.'" data-sess="'.$_SESSION['id'].'" data-post-user="'.$p->posts[$i]->user_id.'">';
                            print '<i class="mdi mdi-star-outline" style="color:  '.$u->users[$j]->color.';"></i>';
                            print '<span class="gist-star-tip">Star this post</span>';
                        print '</div>';
                    endif;
            }
            if ($p->posts[$i]->quotes > 0) {
                $po = new Posts();
                $pt = json_decode($po->getByQuoteId($p->posts[$i]->quote_id));
                for ($h = 0; $h < sizeof($pt->posts); $h++) {
                    $quser = new User();
                    $qu = json_decode($quser->getById($pt->posts[$h]->user_id));
                    for ($g = 0; $g < sizeof($qu->users); $g++) {
                        print '<div class="gist-container gist--max-h" style="padding: 0px; border-left: 5px solid ' . $qu->users[$g]->color . ';">';
                            print '<ul class="media-list media-list-users list-group">';
                                print '<li class="list-group-item notification-list-item wow slideInUp" style="border: none; padding: 10px; display: flex;">';
                                    print '<div class="media w-100">';
                                        print '<a href="#list-group-' . $pt->posts[$h]->id . '" style="display: flex;">';
                                            print '<img class="media-object rounded-circle mr-3" src="/' . $qu->users[$g]->user_avatar . '" style="width: 40px; height: 40px;">';
                                            print '<div class="media-body align-self-center">';
                                                print '<strong style="margin-right: 10px; color: ' . $qu->users[$g]->color . ';">' . $qu->users[$g]->fullname . '</strong>';
                                                print '<small style="color: ' . $qu->users[$g]->color . ';">@' . $qu->users[$g]->username . ' - </small>';
                                                print '<small style="color: ' . $qu->users[$g]->color . ';">' . date('D d M Y', strtotime($pt->posts[$h]->created)) . '</small>';
                                                $postContent = htmlspecialchars_decode(stripslashes(convertHashTag(convertMentions(nl2br(link_it($pt->posts[$h]->content))))));
                                                print '<p style="line-height: 22px;">' . $postContent . '</p>';
                                            print '</div>';
                                        print '</a>';
                                    print '</div>';
                                print '</li>';
                            print '</ul>';
                        print '</div><!--End quote gist-container-->';
                    }
                }
                //                        }
            }
            print '<div class="gist--post-content">';
                        $postContent = htmlspecialchars_decode(stripslashes(convertHashTag(convertMentions(nl2br(link_it($p->posts[$i]->content))))));
                        print '<p id="postContent">'.$postContent.'</p>';
                        print '<div class="urlive-container">';
                        print '</div>';
            print '</div>';

            print '<div class="gist-footer">';
                print '<div class="mob-view-info">';
                print '<div class="gist like-holder">';
                    print '<p class="mob-view" id="count-like"><span style="margin-right: 5px;">' . $p->posts[$i]->likes . '</span>Liked</p>';
                print '</div>';
                print '<p class="mob-view bull">&bull;</p>';
                print '<div class="gist like-holder mob-view">';
                    print '<p class="mob-view"><span style="margin-right: 5px;">' . $p->posts[$i]->shares . '</span>Shares</p>';
                print '</div>';
            print '</div><!--End mobile view-->';
            print '<div class="gist like-holder">';
                print '<p class="count-info" id="count-like">' . $p->posts[$i]->likes . '</p>';
                $l = new Likes();
                $jl = json_decode($l->getByUserAndPostId($p->posts[$i]->id, $_SESSION['id']));
                if (sizeof($jl->like) == 0) {
                    print '<button class="btn btn-outline-primary btn-sm float-right" data-post-user-id="' . $p->posts[$i]->user_id . '" data-post-id="' . $p->posts[$i]->id . '" data-sess-user-id="' . $_SESSION['id'] . '" data-user-id="' . $newGistForUpdate->gists[0]->user_id . '" data-gist-id="" id="like-btn" style="border-radius: 25px;"><i class="mdi mdi-thumb-up"></i> Likes</button>';
                } else {
                    if ($p->posts[$i]->id == $jl->like[0]->post_id)
                        print '<button class="btn btn-outline-success btn-sm float-right" data-post-user-id="' . $p->posts[$i]->user_id . '" data-post-id="' . $p->posts[$i]->id . '"  data-sess-user-id="' . $_SESSION['id'] . '" data-user-id="' . $newGistForUpdate->gists[0]->user_id . '" data-gist-id="" id="liked-btn" style="border-radius: 25px;"><i class="mdi mdi-thumb-up"></i> Liked</button>';
                    else
                        print '<button class="btn btn-outline-primary btn-sm float-right" data-post-user-id="' . $p->posts[$i]->user_id . '" data-post-id="' . $p->posts[$i]->id . '"  data-sess-user-id="' . $_SESSION['id'] . '" data-user-id="' . $newGistForUpdate->gists[0]->user_id . '" data-gist-id="" id="like-btn" style="border-radius: 25px;"><i class="mdi mdi-thumb-up"></i> Likes</button>';
                }
            print '</div>';

            print '<span class="bull">&bull;</span>';

            print '<div class="gist like-holder">';
                            print '<p class="count-info">'.countFormat($p->posts[$i]->shares).'</p>';
                            print '<div class="btn-group">';
                                print '<button class="btn btn-outline-danger btn-sm float-right dropdown-toggle" data-toggle="dropdown" id="share-btn" style="border-radius: 25px;"><i class="mdi mdi-share-variant"></i> share</button>';
                                print '<ul class="dropdown-menu" role="menu">';
                                    print '<li><a href="http://www.facebook.com/sharer.php?u='.urldecode('www.gistout.com/gist?gist='.$gist->gists[0]->id.'#list-group-'.$p->posts[$i]->id).'" target="_blank"><i class="mdi mdi-facebook brand-primary"></i> Facebook</a></li>';
                                    print '<li><a href="#" target="_blank"><i class="mdi mdi-twitter brand-info"></i> Twitter</a></li>';
                                    print '<li><a href="#" target="_blank"><i class="mdi mdi-google brand-danger"></i> Google</a></li>';
                                print '</ul>';
                            print '</div>';
                        print '</div>';

            print '<span class="bull">&bull;</span>';

            print '<div class="gist like-holder">';
                print '<p></p>';
                print '<button id="quote" class="btn btn-outline-success btn-sm float-right role" data-gist-id="' . $newGistForUpdate->gists[0]->id . '" data-purpose="' . $p->posts[$i]->id . '" data-purposeful="' . $p->posts[$i]->user_id . '" data-sess="' . $_SESSION['id'] . '" data-toggle="modal" data-target=".bs-example-modal-lg" data-modal-role="quote" style="border-radius: 25px; margin-bottom: -3px;">';
                print '<i class="mdi mdi-format-quote"></i> Quote';
                print '</button>';
            print '</div>';

            print '<span class="bull">&bull;</span>';

            if ($p->posts[$i]->user_id != $_SESSION['id']) {
                print '<div class="gist like-holder">';
                    print '<p></p>';
                    print '<div class="btn-group">';
                        print '<button class="btn btn-outline-warning btn-sm float-right dropdown-toggle" data-toggle="dropdown" id="report-btn" style="border-radius: 25px; margin-bottom: -3px;">';
                        print 'Report';
                        print '</button>';
                        print '<ul class="dropdown-menu" role="menu" data-p-Id="" data-sess="' . $_SESSION['id'] . '">';
                            print '<li><a href="#_=_" data-case="inappropriate" id="case--inappropriate"><i class="mdi mdi-flag-outline-variant"></i> This is inappropriate</a></li>';
                            print '<li><a href="#_=_" data-case="spam" id="case--spam"><i class="mdi mdi-alert-outline"></i> it\'s Spam</a></li>';
                            print '<li><a href="#_=_" data-case="insult" id="case--insult"><i class="mdi mdi-alert-circle-outline"></i> Insult</a></li>';
                            print '<li class="dropdown-divider"></li>';
                            print '<li><a href="#_=_" data-case="copy-link" id="case--copy-link"><i class="mdi mdi-content-copy"></i> Copy Link</a></li>';
                        print '</ul>';
                    print '</div>';
                print '</div>';
            } else {
                print '<div class="gist like-holder">';
                    print '<p></p>';
                    print '<button class="btn btn-outline-info btn-sm float-right" id="edit-btn" style="border-radius: 25px; margin-bottom: -3px;">';
                        print '<i class="mdi mdi-pencil"></i> Edit';
                    print '</button>';
                print '</div>';
            }

            print '</div><!--End gist-footer-->';
            print '</div>';
            print '</div>';
        print '</li>';
    }
    if(sizeof($p->posts) > 20)
    {
        $last_id = $p->posts[$i]->id - 1;
        print '</ul>';
        print '<div class="gist-container no-margin margin-top no-shadow" id="gist-l-m" data-area="posts" data-last-id="'.$last_id.'" data-gist="'.$gist_id.'">';
            print '<p>Load More</p>';
        print '</div><!--End Load more button -->';
        print '<ul>';
    }
}
else
{
    print 'No More Posts.';
}