<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/19/2017
 * Time: 10:10 PM
 */

require_once '../classes/Trophies.php';
require_once '../classes/User.php';

$u = new User();
$trop = new Trophies();

print '<div class="gist-container" style="padding: 0px;">';
    print '<ol class="breadcrumb">';
        print '<li class="breadcrumb-item"><a href="/">Home</a></li>';
        print '<li class="breadcrumb-item"><a href="profile/'.$_GET['guser'].'/'.$_GET['guid'].'">'.$_GET['guser'].'</a></li>';
        print '<li class="breadcrumb-item"><a href="#">Bagdes and Trophies</a></li>';
    print '</ol>';
print '</div>';

print '<div class="gist-container no--padding" style="background: transparent; box-shadow: none !important;">';
        print '<div class="card-columns">';
        $allTrops = json_decode($trop->getAll());
        $i = 0;
        while($i < sizeof($allTrops->trophies)){
            print '<div class="card">';
                print '<div class="row">';
                    print '<div class="col-md-3">';
                        print '<img class="grayscale card-img-top img-fluid" src="/docs/img/195248-rewards.png" alt="Card image cap">';
                    print '</div>';
                    print '<div class="col-md-9 no--padding">';
                        print '<div class="card-block">';
                            print '<h4 class="card-title">'.$allTrops->trophies[$i]->title.'</h4>';
                            print '<p class="small">'.$allTrops->trophies[$i]->description.'</p>';
                        print '</div>';
                    print '</div>';
                print '</div>';
            print '</div>';
            $i++;
        }
        print '</div>';
print '</div>';

//https://open-andela.slack.com/files/gabrielsuave17/F51M6TV7U/udacity-progress.jpg