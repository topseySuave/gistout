<?php

	require_once "call.php";

    class Notification
    {

		public $notification_url = 'notification?transform=1';


		public function __construct(){}

        private function get($id, $receiverId, $senderId, $gistId, $postId, $type, $spec, $page = 1, $arrange = 'desc')
        {
            global $call_url;
            $response = null;
            if($id != null)
            {
				$extra = $this->notification_url.'&filter=id,eq,'.$id;
				$url = $call_url.$extra;
				$response = call('GET', $url);
            }

            if($receiverId != null)
            {
				$extra = $this->notification_url.'&filter=receiver_id,eq,'.$receiverId.'&order=id,'.$arrange.'&page='.$page;
				$url = $call_url.$extra;
				$response = call('GET', $url);
            }
            
            if($senderId != null)
            {
				$extra = $this->notification_url.'&filter=sender_id,eq,'.$senderId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($gistId != null)
            {
                $extra = $this->notification_url.'&filter=gist_id,eq,'.$gistId;
                $url = $call_url.$extra;
                $response = call('GET',$url);
            }
            
            if($postId != null)
            {
				$extra = $this->notification_url.'&filter=post_id,eq,'.$postId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }
            
            if($type != null)
            {
				$extra = $this->notification_url.'&filter=notification_type,eq,'.$type;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }
            
            if($spec != null)
            {
				$extra = $this->notification_url.'&filter=notification_spec,eq,'.$spec;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

			return $response;
        }

        public function getById($id)
        {
            return $this->get($id, null, null, null, null, null, null);
        }

        public function getByReceiverId($receiverId)
        {
            return $this->get(null, $receiverId, null, null, null, null, null, $page = 1);
        }

        public function getBySenderId($senderId)
        {
            return $this->get(null, null, $senderId, null, null, null, null);
        }

        public function getByGistId($gistId)
        {
            return $this->get(null, null, null, $gistId, null, null, null);
        }

        public function getByPostId($postId)
        {
            return $this->get(null, null, null, null, $postId, null, null);
        }

        public function getBySpec($spec)
        {
            return $this->get(null, null, null, null, null, $spec, null);
        }

        public function getByType($type)
        {
            return $this->get(null, null, null, null, null, null, $type);
        }

        public function getByUnread($userId)
        {
            global $call_url;
            $extra = $this->notification_url.'&filter[]=receiver_id,eq,'.$userId.'&filter[]=unread,eq,0&satisfy=all';
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        public function getAll()
        {
			global $call_url;

			$extra = $this->notification_url;
			$url = $call_url.$extra;
			$response = call('GET',$url);

			if ($response != null)
				return $response;
			else 
				return 'Error Occurred!!';
        }

		public function addNew($receiverId, $senderId, $gistId, $postId, $type, $spec)
		{
            if ($receiverId == null || $senderId == null || $type == null || $spec == null)
			{
				return 'Enter Appropriate values..!!';
			}
			else
			{
				global $call_url;
                $created = date('Y-m-d H:i:s');

				$url = $call_url.'notification';
				$obj = '{
                            "receiver_id": '.$receiverId.',
                            "sender_id": '.$senderId.',
                            "time": "'.$created.'",
                            "gist_id": '.$gistId.',
                            "post_id": '.$postId.',
                            "notification_spec": "'.$spec.'",
                            "notification_type": "'.$type.'",
                            "unread": 0
                        }';

				$response = call('POST', $url, $obj);
				return $response;
			}
		}

        public function deleteById($id)
        {
            global $call_url;

            $url = $call_url . 'notification/'.$id;
            $response = call('DELETE', $url);
            return $response;
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

        public function updateByUnread($id, $val)
        {
            global $call_url;
            $url = $call_url.'notification/'.$id;
            $obj = '{"unread": '.$val.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }
    }