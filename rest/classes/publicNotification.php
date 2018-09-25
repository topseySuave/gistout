<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/17/2017
 * Time: 8:51 PM
 */

namespace publicNotification;

require_once "call.php";

class publicNotification
{
    public $publicNotification_url = 'public_notification?transform=1';

    public function __construct()
    {
    }

    private function get($id, $message, $flag, $date)
    {
        global $call_url;
        if($id != null)
        {
            $extra = $this->publicNotification_url.'&filter=id,eq,'.$id;
            $url = $call_url.$extra;
            $response = call('GET', $url);
            return $response;
        }

        if($message != null)
        {
            $extra = $this->publicNotification_url.'&filter=message,eq,'.$message;
            $url = $call_url.$extra;
            $response = call('GET', $url);
            return $response;
        }

        if($flag != null)
        {
            $extra = $this->publicNotification_url.'&filter=flag,eq,'.$flag;
            $url = $call_url.$extra;
            $response = call('GET', $url);
            return $response;
        }

        if($date != null)
        {
            $extra = $this->publicNotification_url.'&filter=date,eq,'.$date;
            $url = $call_url.$extra;
            $response = call('GET', $url);
            return $response;
        }
    }

    public function getId($id)
    {
        return $this->get($id, null, null, null);
    }

    public function getFlag()
    {
        return $this->get(null, null, 1, null);
    }

    public function getAll()
    {
        global $call_url;
        $extra = $this->publicNotification_url;
        $url = $call_url.$extra;
        $response = call('GET',$url);
        if ($response != null)
            return $response;
        else
            return 'bad error';

    }

    public function addNew($message, $flag = 1)
    {
        if ($message == null)
        {
            return 'Enter Appropriate values..!!';
        }
        else
        {
            global $call_url;
            $created = date('Y-m-d H:i:s');

            $url = $call_url.'public_notification';
            $obj = '{
                            "message": "'.$message.'",
                            "flag": '.$flag.',
                            "date": '.$created.'
                        }';

            $response = call('POST', $url, $obj);
            return $response;
        }
    }

    private function update($id, $message, $flag, $date)
    {

    }

}