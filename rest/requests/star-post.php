<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/12/2017
 * Time: 11:42 PM
 */

require_once "../custom/func.php";
require_once "../classes/StarredPost.php";

$star = new StarredPost();

if(isset($_POST)):
    $sess = test_input($_POST['sess']);
    $id = test_input($_POST['id']);
    $postUser = test_input($_POST['post_user']);
    $purpose = test_input($_POST['purpose']);

    if($purpose == 'star-post'):
        /*get starred post to validate exitence....*/
        $getStarredPosts = json_decode($star->getByPostIdAndUserId($id, $sess));
        if(sizeof($getStarredPosts->starred_post) > 0):
            print 0;
        else:
            $addStar = $star->addNew($id, $postUser, $sess);
            if($addStar = true):
                print 1;
            else:
                print 2;
            endif;
        endif;
    else:
        /*get starred post to validate exitence....*/
        $getStarredPosts = json_decode($star->getByPostIdAndUserId($id, $sess));
        if(sizeof($getStarredPosts->starred_post) > 0):
            $delStar = $star->deleteById($getStarredPosts->starred_post[0]->id);
            if($delStar = true):
                print 1;
            else:
                print 2;
            endif;
        else:
            print 0;
        endif;

    endif;
endif;