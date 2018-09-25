<?php
	require_once "call.php";

	Class User
	{
		public $user_url = 'users?transform=1';

		public function __construct(){}

        /**
         * @return get data using the post data request from the database and
         * @return Appropriate data value.
         **/
		private function get($id, $key, $username, $email, $val)
		{
			global $call_url;
			if ($id != null)
			{
				$extra = $this->user_url.'&filter=id,eq,'.$id;
				$url = $call_url.$extra;
				$response = call('GET',$url);
			}
			if ($key != null)
			{
				$extra = $this->user_url.'&filter=user_key,eq,'.$key;
				$url = $call_url.$extra;
				$response = call('GET',$url);
			}

			if ($username != null)
			{
				$extra = $this->user_url.'&filter=username,eq,'.$username;
				$url = $call_url.$extra;
				$response = call('GET',$url);
			}

			if ($email != null)
			{
				$extra = $this->user_url.'&filter=email,eq,'.$email;
				$url = $call_url.$extra;
				$response = call('GET',$url);
			}

            if ($val != null)
            {
                $extra = $this->user_url.'&filter=user_points,ge,'.$val;
                $url = $call_url.$extra;
                $response = call('GET',$url);
            }

			return $response;
		}

		public function getByUserName($username)
		{
			return $this->get(null,null,$username,null,null);
		}

		public function getById($id)
		{
			return $this->get($id,null,null,null,null);
		}

		public function getByUserKey($key)
		{
			return $this->get(null,$key,null,null,null);
		}

		public function getByEmail($email)
		{
			return $this->get(null,null,null,$email,null);
		}

        public function getByPoints($val)
        {
            return $this->get(null,null,null,null,$val);
        }

        public function getByEmailAndPassword($email, $pass)
        {
            global $call_url;
            $extra = $this->user_url.'&filter[]=email,eq,'.$email.'&filter[]=password,eq,'.$pass;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        public function getByUserNameAndEmail($username, $email)
        {
            global $call_url;
            $extra = $this->user_url.'&filter[]=username,eq,'.$username.'&filter[]=email,eq,'.$email;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        public function getUserLike($user)
        {
            global $call_url;
            $extra = $this->user_url.'&filter=username,cs,'.$user;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        public function getDob($date, $page)
        {
            global $call_url;
            $extra = $this->user_url.'&filter=dob,cs,'.$date.'&order=id,desc&page='.$page;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

		public function getAll()
		{
			global $call_url;

			$extra = $this->user_url;
			$url = $call_url.$extra;
			$response = call('GET',$url);
			if ($response != null)
				return $response;
			else 
				return 'bad error';

		}

		public function addNew($key, $name, $email, $username, $password, $act_key, $color, $user_avatar, $online_status = 0)
		{
			if ($username == null || $email == null || $password == null)
			{
				return 'you must add username, email and password';
			}
			else
			{
				global $call_url;

				$joined = date('Y-m-d H:i:s');
				$url = $call_url.'users';
				$obj = '{
							"user_key": '.$key.',
							"email": "'.$email.'",
							"username": "'.$username.'",
							"password": "'.$password.'",
							"activation_key": "'.$act_key.'",
							"color": "'.$color.'",
							"user_avatar": "'.$user_avatar.'",
							"joined": "'.$joined.'",
							"online": '.$online_status.',
							"fullname": "'.$name.'"
						}';

				// $obj = json_decode($obj);
				$response = call('POST', $url, $obj);
				return $response;
			}
		}

		/**
         * @return data updated from the database Appropriate data value.
		**/
		private function update($id, $username, $followers, $following, $email, $pass, $dob)
		{
		    global $call_url;

            if($followers != null){
                if($followers <= -1)
                {
                    $followers = 0;
                }
                $url = $call_url.'users/'.$id;
                $obj = '{"followers": '.$followers.'}';

                $response = call('PUT', $url, $obj);

                return $response;
            }

            if($username != null){
                $url = $call_url.'users/'.$id;
                $obj = '{"user_name": "'.$username.'"}';

                $response = call('PUT', $url, $obj);

                return $response;
            }

            if($following != null){
                if($following <= -1){
                    $following = 0;
                }
                $url = $call_url.'users/'.$id;
                $obj = '{"following": '.$following.'}';

                $response = call('PUT', $url, $obj);

                return $response;
            }

            if($email != null){
                $url = $call_url.'users/'.$id;
                $obj = '{"email": "'.$email.'"}';
                $response = call('PUT', $url, $obj);
                return $response;
            }

            if($pass != null){
                $url = $call_url.'users/'.$id;
                $obj = '{"password": "'.$pass.'"}';
                $response = call('PUT', $url, $obj);
                return $response;
            }

            if($dob != null){
                $url = $call_url.'users/'.$id;
                $obj = '{"dob": "'.$dob.'"}';
                $response = call('PUT', $url, $obj);
                return $response;
            }

		}

        public function updateByEmail($id, $email)
        {
            return $this->update($id, null, null, null, $email, null, null);
        }

		public function updateByUserName($id, $username)
		{
			return $this->update($id, $username, null, null, null, null, null);
		}

        public function updateByPassword($id, $pass)
        {
            return $this->update($id, null, null, null, null, $pass, null);
        }

        public function updateByDob($id, $dob)
        {
            return $this->update($id, null, null, null, null, null, $dob);
        }

        public function updateByfollowers($id, $followers)
        {
            if($followers == null){
                $followers = -1;
            }
            return $this->update($id, null, $followers, null, null, null, null);
        }

        public function updateByfollowing($id, $following)
        {
            if($following == null){
                $following = -1;
            }
            return $this->update($id, null, null, $following, null, null, null);
        }

        public function updateByOnline($id, $val)
        {
            global $call_url;
            $url = $call_url.'users/'.$id;
            $obj = '{"online": '.$val.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        public function updateByLastSeen($id)
        {
            global $call_url;
            $url = $call_url.'users/'.$id;
            $time = date('Y-m-d H:i:s');
            $obj = '{"last_seen": '.$time.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        public function updateByUserPoint($id, $val)
        {
            global $call_url;
            $url = $call_url.'users/'.$id;
            $obj = '{"user_points": '.$val.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        public function updateByUserAvatar($id, $path)
        {
            global $call_url;
            $url = $call_url.'users/'.$id;
            $obj = '{"user_avatar": "'.$path.'"}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        public function updateByFullname($id, $fullname)
        {
            global $call_url;
            $url = $call_url.'users/'.$id;
            $obj = '{"fullname": "'.$fullname.'"}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        public function updateByBio($id, $bio)
        {
            global $call_url;
            $url = $call_url.'users/'.$id;
            $obj = '{"bio": "'.$bio.'"}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        public function updateByWebsite($id, $website)
        {
            global $call_url;
            $url = $call_url.'users/'.$id;
            $obj = '{"website": "'.$website.'"}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        public function updateByColor($id, $color)
        {
            global $call_url;
            $url = $call_url.'users/'.$id;
            $obj = '{"color": "'.$color.'"}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        public function updateActive($id)
        {
            global $call_url;
            $url = $call_url.'users/'.$id;
            $obj = '{"active": 1}';
            $response = call('PUT', $url, $obj);
            return $response;
        }
	}