<?php

	require "call.php";

    class Mentions
    {

		public $mention_url = 'mentions?transform=1';


		public function __construct(){}

        private function get($id, $postId, $UserId)
        {
            global $call_url;
            if($id != null)
            {
				$extra = $this->post_url.'&filter=id,eq,'.$id;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }
            
            if($postId != null)
            {
				$extra = $this->post_url.'&filter=post_id,eq,'.$postId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }
            
            if($UserId != null)
            {
				$extra = $this->post_url.'&filter=user_id,eq,'.$UserId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

			return $response;
        }

        public function getById($mentionId)
        {
            return $this->get($id, null, null);
        }

        public function getByUserId($UserId)
        {
            return $this->get(null, null, $UserId);
        }

        public function getByPostId($postId)
        {
            return $this->get(null, $postId, null);
        }

        public function getAll()
        {
			global $call_url;

			$extra = $this->category_url;
			$url = $call_url.$extra;
			$response = call('GET',$url);

			if ($response != null)
				return $response;
			else 
				return 'Error Occurred!!';
        }

		public function addNew($mention_id, $user_id, $post_id, $mention_specs)
		{
        if ($mention_id == null || $user_id == null || $post_id == null || $mention_specs == null)
			{
				return 'Enter Appropriate values..!!';
			}
			else
			{
				global $call_url;

				$url = $call_url.'mentions';
				$obj = '{
                            "mention_id": '.$mention_id.',
                            "user_id": '.$user_id.',
                            "post_id": '.$post_id.',
                            "mention_specs": '.$mention_specs.'
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