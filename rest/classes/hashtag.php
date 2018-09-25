<?php

	require_once "call.php";

    class Hashtag
    {

		public $hashtag_url = 'hashtag?transform=1';


		public function __construct(){}

        private function get($hashtagId, $tag)
        {
            global $call_url;
            if($hashtagId != null)
            {
				$extra = $this->hashtag_url.'&filter=id,eq,'.$hashtagId;
				$url = $call_url.$extra;
				$response = call('GET', $url);
            }
            
            if($tag != null)
            {
				$extra = $this->hashtag_url.'&filter=hashtag,eq,'.$tag;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

			return $response;
        }

        public function getById($hashtagId)
        {
            return $this->get($hashtagId, null, null);
        }

        public function getByhashtag($hashtag)
        {
            return $this->get(null, $hashtag);
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

		public function addNew($hashtag)
		{
        if ($hashtag == null)
			{
				return 'Enter Appropriate values..!!';
			}
			else
			{
				global $call_url;

				$url = $call_url.'hashtag';
				$obj = '{
                            "hashtag": '.$hashtag.'
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