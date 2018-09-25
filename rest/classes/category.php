<?php

	require_once "call.php";

    class Category
    {

		public $category_url = 'category?transform=1';


		public function __construct(){}

        private function get($id, $title, $val)
        {
            $response = null;
            global $call_url;
            if($id != null)
            {
				$extra = $this->category_url.'&filter=id,eq,'.$id;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($title != null)
            {
				$extra = $this->category_url.'&filter=title,eq,'.$title;
				$url = $call_url.$extra;
				$response = call('GET',$url);
            }

            if($val != null)
            {
                $extra = $this->category_url.'&filter=followers,ge,'.$val;
                $url = $call_url.$extra;
                $response = call('GET',$url);
            }

			return $response;
        }

        public function getById($id)
        {
            return $this->get($id, null, null);
        }

        public function getByTitle($title)
        {
            return $this->get(null, $title, null);
        }

        public function getByFollowers($val)
        {
            return $this->get(null, null, $val);
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

        public function getTopCategory($page = 1, $arrange = 'desc'){
            global $call_url;
            $extra = $this->category_url . '&order=followers,' . $arrange . '&page=' . $page . ',5';
            $url = $call_url.$extra;
            $response = call('GET',$url);
            if ($response != null)
                return $response;
            else
                return 'Error Occurred!!';
        }

		public function addNew($title, $icon)
		{
			if ($title == null || $icon == null)
			{
				return 'Enter Appropriate values..!!';
			}
			else
			{
				global $call_url;

				$url = $call_url.'category';
				$obj = '{"title": "'.$title.'", "icon": "'.$icon.'"}';

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

	 	public function updateByFollowers($catId, $val)
	 	{
            global $call_url;
            $url = $call_url.'category/'.$catId;
            $obj = '{"followers": '.$val.'}';
            $response = call('PUT', $url, $obj);
            return $response;
	 	}
    }