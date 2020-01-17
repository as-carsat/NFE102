<?php

	class paypal{
		
		private $user='vendeur59100_api1.yahoo.com';
		private $pwd='N4HTYQ6DWTNX95DH';
		private $signature='AFcWxV21C7fd0v3bYYYRCpSSRl31AHZX5Pgzux4okbVA1sd21K9A9PLX';
		public $endpoint='https://api-3T.sandbox.paypal.com/nvp';
		public $errors =array();
		
		
		public function __construct($user = false, $pwd = false, $signature = false, $prod = false){
			
			if($user){
				
				$user= $this->user;
			}
			
			if($pwd){
			
				$pwd= $this->pwd;
			}
			
			if($signature){
			
				$signature= $this->signature;
			}
			
			if($prod){
			
				$this->endpoint = str_replace('sandbox.','', $this->endpoint);
			}
			
		}
			
		 public function request($method, $params){
			
			$params = array_merge($params, array(
					'METHOD' => $method,
					'VERSION'=>'204',
					'USER'=> $this->user,
					'PWD'=> $this->pwd,
					'SIGNATURE'=> $this->signature
			));
			
			$params= http_build_query($params);
			
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
					CURLOPT_URL =>$this->endpoint,
					CURLOPT_POST =>1,
					CURLOPT_POSTFIELDS => $params,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_SSL_VERIFYPEER => 0,
					CURLOPT_SSL_VERIFYHOST => 0,
					CURLOPT_VERBOSE => 1,
			));
			
			$response = curl_exec($curl);
			parse_str($response, $responseArray);
			
			if(curl_errno($curl)){
				
				$this->errors = curl_error($curl);
				curl_close($curl);
				return false;
			}else{
				
				if($responseArray['ACK']=='Success'){
				curl_close($curl);
				return $responseArray;
				}else{
					
					$this->errors = curl_error($curl);
					curl_close($curl);
					return false;
				}
			}
		}
		}
	