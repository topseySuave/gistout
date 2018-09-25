<?php
	require_once "call.php";

    class Gists
    {

		public $gist_url = 'gists?transform=1';


		public function __construct(){}

        private function get($id, $title, $catId, $userId, $page = 1, $arrang = 'desc', $limit = 20)
        {
            $response = null;
            global $call_url;
            if($id != null)
            {
				$extra = $this->gist_url.'&filter=id,eq,'.$id.'order=last_updated,'.$arrang;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($title != null)
            {
				$extra = $this->gist_url.'&filter=title,eq,'.$title;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($catId != null)
            {
				$extra = $this->gist_url.'&filter=category_id,eq,'.$catId.'&order=id,'.$arrang.'&page='.$page.','.$limit;
				$url = $call_url.$extra;
				$response = call('GET', $url);
            }

            if($userId != null)
            {
				$extra = $this->gist_url.'&filter=user_id,eq,'.$userId.'&order=id,'.$arrang.'&page='.$page;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

			return $response;
        }

        public function getById($id)
        {
            return $this->get($id, null, null, null);
        }

        public function getByTitle($title)
        {
            return $this->get(null, $title, null, null);
        }

        public function getByCatId($catId, $page = 1, $limit = 20)
        {
            return $this->get(null, null, $catId, null, $page, $limit);
        }

        public function getByUserId($userId)
        {
            return $this->get(null, null, null, $userId);
        }

        public function getByContentLike($content)
        {
            global $call_url;

            $extra = $this->gist_url.'&filter=content,sw,'.$content;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        public function getByHot($page = 1)
        {
            global $call_url;
            $extra = $this->gist_url.'&filter=hot_flag,eq,1&order=hot_flag_date,desc&page='.$page;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        public function getByHotCat($catID)
        {
            global $call_url;
            if($catID != null)
            {
                $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catID.'&filter[]=hot_flag,eq,1&order=hot_flag_date,desc&page=1';
                $url = $call_url.$extra;
                $response = call('GET',$url);
                return $response;
            }
        }

        public function getByMoreHotCat($catId, $lastID)
        {
            global $call_url;
            if($catId != null)
            {
                $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catId.'&filter[]=id,gt,'.$lastID.'&filter[]=hot_flag,eq,1&order=hot_flag_date,desc';
                $url = $call_url.$extra;
                $response = call('GET',$url);
                return $response;
            }
        }

        public function getByTrend()
        {
            global $call_url;
            $extra = $this->gist_url.'&filter=hot_flag,eq,1&order=trend_flag_date,desc';
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        public function getByTrendCat($catID)
        {
            global $call_url;
            if($catID != null)
            {
                $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catID.'&filter[]=trend_flag,eq,1&order=trend_flag_date,desc&page=1';
                $url = $call_url.$extra;
                $response = call('GET',$url);
                return $response;
            }
        }

        public function getByMoreTrendCat($catId, $lastID)
        {
            global $call_url;
            if($catId != null)
            {
                $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catId.'&filter[]=id,gt,'.$lastID.'&filter[]=trend_flag,eq,1&order=trend_flag_date,desc';
                $url = $call_url.$extra;
                $response = call('GET',$url);
                return $response;
            }
        }

        public function getByLastUpdated()
        {

        }

        public function getByLastUpdatedCat($catId)
        {
            global $call_url;
            if($catId != null)
            {
                $date = date('Y-m');
//                $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catId.'&filter[]=last_updated,cs,'.$date.'&order=last_updated,desc&page=1';
                $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catId.'&order=last_updated,desc&page=1';
                $url = $call_url.$extra;
                $response = call('GET',$url);
                return $response;
            }
        }

        public function getByShares($catID)
        {
            global $call_url;
            if($catID != null)
            {
                $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catID.'&filter[]=shares,gt,100&order=id,desc&page=1';
                $url = $call_url.$extra;
                $response = call('GET',$url);
                return $response;
            }
        }

        public function getByCreated($catID)
        {
            global $call_url;
            if($catID != null)
            {
                $time = date('Y-m-d');
                $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catID.'&filter[]=created,cs,"'.$time.'"&order=id,desc&page=1';
                $url = $call_url.$extra;
                $response = call('GET',$url);
                return $response;
            }
        }

        public function getByNewest($catID, $greater, $less = 0)
        {
            global $call_url;
            if($catID != null)
            {
                $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catID.'&filter[]=likes,ge,'.$greater.'&filter[]=likes,le,'.$less.'&order=id,desc';
                $url = $call_url.$extra;
                $response = call('GET',$url);
                return $response;
            }
        }

        public function getLastNewest($catID, $lastId, $greater, $less = 0)
        {
            global $call_url;
            if($catID != null)
            {
                $extra = $this->gist_url.'&filter[]=id,gt,'.$lastId.'&filter[]=category_id,eq,'.$catID.'&filter[]=likes,ge,'.$greater.'&filter[]=likes,le,'.$less.'&order=id,desc';
                $url = $call_url.$extra;
                $response = call('GET',$url);
                return $response;
            }
        }

        public function getByLCId($catId, $lastId)
        {
            global $call_url;
            $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catId.'&filter[]=id,gt,'.$lastId.'&satisfy=all';
            $url = $call_url.$extra;
            $response = call('GET',$url);

            return $response;
        }

        public function getByLlastUpdatedCat($catId, $lastId, $date)
        {
            global $call_url;
            $extra = $this->gist_url.'&filter[]=category_id,eq,'.$catId.'&filter[]=id,gt,'.$lastId.'&filter[]=last_updated,cs,'.$date.'&satisfy=all';
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        public function getAll($page = 1)
        {
			global $call_url;

			$extra = $this->gist_url.'&order=id,desc&page='.$page;
			$url = $call_url.$extra;
			$response = call('GET',$url);

			if ($response != null)
				return $response;
			else 
				return 'Error Occurred!!';
        }

		public function addNew($title, $catId, $userId, $content, $imgUrl)
		{
			if ($title == null || $catId == null || $userId == null || $content == null)
			{
				return 'Please Some Values Were missing';
			}
			else
			{
				global $call_url;

				// Set created to The current date and time.... 
                $created = date('Y-m-d H:i:s');

				$url = $call_url.'gists';
				$obj = '{
							"title": "'.$title.'",
							"category_id": '.$catId.',
							"user_id": '.$userId.',
							"content": "'.$content.'",
							"image": "'.$imgUrl.'",
							"created": "'.$created.'",
							"last_updated": "'.$created.'"
						}';
				// $obj = json_decode($obj);
				$response = call('POST', $url, $obj);
				return $response;
			}
		}

        private function update($gistid, $like, $content, $share, $quote, $posts, $followers, $views, $last_updated)
        {
            global $call_url;

            if($like != null)
            {
                if($like == -1)
                {
                    $like = 0;
                }
                $url = $call_url.'gists/'.$gistid;
                $obj = '{"likes": "'.$like.'"}';

                $response = call('PUT', $url, $obj);
            }

            if($content != null)
            {
                $url = $call_url.'gists/'.$gistid;
                $obj = '{"content": "'.$content.'"}';

                $response = call('PUT', $url, $obj);
            }

            if($share != null)
            {
                $url = $call_url.'gists/'.$gistid;
                $obj = '{"shares": "'.$share.'"}';

                $response = call('PUT', $url, $obj);
            }

            if($quote != null)
            {
                $url = $call_url.'gists/'.$gistid;
                $obj = '{"quotes": "'.$quote.'"}';

                $response = call('PUT', $url, $obj);
            }

            if($posts != null)
            {
                $url = $call_url.'gists/'.$gistid;
                $obj = '{"posts": "'.$posts.'"}';

                $response = call('PUT', $url, $obj);
            }

            if($followers != null)
            {
                if($followers <= -1)
                {
                    $followers = 0;
                }
                $url = $call_url.'gists/'.$gistid;
                $obj = '{"followers": "'.$followers.'"}';

                $response = call('PUT', $url, $obj);
            }

            if($views != null)
            {
                $url = $call_url.'gists/'.$gistid;
                $obj = '{"views": "'.$views.'"}';

                $response = call('PUT', $url, $obj);
            }

            if($last_updated != null)
            {
                $url = $call_url.'gists/'.$gistid;
                $obj = '{"last_updated": "'.$last_updated.'"}';

                $response = call('PUT', $url, $obj);
            }

            return $response;
        }

        public function updateByLikes($gistid, $val)
        {
            if($val <= 0)
            {
                $val = -1;
            }
            return $this->update($gistid, $val, null, null, null, null, null, null, null);
        }

        public function updateByContent($gistid, $content)
        {
            return $this->update($gistid, null, $content, null, null, null, null, null, null);
        }

        public function updateByShares($gistid, $val)
        {
            return $this->update($gistid, null, null, $val, null, null, null, null, null);
        }

        public function updateByQuotes($gistid, $val)
        {
            return $this->update($gistid, null, null, null, $val, null, null, null, null);
        }

        public function updateByPosts($gistid, $val)
        {
            return $this->update($gistid, null, null, null, null, $val, null, null, null);
        }

        public function updateByFollowers($gistid, $val)
        {
            if($val <= 0)
            {
                $val = -1;
            }
            return $this->update($gistid, null, null, null, null, null, $val, null, null);
        }

        public function updateByViews($gistid, $val)
        {
            return $this->update($gistid, null, null, null, null, null, null, $val, null);
        }

        public function updateByLastUpdated($gistid, $time)
        {
            return $this->update($gistid, null, null, null, null, null, null, null, $time);
        }

        public function updateByHot($gistId, $val){
		    global $call_url;
		    $dateTime =  date('Y-m-d h:i:s');
            $url = $call_url.'gists/'.$gistId;
            $obj = '{"hot_flag": '.$val.', "hot_flag_date": "'.$dateTime.'"}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        public function updateTrendingFlag($gistId, $val){
            global $call_url;
            $dateTime =  date('Y-m-d h:i:s');
            $url = $call_url.'gists/'.$gistId;
            $obj = '{"trend_flag": '.$val.', "trend_flag_date": "'.$dateTime.'"}';
            $response = call('PUT', $url, $obj);
            return $response;
        }
    }