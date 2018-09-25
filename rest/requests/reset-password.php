<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/23/2017
 * Time: 2:47 PM
 */

require_once '/rest/classes/User.php';
require_once '/rest/custom/func.php';

$user = new User();

if($_SERVER["REQUEST_METHOD"] == 'POST'):
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $website = test_input($_POST["website"]);
    $comment = test_input($_POST["comment"]);
    $gender = test_input($_POST["gender"]);
else:
endif;