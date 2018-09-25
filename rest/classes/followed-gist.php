<?php

//    namespace \FollowedGist::class;

	require_once "call.php";

    class FollowedGist
    {
		public $followedGist_url = 'followed_gists?transform=1';

		public function __construct(){}

        private function get($id, $gistId, $gistUser, $userId)
        {
            global $call_url;
            $response = null;
            if($id != null){
				$extra = $this->followedGist_url.'&filter=id,eq,'.$id;
				$url = $call_url.$extra;
				$response = call('GET', $url);
            }

            if($gistId != null)
            {
				$extra = $this->followedGist_url.'&filter=gist_id,eq,'.$gistId;
				$url = $call_url.$extra;
				$response = call('GET', $url);
            }

            if($gistUser != null)
            {
                $extra = $this->followedGist_url.'&filter=gist_user,eq,'.$gistUser;
                $url = $call_url.$extra;
                $response = call('GET', $url);
            }
            
            if($userId != null)
            {
				$extra = $this->followedGist_url.'&filter=user_id,eq,'.$userId;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

			return $response;
        }

        public function getById($id)
        {
            return $this->get($id, null, null, null);
        }

        public function getByGistId($gistId)
        {
            return $this->get(null, $gistId, null, null);
        }

        public function getByGistUser($gistUser)
        {
            return $this->get(null, null, $gistUser, null);
        }

        public function getByUserId($userId)
        {
            return $this->get(null, null, null, $userId);
        }

        public function getByUserAndGistId($gistId ,$userId)
        {
            global $call_url;
            if(($gistId && $userId) != null)
            {
                $extra = $this->followedGist_url.'&filter[]=gist_id,eq,'.$gistId.'&filter[]=user_id,eq,'.$userId.'&satisfy=all';
                $url = $call_url.$extra;
                $response = call('GET',$url);
            }
            return $response;
        }

        public function getAll()
        {
			global $call_url;

			$extra = $this->followedGist_url;
			$url = $call_url.$extra;
			$response = call('GET',$url);

			if ($response != null)
				return $response;
			else
				return 'Error Occurred!!';
        }

		public function addNew($gistId, $gistUser, $userId)
		{
            if($gistId == null || $gistUser == null || $userId == null)
			{
				return 'Enter Appropriate values..!!';
			}
			else
			{
				global $call_url;

				$url = $call_url.'followed_gists';
				$obj = '{"gist_id": '.$gistId.', "gist_user": '.$gistUser.', "user_id": '.$userId.'}';

				$response = call('POST', $url, $obj);
				return $response;
			}
		}

        public function deleteById($id)
        {
            global $call_url;

            $url = $call_url . 'followed_gists/'.$id;
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
    }