<?php

	require_once "call.php";

    class HashtagPosts
    {

		public $hashtag_url = 'hashtag_post?transform=1';


		public function __construct(){}

        private function get($id, $hashtagId, $postId, $hashSpec)
        {
            global $call_url;
			
            if($id != null)
            {
				$extra = $this->hashtag_url.'&filter=id,eq,'.$id;
				$url = $call_url.$extra;
				$response = call('GET', $url);
            }
            if($hashtagId != null)
            {
				$extra = $this->hashtag_url.'&filter=hashtag_id,eq,'.$hashtagId;
				$url = $call_url.$extra;
				$response = call('GET', $url);
            }
            
            if($postId != null)
            {
				$extra = $this->hashtag_url.'&filter=post_id,eq,'.$postId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }
            
            if($hashSpec != null)
            {
				$extra = $this->hashtag_url.'&filter=user_id,eq,'.$hashSpec;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

			return $response;
        }

        public function getById($id)
        {
            return $this->get($id, null, null, null);
        }

        public function getByHashTagId($HashTagId)
        {
            return $this->get(null, $HashTagId, null, null);
        }

        public function getByHashSpec($hashSpec)
        {
            return $this->get(null, null, null, $hashSpec);
        }

        public function getByPostId($postId)
        {
            return $this->get(null, null, $postId, null);
        }

        public function getAll()
        {
			global $call_url;

			$extra = $this->hashtag_url;
			$url = $call_url.$extra;
			$response = call('GET',$url);

			if ($response != null)
				return $response;
			else 
				return 'Error Occurred!!';
        }

		public function addNew($hashtagId, $post_id, $hashtag_specs)
		{
        if ($hashtagId == null || $post_id == null || $hashtag_specs == null)
			{
				return 'Enter Appropriate values..!!';
			}
			else
			{
				global $call_url;

				$url = $call_url.'hashtag_post';
				$obj = '{
                            "hashtag_id": '.$hashtagId.',
                            "post_id": '.$post_id.',
                            "hashtag_specs": "'.$hashtag_specs.'"
                        }';

				// $obj = json_decode($obj);
				$response = call('POST', $url, $obj);
				return $response;
			}
		}

//	 	private function update($id)
//	 	{
//
//	 	}
//
//	 	public function updateBy()
//	 	{
//	 		return $this->update();
//	 	}
    }