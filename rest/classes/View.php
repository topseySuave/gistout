<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/6/2017
 * Time: 10:57 AM
 */

require_once "call.php";

class View
{
    public $views_url = 'views?transform=1';

    public function __construct(){}

    private function get($id, $gist_id, $user_id)
    {
        global $call_url;

        if($id != null)
        {
            $extra = $this->views_url.'&filter=id,eq,'.$id;
            $url = $call_url.$extra;
            $response = call('GET', $url);
            return $response;
        }

        if($gist_id != null)
        {
            $extra = $this->views_url.'&filter=gist_id,eq,'.$gist_id;
            $url = $call_url.$extra;
            $response = call('GET', $url);
            return $response;
        }

        if($user_id != null)
        {
            $extra = $this->views_url.'&filter=user_id,eq,'.$user_id;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }
    }

    public function getAll()
    {
        global $call_url;

        $extra = $this->views_url;
        $url = $call_url.$extra;
        $response = call('GET',$url);

        if ($response != null)
            return $response;
        else
            return 'Error Occurred!!';
    }

    public function getById($id)
    {
        return $this->get($id, null, null);
    }

    public function getByGistId($gistId)
    {
        return $this->get(null, $gistId, null);
    }

    public function getByUserId($userId)
    {
        return $this->get(null, null, $userId);
    }

    public function getByGistAndUserId($gistId, $userId)
    {
        global $call_url;
        if(($gistId && $userId) != null)
        {
            $extra = $this->views_url.'&filter[]=gist_id,eq,'.$gistId.'&filter[]=user_id,eq,'.$userId.'&satisfy=all';
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }
    }

    public function getByCatAndUserId($catId, $userId)
    {
        global $call_url;
        if(($catId && $userId) != null)
        {
            $extra = $this->views_url.'&filter[]=cat_id,eq,'.$catId.'&filter[]=user_id,eq,'.$userId.'&satisfy=all';
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }
    }

    public function addNew($gistId, $userId, $catId)
    {
        if ($userId == null)
        {
            return 'Enter Appropriate values..!!';
        }
        else
        {
            global $call_url;
            $url = $call_url.'views';
            $obj = '{"gist_id": "'.$gistId.'", "user_id": "'.$userId.'", "cat_id": "'.$catId.'"}';
            $response = call('POST', $url, $obj);
            return $response;
        }
    }
}