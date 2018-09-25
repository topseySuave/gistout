<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/10/2017
 * Time: 11:47 PM
 */

require_once "call.php";

class StarredPost
{

    public $starredPost_url = 'starred_post?transform=1';


    public function __construct(){}

    private function get($id, $postId, $postUserId, $userId, $time)
    {
        global $call_url;
        if($id != null)
        {
            $extra = $this->starredPost_url.'&filter=id,eq,'.$id;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($postId != null)
        {
            $extra = $this->starredPost_url.'&filter=post_id,eq,'.$postId;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($postUserId != null)
        {
            $extra = $this->starredPost_url.'&filter=post_user_id,eq,'.$postUserId;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($userId != null)
        {
            $extra = $this->starredPost_url.'&filter=user_id,eq,'.$userId;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($time != null)
        {
            $extra = $this->starredPost_url.'&filter=time,eq,'.$time;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }
    }

    public function getById($id)
    {
        return $this->get($id, null, null, null, null);
    }

    public function getByPostId($postId)
    {
        return $this->get(null, $postId, null, null, null);
    }

    public function getByTime($time)
    {
        return $this->get(null, null, null, null, $time);
    }

    public function getByUserId($userId)
    {
        return $this->get(null, null, null, $userId, null);
    }

    public function getByPostUserId($postUserId)
    {
        return $this->get(null, null, $postUserId, null, null);
    }

    public function getByPostIdAndUserId($postId, $userId)
    {
        global $call_url;
        $extra = $this->starredPost_url.'&filter[]=post_id,eq,'.$postId.'&filter[]=user_id,eq,'.$userId;
        $url = $call_url.$extra;
        $response = call('GET',$url);
        return $response;
    }

    public function getAll()
    {
        global $call_url;

        $extra = $this->starredPost_url;
        $url = $call_url.$extra;
        $response = call('GET',$url);

        if ($response != null)
            return $response;
        else
            return 'Error Occurred!!';
    }

    public function addNew($postId, $postUserId, $userId)
    {
        if ($postId == null || $postUserId == null || $userId == null)
        {
            return 'Enter Appropriate values..!!';
        }
        else
        {
            global $call_url;

            // Set created to The current date and time....
            $time = date('Y-m-d H:i:s');

            $url = $call_url.'starred_post';
            $obj = '{"post_id": "'.$postId.'","post_user_id": "'.$postUserId.'","user_id": '.$userId.', "time": "'.$time.'"}';

            $response = call('POST', $url, $obj);
            return $response;
        }
    }

    public function deleteById($id)
    {
        global $call_url;

        $url = $call_url . 'starred_post/'.$id;
        $response = call('DELETE', $url);
        return $response;
    }
}