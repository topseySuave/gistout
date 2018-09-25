<?php

	require_once "call.php";

    Class Likes
    {

		public $like_url = 'like?transform=1';


		public function __construct(){}

        private function get($id, $postId, $userId, $gistId)
        {
            global $call_url;
            if($id != null)
            {
				$extra = $this->like_url.'&filter=id,eq,'.$id;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }
            if($postId != null)
            {
				$extra = $this->like_url.'&filter=post_id,eq,'.$postId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($userId != null)
            {
				$extra = $this->like_url.'&filter=user_id,eq,'.$userId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($gistId != null)
            {
				$extra = $this->like_url.'&filter=gist_id,eq,'.$gistId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

			return $response;
        }

        public function getById($id)
        {
            return $this->get($id, null, null, null);
        }

        public function getByPostId($postId)
        {
            return $this->get(null, $postId, null, null);
        }

        public function getByUserId($userId)
        {
            return $this->get(null, null, $userId, null);
        }

        public function getByGistId($gistId)
        {
            return $this->get(null, null, null, $gistId);
        }

        public function getByUserAndPostId($postId ,$userId)
        {
            global $call_url;
            if(($postId && $userId) != null)
            {
				$extra = $this->like_url.'&filter[]=post_id,eq,'.$postId.'&filter[]=user_id,eq,'.$userId.'&satisfy=all';
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }
            return $response;
        }

        public function getByUserAndGistId($gistId ,$userId)
        {
            global $call_url;
            if(($gistId && $userId) != null)
            {
				$extra = $this->like_url.'&filter[]=gist_id,eq,'.$gistId.'&filter[]=user_id,eq,'.$userId.'&satisfy=all';
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }
            return $response;
        }

        public function getAll()
        {
			global $call_url;

			$extra = $this->like_url;
			$url = $call_url.$extra;
			$response = call('GET',$url);

			if ($response != null)
				return $response;
			else 
				return 'Error Occurred!!';
        }

		public function addNew($postId, $userId, $gistId)
        {
            global $call_url;

            $url = $call_url . 'like';
            if ($gistId == null) {
                $obj = '{"post_id": "' . $postId . '","user_id": ' . $userId . '}';
            } else {
                $obj = '{"user_id": ' . $userId . ',"gist_id": "' . $gistId . '"}';
            }

            $response = call('POST', $url, $obj);
            return $response;
        }

        public function deleteById($id)
        {
            global $call_url;

            $url = $call_url . 'like/'.$id;
            $response = call('DELETE', $url);
            return $response;
        }
    }