<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/27/2017
 * Time: 10:27 PM
 */

require_once '../classes/publicNotification.php';
require_once '../custom/func.php';

$pNot = new publicNotification\publicNotification();

$alert = json_decode($pNot->getFlag());
if(sizeof($alert->public_notification) > 0){
    $msg = $alert->public_notification[0]->message;
    print $msg;
}
else
{
    print 0;
}