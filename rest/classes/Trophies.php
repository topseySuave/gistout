<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/30/2017
 * Time: 11:09 PM
 */
require_once "call.php";

class Trophies
{
    public $trophies_url = 'trophies?transform=1';


    public function __construct(){}

    private function get($id, $tag)
    {
        global $call_url;
        if($id != null)
        {
            $extra = $this->trophies_url.'&filter=id,eq,'.$id;
            $url = $call_url.$extra;
            $response = call('GET', $url);
        }

        if($tag != null)
        {
            $extra = $this->trophies_url.'&filter=hashtag,eq,'.$tag;
            $url = $call_url.$extra;
            $response = call('GET',$url);
        }

        return $response;
    }

    public function getById($id)
    {
        return $this->get($id, null);
    }

    public function getAll()
    {
        global $call_url;

        $extra = $this->trophies_url;
        $url = $call_url.$extra;
        $response = call('GET',$url);

        if ($response != null)
            return $response;
        else
            return 'Error Occurred!!';
    }

//    public function addNew($trophy)
//    {
//        if ($trophy == '')
//        {
//            return 'Enter Appropriate values..!!';
//        }
//        else
//        {
//            global $call_url;
//
//            $lastCount = 1;
//            $recentCount = 1;
//            $lastUpdate = date('Y-m-d H:i:s');
//            $recentUpdate = date('Y-m-d H:i:s');
//            $rate = 0;
//
//            $url = $call_url.'trending_hashtag';
//            $obj = '{
//                             "hashtag": "'.$hashtag.'",
//                             "last_count": '.$lastCount.',
//                             "recent_count": '.$recentCount.',
//                             "last_update": "'.$lastUpdate.'",
//                             "recent_update": "'.$recentUpdate.'",
//                             "rate": '.$rate.'
//                         }';
//            $response = call('POST', $url, $obj);
//            return $response;
//        }
//    }
}