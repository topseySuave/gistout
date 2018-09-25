<?php

	require_once "call.php";

    class TrendingHashtags
    {
		public $hashtag_url = 'trending_hashtag?transform=1';


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

        public function getAllByRate()
        {
            global $call_url;
            $extra = $this->hashtag_url.'&order=rate,desc';
            $url = $call_url.$extra;
            $response = call('GET',$url);
            if ($response != null)
                return $response;
            else
                return 'Error Occurred!!';
        }

        public function getByhashtagLike($content)
        {
            global $call_url;
            $extra = $this->hashtag_url.'&filter=hashtag,cs,'.$content;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
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
         if ($hashtag == '')
		 	{
		 		return 'Enter Appropriate values..!!';
		 	}
		 	else
		 	{
		 		global $call_url;

		 		$lastCount = 1;
		 		$recentCount = 1;
		 		$lastUpdate = date('Y-m-d H:i:s');
		 		$recentUpdate = date('Y-m-d H:i:s');
		 		$rate = 0;

		 		$url = $call_url.'trending_hashtag';
		 		$obj = '{
                             "hashtag": "'.$hashtag.'",
                             "last_count": '.$lastCount.',
                             "recent_count": '.$recentCount.',
                             "last_update": "'.$lastUpdate.'",
                             "recent_update": "'.$recentUpdate.'",
                             "rate": '.$rate.'
                         }';
		 		$response = call('POST', $url, $obj);
		 		return $response;
		 	}
		 }

	 	private function update($id, $hashtag, $lastCount, $recentCount, $lastUpdate, $recentUpdate, $rate)
	 	{
            global $call_url;

            if($hashtag != null){
                $url = $call_url.'trending_hashtag/'.$id;
                $obj = '{"hashtag": "'.$hashtag.'"}';
                $response = call('PUT', $url, $obj);
                return $response;
            }

            if($lastCount != null){
                $url = $call_url.'trending_hashtag/'.$id;
                $obj = '{"last_count": '.$lastCount.'}';
                $response = call('PUT', $url, $obj);
                return $response;
            }

            if($recentCount != null){
                $url = $call_url.'trending_hashtag/'.$id;
                $obj = '{"recent_count": '.$recentCount.'}';
                $response = call('PUT', $url, $obj);
                return $response;
            }

            if($lastUpdate != null){
                $url = $call_url.'trending_hashtag/'.$id;
                $obj = '{"last_update": '.$lastUpdate.'}';
                $response = call('PUT', $url, $obj);
                return $response;
            }

            if($recentUpdate != null){
                $url = $call_url.'trending_hashtag/'.$id;
                $obj = '{"recent_update": '.$recentUpdate.'}';
                $response = call('PUT', $url, $obj);
                return $response;
            }

            if($rate != null){
                $url = $call_url.'trending_hashtag/'.$id;
                $obj = '{"rate": '.$rate.'}';
                $response = call('PUT', $url, $obj);
                return $response;
            }
	 	}

	 	public function updateByHashTag($id, $hashtag)
	 	{
	 		return $this->update($id, $hashtag, null, null, null, null, null);
	 	}

        public function updateByLastCount($id, $lastCount)
        {
            return $this->update($id, null, $lastCount, null, null, null, null);
        }

        public function updateByRecentCount($id, $recentCount)
        {
            return $this->update($id, null, null, $recentCount, null, null, null);
        }

        public function updateByLastUpdate($id, $lastUpdate)
        {
            return $this->update($id, null, null, null, $lastUpdate, null, null);
        }

        public function updateByRecentUpdate($id, $recentUpdate)
        {
            return $this->update($id, null, null, null, null, $recentUpdate, null);
        }

        public function updateByRate($id, $rate)
        {
            return $this->update($id, null, null, null, null, null, $rate);
        }

        public function updateByHotFlag($id, $val, $date)
        {
            global $call_url;
            $url = $call_url.'trending_hashtag/'.$id;
            $obj = '{"hot_flag": '.$val.',"hot_flag_date": '.$date.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }
    }