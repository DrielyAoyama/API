<?php

	class AppSec
	{
		protected $_response  = array('Content-Type'=>null);
		protected $controller = null;
		protected $method     = null;
		protected $args       = array();
		protected $function   = null;

		
		public function response()
		{
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

		public function post($controller,$method,array $args=[])
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
			header($this->getHeader('Content-Type'));
			if($this->function)
				return call_user_func_array($this->method,$this->args);	
			else
				return call_user_func_array([$this->controller,$this->method],$this->args);
		}
		
		
	}