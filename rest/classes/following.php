<?php

	require_once "call.php";

    class Following
    {
		public $following_url = 'following?transform=1';

		public function __construct(){}

        private function get($id, $followers_id, $followed_id, $page = 1, $arrange = 'desc')
        {
            global $call_url;
            $response = null;
            if($id != null)
            {
				$extra = $this->following_url.'&filter=id,eq,'.$id.'&order=id,'.$arrange.'&page='.$page;
				$url = $call_url.$extra;
				$response = call('GET', $url);
            }
            if($followers_id != null)
            {
				$extra = $this->following_url.'&filter=followers_id,eq,'.$followers_id.'&order=id,'.$arrange.'&page='.$page;
				$url = $call_url.$extra;
				$response = call('GET', $url);
            }
            
            if($followed_id != null)
            {
				$extra = $this->following_url.'&filter=followed_id,eq,'.$followed_id.'&order=id,'.$arrange.'&page='.$page;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

			return $response;
        }

        public function getById($id)
        {
            return $this->get($id, null, null);
        }

        public function getByFollowerId($followerId)
        {
            return $this->get(null, $followerId, null);
        }

        public function getByFollowedId($followedId)
        {
            return $this->get(null, null, $followedId);
        }

        public function getByFollowedAndFollowerId($follower, $followed)
        {
            global $call_url;
            if(($follower && $followed) != null)
            {
                $extra = $this->following_url.'&filter[]=followers_id,eq,'.$follower.'&filter[]=followed_id,eq,'.$followed.'&satisfy=all';
                $url = $call_url.$extra;
                $response = call('GET',$url);
                return $response;
            }
        }

        public function getAll()
        {
			global $call_url;

			$extra = $this->following_url;
			$url = $call_url.$extra;
			$response = call('GET',$url);

			if ($response != null)
				return $response;
			else 
				return 'Error Occurred!!';
        }

		public function addNew($followerId, $followedId)
		{
            if ($followerId == null || $followedId == null)
			{
				return 'Enter Appropriate values..!!';
			}
			else
			{
				global $call_url;

				$url = $call_url.'following';
				$obj = '{"followers_id": '.$followerId.', "followed_id": '.$followedId.'}';
				$response = call('POST', $url, $obj);
				return $response;
			}
		}

	 	private function update($id, $followers, $followed)
	 	{
            global $call_url;

            if($followers != null)
            {
                if($followers == -1){
                    $followers = 0;
                }
                $url = $call_url.'following/'.$id;
                $obj = '{"followers_id": '.$followers.'}';

                $response = call('PUT', $url, $obj);
                return $response;
            }

            if($followed != null)
            {
                if($followed == -1){
                    $followed = 0;
                }
                $url = $call_url.'following/'.$id;
                $obj = '{"followed_id": '.$followed.'}';

                $response = call('PUT', $url, $obj);
                return $response;
            }
	 	}

	 	public function updateByFollowers($id, $followers)
	 	{
            if($followers == null){
                $followers = -1;
            }
	 		return $this->update($id, $followers, null);
	 	}

	 	public function updateByFollowed($id, $followed)
	 	{
	 	    if($followed == null){
	 	        $followed = -1;
            }
	 		return $this->update($id, null, $followed);
	 	}

        public function deleteById($id)
        {
            global $call_url;
            $url = $call_url . 'following/'.$id;
            $response = call('DELETE', $url);
            return $response;
        }
    }