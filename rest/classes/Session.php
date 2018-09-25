<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/23/2017
 * Time: 8:24 PM
 */
require_once "call.php";

class Session
{
    public $session_url = 'session?transform=1';
    public function __construct(){}

    private function get($userId, $token)
    {
        global $call_url;
        if ($userId != null)
        {
            $extra = $this->session_url.'&filter=user_id,eq,'.$userId;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }
        if ($token != null)
        {
            $extra = $this->session_url.'&filter=token,eq,'.$token;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }
    }

    public function getByUserId($userId)
    {
        return $this->get($userId, null);
    }

    public function getToken($token)
    {
        return $this->get(null, $token);
    }

    public function addNew($userId, $userKey, $token, $expiry)
    {
        if($userId == null || $token == null || $expiry == null)
        {
            return 'you must add username,email and password';
        }
        else
        {
            global $call_url;
            $url = $call_url . 'session';
            $obj = '{
                    "user_id": "' . $userId . '",
                    "user_key": "' . $userKey . '",
                    "token": "' . $token . '",
                    "expiry": "' . $expiry . '"
                    }';
            $response = call('POST', $url, $obj);
            return $response;
        }
    }

    private function update($id, $token, $expiry, $used)
    {
        global $call_url;
        $url = $call_url.'session/'.$id;
        if($token !== null){
            $obj = '{"token": "'.$token.'"}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        if($expiry !== null){
            $obj = '{"expiry": "'.$expiry.'"}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        if($used !== null){
            $obj = '{"used": '.$used.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }
    }

    public function updateToken($id, $token)
    {
        return $this->update($id, $token, null, null);
    }

    public function updateExpiry($id, $expiry)
    {
        return $this->update($id, null, $expiry, null);

    }

    public function updateUsed($id, $used)
    {
        return $this->update($id, null, null, $used);

    }

    public function deleteByUserId($id)
    {
        global $call_url;
        $url = $call_url . 'session/'.$id;
        $response = call('DELETE', $url);
        return $response;
    }
}