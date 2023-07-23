<?php 
//HzQmFupxpKAUZO9Vd8M0
//http://162.144.129.26/~bedrockfs/agentdir/public/api/getAgentDetail
class adAPI {
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
		throw new Exception( 'Please activate the PHP extension \'curl\' to allow use of Walmart webservice library' );
		//$token =  
		$this->get_tokan();
		$this->isPostLeadRequest = false;
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

		    if(filter_var($client, FILTER_VALIDATE_IP))
		    {
		        $ip = $client;
		    }
		    elseif(filter_var($forward, FILTER_VALIDATE_IP))
		    {
		        $ip = $forward;
		    }
		    else
		    {
		        $ip = $remote;
		    }

		    return $ip;
	}
	/* end new added by 24-04-2019 */ 	

	public function get_tokan()
	{
		 $options = get_option( 'agentdir_options' );
		/* echo "<pre>";
		 print_r($options);
		 die();*/
		 $this->token = $options['agentdirtokan'];
		 if(!IS_DUMMY_WEBSTIE){
		 	$this->zipcode = isset($options['defaultzipcode'])?$options['defaultzipcode']:'';
		 }
		 $this->limit = (empty($options['agentdirlimit']))?$options['agentdirlimit']:$options['agentdirlimit'];
		 $this->url   = $options['apiurl'];
	}
	

	public function getPrimaryTopic(){
		$this->isPostLeadRequest = true;
		$this->url .= "V2/wp/get-primary-topic";
		$params['token'] = $this->token;
		return  $this->make_api_call($params,"POST");
	}

	public function searchAgentList($params,$offset=1,$limit=10)
	{
		$addQuery = '';
		if(array_key_exists('page', $params)){
			$addQuery = '?page='.$params['page'];
		}

		$this->url .= "wp/wp-get-agent".$addQuery;
		
		/*if(!array_key_exists('limit',$params))
		{
			$params['limit'] = $this->limit;
		}*/


		
		// $params['token'] = $this->token;
		
		// if(!array_key_exists('zip_code',$params))
		// {
		// 	$params['zip_code'] = $this->zipcode;
		// }	
		
		$params['token'] = $this->token;

		/* start new added by 24-04-2019 */ 

		//$params['ip_address'] = $this->getUserIP();
		/*echo "<pre>";
		var_dump($this->url);
		print_r($params);
		die();*/
		/* end new added by 24-04-2019 */ 
		//print_r($params);die();
		return  $this->make_api_call($params,"POST");
	}

	public function getAgentList($params,$offset=1,$limit=10)
	{
		$addQuery = '';
		if(array_key_exists('page', $params)){
			//$params['page'] = $params['page'];
		}

		$this->url .= "wp/wp-get-agent".$addQuery;
		//var_dump($this->url);die();
		/*if(!array_key_exists('limit',$params))
		{
			$params['limit'] = $this->limit;
		}*/
		
		$params['token'] = $this->token;
		//var_dump($params);die();
		/*if(!array_key_exists('zipcode',$params))
		{
			$params['zipcode'] = $this->zipcode;
		}	*/
		/*echo "<pre>";
		print_r($params);
		var_dump($this->url);*/
		return  $this->make_api_call($params,"POST");
		//die();
	}
	
	public function get_agent_by_id($params,$offset=1,$limit=10)
	{
		$this->url .= "wp/wp-get-agent";
		$params['token'] = $this->token;
		return $this->make_api_call($params,"POST");
	}

	public function postLeadAddReview($params){
		
		$this->url .= "V2/wp/add-reviews";
		$params['token'] = $this->token;
		return $this->make_api_call($params,"POST");

	}
	
	public function postLeadAdd($params)
	{
		$this->url .= "wp/add-lead";
		$this->isPostLeadRequest = true;
		// echo "<pre>";
		// print_r($params);
		// die();
		$params['token'] = $this->token;
		return $this->make_api_call($params,"POST");
	}
	
	public function registrationLink($params){
		//$this->url .= "/wp/registration-link"; Updated respose 02-Jun-2021
		$this->url .= "V2/wp/add-user";
		$this->isPostLeadRequest = true;
		$params['token'] = $this->token;
		return $this->make_api_call($params,"POST");
	}

	public function getAgentByID($params)
	{
		$this->url .= "wp/get-agent-detail";
		$params['token'] = $this->token;
		//print_r($params);
		//$params['agentId'] = $this->token;
		return $this->make_api_call($params,"POST");
	}
	/*if(IS_DUMMY_WEBSTIE){
		public function putPostEditContent($params){
		$this->url .= "wp/wp-edit-article";
		$params['token'] = 'l1IreAXMrNdbKCK2VeWrYmY1upGl9Q';

		//$params['agentId'] = $this->token;
	    /*    print_r($params);
	        die();*/
			/*return $this->make_api_call($params,"POST");
		}
	}else{
		public function scheduleToPublishPost($params){
		    $this->url .= "wp/schedule-to-publish";
		    $params['token'] = $this->token;
		    return $this->make_api_call($params,"POST");
		}

	}*/
	
	

	private function make_api_call($params,$method)
	{
		$curl = curl_init( $this->url);
		curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);   
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);            
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,30);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        if ( ('POST' === $method || 'PUT' === $method)) {
            curl_setopt( $curl, CURLOPT_POST, true );
            curl_setopt( $curl, CURLOPT_POSTFIELDS, $params);
        }

        $response = curl_exec($curl);
		$http_status = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $header_size);
        $responseBody = substr($response, $header_size);
    
        if ($http_status == 200 || $http_status == 201) { 
            $return =json_decode( $responseBody);
            curl_close($curl);
		}
        else 
        {
            if($http_status!=0) 
            {
            	if(!$this->isPostLeadRequest){
	            	$responseError = json_decode( $responseBody,true);
				    $message = (isset($responseError['errors']['error'][0]['description']) && $responseError['errors']['error'][0]['description'])?$responseError['errors']['error'][0]['description']:$responseError['errors']['error'][0]['info'];
		            $return = '{"errors":[{"code":"' . $http_status . '","message":"' . $message . '","type":"' . $responseError['errors']['error'][0]['code'] . '"}]}';	
            	}else{
            		$return =  $responseBody;
            	}
				
            } 
            else 
            {
                $return = '{"errors":[{"code":"' . curl_errno($curl) . '","message":"cURL Request error: ' . curl_error($curl) . '"}]}';
            }
            curl_close($curl);
            $return = json_decode( $return);


        }
        /*print_r($return);
        echo "</pre>";*/
        return $return;
   }
}

?>