<?php

	require_once "call.php";

    Class Posts
    {

		public $post_url = 'posts?transform=1';


		public function __construct(){}

        private function get($id, $gistId, $catId, $quoteId, $title, $page = 1, $arrange = 'asc')
        {
            $response = null;
            global $call_url;
            if($id != null)
            {
				$extra = $this->post_url.'&filter=id,eq,'.$id.'&order=id,'.$arrange;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }
            if($gistId != null)
            {
				$extra = $this->post_url.'&filter=gist_id,eq,'.$gistId.'&order=id,'.$arrange.'&page='.$page;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($title != null)
            {
				$extra = $this->post_url.'&filter=title,eq,'.$title.'&order=id,'.$arrange;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($catId != null)
            {
				$extra = $this->post_url.'&filter=category,eq,'.$catId.'&order=id,'.$arrange;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($quoteId != null)
            {
				$extra = $this->post_url.'&filter=id,eq,'.$quoteId.'&order=id,'.$arrange;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

			return $response;
        }

        public function getById($id)
        {
            return $this->get($id, null, null, null, null);
        }

        public function getByGistId($gistId, $page)
        {
            return $this->get(null, $gistId, null, null, null, $page);
        }

        public function getByTitle($title)
        {
            return $this->get(null, null, null, null, $title);
        }

        public function getByCatId($catId)
        {
            return $this->get(null, null, $catId, null, null);
        }

        public function getByQuoteId($quoteId)
        {
            return $this->get(null, null, null, $quoteId, null);
        }

        public function getByIdGrt($gistId, $lastId)
        {
            global $call_url;

            $extra = $this->post_url.'&filter[]=gist_id,eq,'.$gistId.'&filter[]=id,gt,'.$lastId.'&satisfy=all';
            $url = $call_url.$extra;
            $response = call('GET',$url);

            return $response;
        }

        public function getByContentLike($content)
        {
            global $call_url;
            $extra = $this->post_url.'&filter=content,sw,'.$content;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        public function getAll($page)
        {
			global $call_url;

			$extra = $this->post_url.'&order=id,desc&page='.$page;
			$url = $call_url.$extra;
			$response = call('GET',$url);
			if ($response != null)
				return $response;
			else 
				return 'Error Occurred!!';
        }

		public function addNew($unique, $gistId, $content, $userId, $fileUrl, $quoteId = null)
		{
			if ($unique == null || $gistId == null || $content == null || $userId == null)
			{
				return 'Enter Appropriate values..!!';
			}
			else
			{
				global $call_url;
				// Set created to The current date and time.... 
                $created = date('Y-m-d H:i:s');
				if($quoteId == null)
                {
                    $url = $call_url.'posts';
                    $obj = '{"unique_id": "'.$unique.'", "gist_id": "'.$gistId.'","content": "'.$content.'", "img_path": "'.$fileUrl.'", "user_id": '.$userId.', "created": "'.$created.'"}';
                }
                else
                {
                    $quotes = 1;
                    $url = $call_url.'posts';
                    $obj = '{"unique_id": "'.$unique.'", "gist_id": '.$gistId.',"content": "'.$content.'", "img_path": "'.$fileUrl.'", "user_id": '.$userId.', "quotes": '.$quotes.', "quote_id": '.$quoteId.', "created": "'.$created.'"}';
                }

				$response = call('POST', $url, $obj);
				return $response;
			}
		}

		private function update($postid, $unique, $like, $content, $share, $quote)
		{
		    $response = null;
            global $call_url;
            if($unique != null)
            {
                $url = $call_url.'posts/'.$postid;
                $obj = '{"unique_id": "'.$unique.'"}';
                $response = call('PUT', $url, $obj);
            }

            if($content != null)
            {
                $url = $call_url.'posts/'.$postid;
                $obj = '{"content": "'.$content.'"}';
                $response = call('PUT', $url, $obj);
            }

            if($like != null)
            {
                if($like == -1){
                    $like = 0;
                }
                $url = $call_url.'posts/'.$postid;
                $obj = '{"likes": '.$like.'}';
                $response = call('PUT', $url, $obj);
            }

            if($share != null)
            {
                $url = $call_url.'posts/'.$postid;
                $obj = '{"shares": '.$share.'}';
                $response = call('PUT', $url, $obj);
            }

            if($quote != null)
            {
                $url = $call_url.'posts/'.$postid;
                $obj = '{"quotes": '.$quote.'}';
                $response = call('PUT', $url, $obj);
            }
            return $response;
		}

		public function updateByLikes($postid, $val)
		{
		    if($val <= 0)
            {
                $val = -1;
            }
			return $this->update($postid, null, $val, null, null, null);
		}

		public function updateByContent($postid, $content)
		{
			return $this->update($postid, null, null, $content, null, null);
		}

		public function updateByShares($postid, $val)
		{
			return $this->update($postid, null, null, null, $val, null);
		}

		public function updateByQuotes($postid, $val)
		{
			return $this->update($postid, null, null, null, null, $val);
		}

        public function updateByUniqueId($postid, $val)
        {
            return $this->update($postid, $val, null, null, null, null);
        }
    }