<?php
//HzQmFupxpKAUZO9Vd8M0
//http://162.144.129.26/~bedrockfs/agentdir/public/api/getAgentDetail
class adAPI
{
	private $token;
	private $url;
	private $limit;
	private $zipcode;
	private $zipcodetest;
	private $isPostLeadRequest;

	public function __CONSTRUCT()
	{
		##check cURL enable or not.
		if (!extension_loaded('curl'))
			throw new Exception('Please activate the PHP extension \'curl\' to allow use of Walmart webservice library');
		//$token =  
		//$this->get_tokan();
		$this->isPostLeadRequest = false;
		$this->url = 'http://13.233.30.19:5321/api/v2';
	}

	/* start new added by 24-04-2019 */
	public function getUserIP()
	{
		// Get real visitor IP behind CloudFlare network
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if (filter_var($client, FILTER_VALIDATE_IP)) {
			$ip = $client;
		} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
			$ip = $forward;
		} else {
			$ip = $remote;
		}

		return $ip;
	}

	/*-------------------------------------------------------- 
	 Auth API endpoints
	----------------------------------------------------------
	 */
	public function sendOtp($params)
	{
		$this->url .= "/auth/sendOtp";
		return  $this->make_api_call($params, "POST");
	}
	public function verifyOtp($params)
	{
		$this->url .= "/auth/verifyOtp";
		return  $this->make_api_call($params, "POST");
	}
	public function completeProfile($params, $token)
	{
		$this->url .= "/auth/completeProfile";
		return  $this->make_api_call($params, "POST", $token);
	}
	public function fetchProfile($token)
	{
		$this->url .= "/auth/fetchProfile";
		return  $this->make_api_call($params ='', "GET", $token);
	}
	public function editProfile($params,$token)
	{
		$this->url .= "/auth/editProfile";
		return  $this->make_api_call($params, "POST", $token);
	}
	public function logout($params, $token)
	{
		$this->url .= "/auth/logout";
		return  $this->make_api_call($params, "GET", $token);
	}

	/*-------------------------------------------------------- 
	User API endpoints 
	----------------------------------------------------------	 
	*/

	public function addAddress($params, $token)
	{
		$this->url .= "/user/addAddress";
		return $this->make_api_call($params, "POST", $token);
	}
	public function editAddress($params, $token)
	{
		$this->url .= "/user/editAddress";
		return $this->make_api_call($params, "POST", $token);
	}
	public function addressList($token)
	{
		$this->url .= "/user/addressList";
		return $this->make_api_call($params='', "GET", $token);
	}
	public function addressDetail($params, $token)
	{
		$this->url .= "/user/addressDetail";
		return $this->make_api_call($params, "POST", $token);
	}
	public function deleteAddress($params, $token)
	{
		$this->url .= "/user/deleteAddress";
		return $this->make_api_call($params, "POST", $token);
	}
	public function contactusSubjectList($params, $token)
	{
		$this->url .= "/user/contactusSubjectList";
		return $this->make_api_call($params, "GET", $token);
	}


	/*-------------------------------------------------------- 
	     Dish API endpoints 
	----------------------------------------------------------	 
	*/

	public function allergyList($params)
	{
		$this->url .= "/dish/allergyList";
		return $this->make_api_call($params, "GET");
	}

	public function categoryList()
	{
		$this->url .= "/dish/categoryList";
		return $this->make_api_call($params = null, "POST");
	}
	public function dishList($params)
	{
		$this->url .= "/dish/dishList";
		return $this->make_api_call($params, "POST");
	}
	public function bannerList($params)
	{
		$this->url .= "/dish/bannerList";
		return $this->make_api_call($params, "POST");
	}

	public function dishDetail($params)
	{
		$this->url .= "/dish/dishDetail";
		return $this->make_api_call($params, "POST");
	}
	
	private function make_api_call($params, $method, $token = '')
	{
		$encryptedtoken = '';
		//echo $token;
		if ($token) {
			$encryptedtoken = openssl_encrypt($token, ENCRYPTIONMETHOD, SECRET_KEY, 0, IV);
		}
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_ENCODING, '');
		curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'API-KEY:R9O3403D5xN4YMQwomG/Ng==',
			'TOKEN:' . $encryptedtoken,
			'Content-Type: text/plain'
		));

		if (('POST' == $method)) {
			//curl_setopt( $curl, CURLOPT_POST, true );
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		}
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}
}
