<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 3/26/2017
 * Time: 10:38 AM
 */
require_once "call.php";

class Report
{
    public $report_url = 'report?transform=1';


    public function __construct(){}

    private function get($id, $report_specs, $report_enum, $postId, $postUser, $userId)
    {
        global $call_url;
        if($id != null)
        {
            $extra = $this->report_url.'&filter=id,eq,'.$id;
            $url = $call_url.$extra;
            $response = call('GET', $url);
        }
        if($report_specs != null)
        {
            $extra = $this->report_url.'&filter=report_specs,eq,'.$report_specs;
            $url = $call_url.$extra;
            $response = call('GET', $url);
        }

        if($report_enum != null)
        {
            $extra = $this->report_url.'&filter=report_enum,eq,'.$report_enum;
            $url = $call_url.$extra;
            $response = call('GET',$url);
        }

        if($postId != null)
        {
            $extra = $this->report_url.'&filter=post_id,eq,'.$postId;
            $url = $call_url.$extra;
            $response = call('GET',$url);
        }

        if($postUser != null)
        {
            $extra = $this->report_url.'&filter=post_user,eq,'.$postUser;
            $url = $call_url.$extra;
            $response = call('GET',$url);
        }

        if($userId != null)
        {
            $extra = $this->report_url.'&filter=user_id,eq,'.$userId;
            $url = $call_url.$extra;
            $response = call('GET',$url);
        }

        return $response;
    }

    public function getById($id)
    {
        return $this->get($id, null, null, null, null, null);
    }

    public function getBySpec($spec)
    {
        return $this->get(null, $spec, null, null, null, null);
    }

    public function getByEnum($enumVal)
    {
        return $this->get(null, null, $enumVal, null, null, null);
    }

    public function getByPostId($postId)
    {
        return $this->get(null, null, null, $postId, null, null);
    }

    public function getByPostUser($postUser)
    {
        return $this->get(null, null, null, null, $postUser, null);
    }

    public function getByUserId($userId)
    {
        return $this->get(null, null, null, null, null, $userId);
    }

    public function getByUserIdAndPostId($userId, $postId)
    {
        global $call_url;
        $extra = $this->report_url.'&filter[]=post_id,eq,'.$postId.'&filter[]=user_id,eq,'.$userId;
        $url = $call_url.$extra;
        $response = call('GET',$url);
        return $response;
    }

    public function getAll($page = 1, $arrange = 'desc')
    {
        global $call_url;

        $extra = $this->report_url.'&order=id,'. $arrange . '&page='.$page;
        $url = $call_url.$extra;
        $response = call('GET',$url);

        if ($response != null)
            return $response;
        else
            return 'Error Occurred!!';
    }

    public function addNew($postId, $postUser, $userId, $spec, $enum)
    {
        if ($postId == null || $postUser == null || $userId == null || $spec == null || $enum == null)
        {
            return 'Enter Appropriate values..!!';
        }
        else
        {
            global $call_url;
            $url = $call_url.'report';
            $obj = '{"post_id": "'.$postId.'","post_user": "'.$postUser.'","user_id": "'.$userId.'","report_specs": "'.$spec.'","report_enum": "'.$enum.'"}';
            // $obj = json_decode($obj);
            $response = call('POST', $url, $obj);
            return $response;
        }
    }

    // 	private function update($id,$username)
    // 	{

    // 	}

    // 	public function updateByID($id)
    // 	{
    // 		return $this->update($id, null);
    // 	}

    // 	public function updateByUserName($username)
    // 	{
    // 		return $this->update(null,$username);
    // 	}
}