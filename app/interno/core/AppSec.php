<?php

	class AppSec
	{
		protected $_response  = array('Content-Type'=>'Content-type: application/x-www-form-urlencoded');
		protected $controller = null;
		protected $method     = "POST";
		protected $args       = array();
		protected $function   = null;
		protected $type       = null;
		protected $url        = null;
		protected $context    = null;

		
		public function response()
		{
			$this->type = "RESPONSE";
			$this->method = "GET";
			return $this;
		}

		public function POST()
		{
			$this->type = "REQUEST";
			$this->method = "POST";						
			return $this;
		}

		public function header($field,$value)
		{
			$this->_response[$field] = $value;
			return $this;
		}	

		public function getHeader($field)
		{
			return $this->_response[$field];
		}	

		public function get($controller,$method,array $args=[])
		{			
			$method_type =  trim(strtoupper(gettype($method)));
			switch ($method_type) 
			{
				case 'STRING':
					$this->function = false;
					$this->controller = $controller;
					$this->method     = 'get'.$method;
					$this->args       = $args;
					break;
				case 'OBJECT':
					$this->function = true;				
					$this->controller = null;
					$this->method     = $method;
					$this->args       = $args;
					call_user_func_array($method,$args);	
					break;				
				default:
					return false;
					break;
			}
		}

		public function run()
		{
			if(trim($this->type=="RESPONSE"))
			{
				header($this->getHeader('Content-Type'));
				if($this->function)
					return call_user_func_array($this->method,$this->args);	
				else
					return call_user_func_array([$this->controller,$this->method],$this->args);
			}
			elseif(trim($this->type=="REQUEST"))
			{
				return file_get_contents($this->url, false, $this->context);

			}
		}


		public function with($info = [])
		{
			$this->url= $info['URL'];
			$data = http_build_query($info['DATA']);
		    $request = array('http' =>
						          array(
						              'method'  => $this->method,
						              'header'  => $this->getHeader('Content-Type'),
						              'content' => $data
						          )
		      			);
		    $this->context  = stream_context_create($request);
		    return $this;
		}

		
	}