<?php

	require_once "call.php";

    Class Quotes
    {

		public $quote_url = 'quote?transform=1';


		public function __construct(){}

        private function get($id, $postId, $userId)
        {
            global $call_url;
            if($id != null)
            {
				$extra = $this->quote_url.'&filter=id,eq,'.$id;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }
            if($postId != null)
            {
				$extra = $this->quote_url.'&filter=post_id,eq,'.$postId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($userId != null)
            {
				$extra = $this->quote_url.'&filter=user_id,eq,'.$userId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

			return $response;
        }

        public function getById($id)
        {
            return $this->get($id, null, null);
        }

        public function getByPostId($postId)
        {
            return $this->get(null, $postId, null);
        }

        public function getByUserId($userId)
        {
            return $this->get(null, null, $userId);
        }

        public function getAll()
        {
			global $call_url;

			$extra = $this->quote_url;
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
                $created = date('Y-m-d h-s i');

				$url = $call_url.'quote';
				$obj = '{
                            "post_id": '.$postId.',
                            "user_id": '.$userId.',
                            "post_user_id": '.$postUserId.',
                            "created": "'.$created.'"
                        }';

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