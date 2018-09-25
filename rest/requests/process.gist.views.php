<?php session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/5/2017
 * Time: 11:58 PM
 */

require_once "../custom/func.php";
require_once "../classes/gist.php";
require_once "../classes/User.php";
require_once "../classes/View.php";

$user = new User();
$gist = new Gists();
$views = new View();

if(isset($_GET['id'])):
    $viewsGist = test_input($_GET['id']);
    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
    }else{
        $user_id = randomString(12);
    }
    $viewsExists = json_decode($views->getByGistAndUserId($viewsGist, $user_id));
    if(sizeof($viewsExists->views) > 0):
    else:
        $addNew = $views->addNew($viewsGist, $user_id, 0);
        $getGist = json_decode($gist->getById($viewsGist));
        if($addNew == true):
            $viewsG = $getGist->gists[0]->views + 1;
            if(sizeof($getGist->gists) > 0):
                $updateGist = $gist->updateByViews($getGist->gists[0]->id, $viewsG);
                if($updateGist == true):
                    print 1;
                else:
                    print 0;
                endif;
            endif;
        endif;
    endif;
else:
    header('location:'.$_SERVER['REMOTE_HOST'].'/');
endif;