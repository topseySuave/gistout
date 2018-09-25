<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/12/2017
 * Time: 11:42 PM
 */

require_once "../custom/func.php";
require_once "../classes/Report.php";
require_once "../classes/User.php";

$rep = new Report();
$user = new User();

if(isset($_POST)):
    $sess = test_input($_POST['sess']);
    $post_id = test_input($_POST['post_id']);
    $postUser = test_input($_POST['post_user']);
    $case = test_input($_POST['case']);

    /**
     * Will need to check if the session user has
     * Reported this particular post id.
     * Go to Report and get data for session and post id.
    **/

    $resid = json_decode($rep->getByUserIdAndPostId($sess, $post_id));
    if(sizeof($resid->report) > 0)
        print 0;
    else
        $addNew = $rep->addNew($post_id, $postUser, $sess, $case, 'post');
        $getUser4UpdatePoints = json_decode($user->getById($sess));
        $updateUserPoints = $getUser4UpdatePoints->users[0]->user_points + userBonus()['report'];
        $updateUserPoints = $user->updateByUserPoint($sess, $updateUserPoints);
        if($addNew == true)
            print 1;
        else
            print 2;
endif;