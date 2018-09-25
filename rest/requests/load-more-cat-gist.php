<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/9/2017
 * Time: 6:41 PM
 */
session_start();

require_once "../custom/func.php";
require_once "../classes/quote.php";
require_once "../classes/gist.php";
require_once "../classes/User.php";
require_once "../classes/like.php";

$gist = new Gists();

$lastID = $_POST['last_id'];
$cat_id = $_POST['cat_id'];
$area = $_POST['area'];

if($area === 'cat-gist-all') {
    $g = json_decode($gist->getByLCId($cat_id, $lastID));
    if(sizeof($g->gists) > 0)
    {
        for ($i = 0; $i < sizeof($g->gists); $i++)
        {
            if ($g->gists[$i]->image !== '')
            {
                print '<a href="gist/'.urlencode($g->gists[$i]->id).'">';
                print '<div class="card wow slideInUp">';
                print '<img class="card-img-top img-fluid" src="/'.$g->gists[$i]->image.'" alt="Card image cap">';
                print '<div class="card-block" style="display: inline-block; width: 100%;">';
                print '<h6 class="card-title">'.$g->gists[$i]->title.'</h6>';
                print '<div class="avatar-list-item" style="width: 100%; margin: 0px; box-shadow: none; border-radius: inherit; display: inline-block;">';
                $gistUser = json_decode($u->getById($g->gists[$i]->user_id));
                for ($j=0; $j < count($gistUser->users); $j++)
                {
                    print '<a href="profile/'.$gistUser->users[$j]->username.'/' . $gistUser->users[$j]->id . '">';
                    print '<img class="rounded-circle" src="/'.$gistUser->users[$j]->user_avatar.'" style="float: left;">';
                    print '<div class="" style="margin-left: 10px; color:'.$gistUser->users[$j]->color.'; float: left;">';
                    print '<p class="card-text" style="margin: 0px;">'.$gistUser->users[$j]->username.'</p>';
                    print '<p class="card-text" style="margin-bottom: 0px; opacity: .8;"><small>'.timeago($g->gists[$i]->created).'</small></p>';
                    print '</div>';
                    print '</a>';
                }
                print '</div>';
                print '<div class="pull-top" style="margin-bottom: 30px;">';
                print '<p><img src="'.thumbUpImgIcon().'">'.countFormat($g->gists[$i]->likes).'</p>';
                print '<p><img src="'.viewImgIcon().'">'.countFormat($g->gists[$i]->views).'</p>';
                print '<p><img src="'.postImgIcon().'">'.countFormat($g->gists[$i]->posts).'</p>';
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
            else
            {
                print '<a href="gist/'.urlencode($g->gists[$i]->id).'">';
                print '<div class="card wow slideInUp">';
                print '<div class="card-block" style="display: inline-block; width: 100%;">';
                print '<h6 class="card-title">'.$g->gists[$i]->title.'</h6>';

                print '<div class="avatar-list-item" style="width: 100%; margin: 0px; box-shadow: none; border-radius: inherit; display: inline-block;">';
                $gistUser = json_decode($u->getById($g->gists[$i]->user_id));
                for ($j = 0; $j < count($gistUser->users); $j++)
                {
                    print '<a href="profile/'.$gistUser->users[$j]->username.'/' . $gistUser->users[$j]->id . '">';
                    print '<img class="rounded-circle" src="/'.$gistUser->users[$j]->user_avatar.'" style="float: left;">';
                    print '<div class="" style="margin-left: 10px; color:'.$gistUser->users[$j]->color.'; float: left;">';
                    print '<p class="card-text" style="margin: 0px;">'.$gistUser->users[$j]->username.'</p>';

                    print '<p class="card-text" style="margin-bottom: 0px; opacity: .8;"><small>'.timeago($g->gists[$i]->created).'</small></p>';
                    print '</div>';
                    print '</a>';
                }
                print '</div>';

                print '<div class="pull-top" style="margin-bottom: 30px;">';
                print '<p><img src="'.thumbUpImgIcon().'">'.countFormat($g->gists[$i]->likes).'</p>';
                print '<p><img src="'.viewImgIcon().'">'.countFormat($g->gists[$i]->views).'</p>';
                print '<p><img src="'.postImgIcon().'">'.countFormat($g->gists[$i]->posts).'</p>';
                print '</div>';

                // print '<div class="pull-center">';
                //     print '<code class="tag-preview">#textMyServer</code>';
                //     print '<code class="tag-preview">#textMyServer</code>';
                //     print '<code class="tag-preview">#textMyServer</code>';
                // print '</div>';

                print '</div>';
                print '</div>';
                print '</a><!--End Card container-->';
                $gistId = $g->gists[$i]->id;
            }
        }
        if(sizeof($g->gists) > 20)
        {
            print '</div>';
            print '<div class="gist-container no-margin margin-top no-shadow" data-area="cat-gist-all" id="gist-l-m" data-last-id="'.$gistId.'" data-cat-id="'.$cat_id.'">';
                print '<p>Load More</p>';
            print '</div><!--End Load more button -->';
            print '<div>';
        }
    }
    else
    {
        print 3; //done
    }
}
elseif ($area === 'cat-gist-last-updated')
{
    $g = json_decode($gist->getByLlastUpdatedCat($cat_id, $lastID));
    if(sizeof($g->gists) > 0)
    {
        for ($i = 0; $i < sizeof($g->gists); $i++)
        {
            if ($g->gists[$i]->image !== '')
            {
                print '<a href="gist/'.urlencode($g->gists[$i]->id).'">';
                print '<div class="card wow slideInUp">';
                print '<img class="card-img-top img-fluid" src="/'.$g->gists[$i]->image.'" alt="Card image cap">';
                print '<div class="card-block" style="display: inline-block; width: 100%;">';
                print '<h6 class="card-title">'.$g->gists[$i]->title.'</h6>';
                print '<div class="avatar-list-item" style="width: 100%; margin: 0px; box-shadow: none; border-radius: inherit; display: inline-block;">';
                $gistUser = json_decode($u->getById($g->gists[$i]->user_id));
                for ($j=0; $j < count($gistUser->users); $j++)
                {
                    print '<a href="profile/'.$gistUser->users[$j]->username.'/' . $gistUser->users[$j]->id . '">';
                    print '<img class="rounded-circle" src="/'.$gistUser->users[$j]->user_avatar.'" style="float: left;">';
                    print '<div class="" style="margin-left: 10px; color:'.$gistUser->users[$j]->color.'; float: left;">';
                    print '<p class="card-text" style="margin: 0px;">'.$gistUser->users[$j]->username.'</p>';
                    print '<p class="card-text" style="margin-bottom: 0px; opacity: .8;"><small>'.timeago($g->gists[$i]->created).'</small></p>';
                    print '</div>';
                    print '</a>';
                }
                print '</div>';
                print '<div class="pull-top" style="margin-bottom: 30px;">';
                print '<p><img src="'.thumbUpImgIcon().'">'.countFormat($g->gists[$i]->likes).'</p>';
                print '<p><img src="'.viewImgIcon().'">'.countFormat($g->gists[$i]->views).'</p>';
                print '<p><img src="'.postImgIcon().'">'.countFormat($g->gists[$i]->posts).'</p>';
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
            else
            {
                print '<a href="gist/'.urlencode($g->gists[$i]->id).'">';
                    print '<div class="card wow slideInUp">';
                        print '<div class="card-block" style="display: inline-block; width: 100%;">';
                            print '<h6 class="card-title">'.$g->gists[$i]->title.'</h6>';
                            print '<div class="avatar-list-item" style="width: 100%; margin: 0px; box-shadow: none; border-radius: inherit; display: inline-block;">';
                            $gistUser = json_decode($u->getById($g->gists[$i]->user_id));
                            for ($j = 0; $j < count($gistUser->users); $j++)
                            {
                                print '<a href="profile/'.$gistUser->users[$j]->username.'/' . $gistUser->users[$j]->id . '">';
                                    print '<img class="rounded-circle" src="/'.$gistUser->users[$j]->user_avatar.'" style="float: left;">';
                                    print '<div class="" style="margin-left: 10px; color:'.$gistUser->users[$j]->color.'; float: left;">';
                                        print '<p class="card-text" style="margin: 0px;">'.$gistUser->users[$j]->username.'</p>';
                                        print '<p class="card-text" style="margin-bottom: 0px; opacity: .8;"><small>'.timeago($g->gists[$i]->created).'</small></p>';
                                    print '</div>';
                                print '</a>';
                            }
                            print '</div>';

                            print '<div class="pull-top" style="margin-bottom: 30px;">';
                                print '<p><img src="'.thumbUpImgIcon().'">'.countFormat($g->gists[$i]->likes).'</p>';
                                print '<p><img src="'.viewImgIcon().'">'.countFormat($g->gists[$i]->views).'</p>';
                                print '<p><img src="'.postImgIcon().'">'.countFormat($g->gists[$i]->posts).'</p>';
                            print '</div>';
                            // print '<div class="pull-center">';
                            //     print '<code class="tag-preview">#textMyServer</code>';
                            //     print '<code class="tag-preview">#textMyServer</code>';
                            //     print '<code class="tag-preview">#textMyServer</code>';
                            // print '</div>';
                        print '</div>';
                    print '</div>';
                print '</a><!--End Card container-->';
                $gistId = $g->gists[$i]->id;
            }
        }
        if(sizeof($g->gists) > 20)
        {
            print '</div>';
            print '<div class="gist-container no-margin margin-top no-shadow" data-area="card-column-last-update" id="gist-l-m" data-last-id="'.$gistId.'" data-cat-id="'.$cat_id.'">';
                print '<p>Load More</p>';
            print '</div><!--End Load more button -->';
            print '<div>';
        }
    }
    else
    {
        print 3; //done
    }
}
elseif ($area === 'cat-gist-trend')
{
    $g = json_decode($gist->getByMoreTrendCat($cat_id, $lastID));
    if(sizeof($g->gists) > 0)
    {
        for ($i = 0; $i < sizeof($g->gists); $i++)
        {
            if ($g->gists[$i]->image !== '')
            {
                print '<a href="gist/'.urlencode($g->gists[$i]->id).'">';
                print '<div class="card wow slideInUp">';
                print '<img class="card-img-top img-fluid" src="/'.$g->gists[$i]->image.'" alt="Card image cap">';
                print '<div class="card-block" style="display: inline-block; width: 100%;">';
                print '<h6 class="card-title">'.$g->gists[$i]->title.'</h6>';
                print '<div class="avatar-list-item" style="width: 100%; margin: 0px; box-shadow: none; border-radius: inherit; display: inline-block;">';
                $gistUser = json_decode($u->getById($g->gists[$i]->user_id));
                for ($j=0; $j < count($gistUser->users); $j++)
                {
                    print '<a href="profile/'.$gistUser->users[$j]->username.'/' . $gistUser->users[$j]->id . '">';
                    print '<img class="rounded-circle" src="/'.$gistUser->users[$j]->user_avatar.'" style="float: left;">';
                    print '<div class="" style="margin-left: 10px; color:'.$gistUser->users[$j]->color.'; float: left;">';
                    print '<p class="card-text" style="margin: 0px;">'.$gistUser->users[$j]->username.'</p>';
                    print '<p class="card-text" style="margin-bottom: 0px; opacity: .8;"><small>'.timeago($g->gists[$i]->created).'</small></p>';
                    print '</div>';
                    print '</a>';
                }
                print '</div>';
                print '<div class="pull-top" style="margin-bottom: 30px;">';
                print '<p><img src="'.thumbUpImgIcon().'">'.countFormat($g->gists[$i]->likes).'</p>';
                print '<p><img src="'.viewImgIcon().'">'.countFormat($g->gists[$i]->views).'</p>';
                print '<p><img src="'.postImgIcon().'">'.countFormat($g->gists[$i]->posts).'</p>';
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
            else
            {
                print '<a href="gist/'.urlencode($g->gists[$i]->id).'">';
                print '<div class="card wow slideInUp">';
                print '<div class="card-block" style="display: inline-block; width: 100%;">';
                print '<h6 class="card-title">'.$g->gists[$i]->title.'</h6>';

                print '<div class="avatar-list-item" style="width: 100%; margin: 0px; box-shadow: none; border-radius: inherit; display: inline-block;">';
                $gistUser = json_decode($u->getById($g->gists[$i]->user_id));
                for ($j = 0; $j < count($gistUser->users); $j++)
                {
                    print '<a href="profile/'.$gistUser->users[$j]->username.'/' . $gistUser->users[$j]->id . '">';
                    print '<img class="rounded-circle" src="/'.$gistUser->users[$j]->user_avatar.'" style="float: left;">';
                    print '<div class="" style="margin-left: 10px; color:'.$gistUser->users[$j]->color.'; float: left;">';
                    print '<p class="card-text" style="margin: 0px;">'.$gistUser->users[$j]->username.'</p>';

                    print '<p class="card-text" style="margin-bottom: 0px; opacity: .8;"><small>'.timeago($g->gists[$i]->created).'</small></p>';
                    print '</div>';
                    print '</a>';
                }
                print '</div>';

                print '<div class="pull-top" style="margin-bottom: 30px;">';
                print '<p><img src="'.thumbUpImgIcon().'">'.countFormat($g->gists[$i]->likes).'</p>';
                print '<p><img src="'.viewImgIcon().'">'.countFormat($g->gists[$i]->views).'</p>';
                print '<p><img src="'.postImgIcon().'">'.countFormat($g->gists[$i]->posts).'</p>';
                print '</div>';

                // print '<div class="pull-center">';
                //     print '<code class="tag-preview">#textMyServer</code>';
                //     print '<code class="tag-preview">#textMyServer</code>';
                //     print '<code class="tag-preview">#textMyServer</code>';
                // print '</div>';

                print '</div>';
                print '</div>';
                print '</a><!--End Card container-->';
                $gistId = $g->gists[$i]->id;
            }
        }
        if(sizeof($g->gists) > 20)
        {
            print '</div>';
            print '<div class="gist-container no-margin margin-top no-shadow" data-area="cat-gist-trend" id="gist-l-m" data-last-id="'.$gistId.'" data-cat-id="'.$cat_id.'">';
            print '<p>Load More</p>';
            print '</div><!--End Load more button -->';
            print '<div>';
        }
    }
    else
    {
        print 3; //done
    }
}
elseif ($area === 'cat-gist-hot')
{
    $g = json_decode($gist->getByMoreHotCat($cat_id, $lastID));
    if(sizeof($g->gists) > 0)
    {
        for ($i = 0; $i < sizeof($g->gists); $i++)
        {
            if ($g->gists[$i]->image !== '')
            {
                print '<a href="gist/'.urlencode($g->gists[$i]->id).'">';
                print '<div class="card wow slideInUp">';
                print '<img class="card-img-top img-fluid" src="/'.$g->gists[$i]->image.'" alt="Card image cap">';
                print '<div class="card-block" style="display: inline-block; width: 100%;">';
                print '<h6 class="card-title">'.$g->gists[$i]->title.'</h6>';
                print '<div class="avatar-list-item" style="width: 100%; margin: 0px; box-shadow: none; border-radius: inherit; display: inline-block;">';
                $gistUser = json_decode($u->getById($g->gists[$i]->user_id));
                for ($j=0; $j < count($gistUser->users); $j++)
                {
                    print '<a href="profile/'.$gistUser->users[$j]->username.'/' . $gistUser->users[$j]->id . '">';
                    print '<img class="rounded-circle" src="/'.$gistUser->users[$j]->user_avatar.'" style="float: left;">';
                    print '<div class="" style="margin-left: 10px; color:'.$gistUser->users[$j]->color.'; float: left;">';
                    print '<p class="card-text" style="margin: 0px;">'.$gistUser->users[$j]->username.'</p>';
                    print '<p class="card-text" style="margin-bottom: 0px; opacity: .8;"><small>'.timeago($g->gists[$i]->created).'</small></p>';
                    print '</div>';
                    print '</a>';
                }
                print '</div>';
                print '<div class="pull-top" style="margin-bottom: 30px;">';
                print '<p><img src="'.thumbUpImgIcon().'">'.countFormat($g->gists[$i]->likes).'</p>';
                print '<p><img src="'.viewImgIcon().'">'.countFormat($g->gists[$i]->views).'</p>';
                print '<p><img src="'.postImgIcon().'">'.countFormat($g->gists[$i]->posts).'</p>';
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
            else
            {
                print '<a href="gist/'.urlencode($g->gists[$i]->id).'">';
                print '<div class="card wow slideInUp">';
                print '<div class="card-block" style="display: inline-block; width: 100%;">';
                print '<h6 class="card-title">'.$g->gists[$i]->title.'</h6>';

                print '<div class="avatar-list-item" style="width: 100%; margin: 0px; box-shadow: none; border-radius: inherit; display: inline-block;">';
                $gistUser = json_decode($u->getById($g->gists[$i]->user_id));
                for ($j = 0; $j < count($gistUser->users); $j++)
                {
                    print '<a href="profile/'.$gistUser->users[$j]->username.'/' . $gistUser->users[$j]->id . '">';
                    print '<img class="rounded-circle" src="/'.$gistUser->users[$j]->user_avatar.'" style="float: left;">';
                    print '<div class="" style="margin-left: 10px; color:'.$gistUser->users[$j]->color.'; float: left;">';
                    print '<p class="card-text" style="margin: 0px;">'.$gistUser->users[$j]->username.'</p>';

                    print '<p class="card-text" style="margin-bottom: 0px; opacity: .8;"><small>'.timeago($g->gists[$i]->created).'</small></p>';
                    print '</div>';
                    print '</a>';
                }
                print '</div>';

                print '<div class="pull-top" style="margin-bottom: 30px;">';
                print '<p><img src="'.thumbUpImgIcon().'">'.countFormat($g->gists[$i]->likes).'</p>';
                print '<p><img src="'.viewImgIcon().'">'.countFormat($g->gists[$i]->views).'</p>';
                print '<p><img src="'.postImgIcon().'">'.countFormat($g->gists[$i]->posts).'</p>';
                print '</div>';

                // print '<div class="pull-center">';
                //     print '<code class="tag-preview">#textMyServer</code>';
                //     print '<code class="tag-preview">#textMyServer</code>';
                //     print '<code class="tag-preview">#textMyServer</code>';
                // print '</div>';

                print '</div>';
                print '</div>';
                print '</a><!--End Card container-->';
                $gistId = $g->gists[$i]->id;
            }
        }
        if(sizeof($g->gists) > 20)
        {
            print '</div>';
            print '<div class="gist-container no-margin margin-top no-shadow" data-area="cat-gist-trend" id="gist-l-m" data-last-id="'.$gistId.'" data-cat-id="'.$cat_id.'">';
            print '<p>Load More</p>';
            print '</div><!--End Load more button -->';
            print '<div>';
        }
    }
    else
    {
        print 3; //done
    }
}