<?php
	class Simon 
	{
		public $key= array();
		public $z  = array();
		public $WORD_SIZE  = null;
		public $KEY_WORDS  = null;
		public $ROUNDS  = null;
		public $CONST_J  = null;
		protected $texto;
		function __construct($texto)
		{
			$this->texto=$texto;
			$this->WORD_SIZE=16;
			$this->KEY_WORDS=4;
			if($this->WORD_SIZE == 64):
				$this->WORD_MASK=0xffffffffffffffff;
			elseif($this->WORD_SIZE != 64):
				$this->WORD_MASK = (0x1 << ($this->WORD_SIZE&63)) - 1;
			endif;
			$this->CONST_C = (-1 ^ 3) & $this->WORD_MASK;
			$this->ROUNDS = 32;
			$this->CONST_J = 0;
			$this->key = $this->start_array_complete(0,$this->ROUNDS);			
			$this->z = $this->populate_matrix($this->z,0,[1,1,1,1,1,0,1,0,0,0,1,0,0,1,0,1,0,1,1,0,0,0,0,1,1,1,0,0,1,1,0,1,1,1,1,1,0,1,0,0,0,1,0,0,1,0,1,0,1,1,0,0,0,0,1,1,1,0,0,1,1,0]);
			$this->z = $this->populate_matrix($this->z,1,[1,0,0,0,1,1,1,0,1,1,1,1,1,0,0,1,0,0,1,1,0,0,0,0,1,0,1,1,0,1,0,1,0,0,0,1,1,1,0,1,1,1,1,1,0,0,1,0,0,1,1,0,0,0,0,1,0,1,1,0,1,0]);
			$this->z = $this->populate_matrix($this->z,2,[1,0,1,0,1,1,1,1,0,1,1,1,0,0,0,0,0,0,1,1,0,1,0,0,1,0,0,1,1,0,0,0,1,0,1,0,0,0,0,1,0,0,0,1,1,1,1,1,1,0,0,1,0,1,1,0,1,1,0,0,1,1]);
			$this->z = $this->populate_matrix($this->z,3,[1,1,0,1,1,0,1,1,1,0,1,0,1,1,0,0,0,1,1,0,0,1,0,1,1,1,1,0,0,0,0,0,0,1,0,0,1,0,0,0,1,0,1,0,0,1,1,1,0,0,1,1,0,1,0,0,0,0,1,1,1,1]);
			$this->z = $this->populate_matrix($this->z,4,[1,1,0,1,0,0,0,1,1,1,1,0,0,1,1,0,1,0,1,1,0,1,1,0,0,0,1,0,0,0,0,0,0,1,0,1,1,1,0,0,0,0,1,1,0,0,1,0,1,0,0,1,0,0,1,1,1,0,1,1,1,1]);

			$this->keyGenerate();
		}
		public function start_array_complete($value,$rounds)
		{
			$array = array();
			for ($i=0; $i < $rounds ; $i++): 
				array_push($array,$value);
			endfor;
			return $array;
		}
		public function populate_matrix($matriz,$linha,$colunas)
		{	
			for ($i=0; $i < count($colunas) ; $i++):
				$matriz[$linha][$i] = $colunas[$i];
			endfor;
			return $matriz;
		}
		public function keyGenerate()
		{	
		    $this->key[3] = 0x1918;
		    $this->key[2] = 0x1110;
		    $this->key[1] = 0x0908;
		    $this->key[0] = 0x0100;	    
		   
			$tmp = null;
		    for($i = $this->KEY_WORDS; $i < $this->ROUNDS; ++$i):
		        $tmp = 0;
		        if($this->KEY_WORDS == 4)
		            $tmp ^= $this->key[$i-3];
		        $tmp ^= 0;
		        $a = $this->key[$i-$this->KEY_WORDS];
		        $b = $this->z[$this->CONST_J][($i-$this->KEY_WORDS) % 62];
		        $this->key[$i] = $a ^ $b ^ $tmp ^ $this->CONST_C;
		    endfor;
		}
		
		public function _S($state,$distance)
	 	{
	 	    return (($state<<$distance)|($state>>($this->WORD_SIZE-$distance)));
		}
	 	public function _F($state)
	 	{
	 		$a = $this->_S($state, 1);
	 		$b =  $this->_S($state, 8); 
	 		$c = $this->_S($state, 2);
	 		$d = $a & $b ^ $c;
	 		return $d;
	 	}
	 
	 	public function criptografar()
	 	{
	 		$this->divide_em_dois();
	 		$qtde=count($this->texto);
	 		for ($i=0; $i < $qtde; $i++):
				$this->encryptRounds($i,$this->ROUNDS);
	 		endfor;
	 	    return $this->texto;
	 	}

	 	public function divide_em_dois()
	 	{
	 		$auxiliar = array();
	 		$qtde = count($this->texto);
		 	$cont = 0;
		 	for ($i=0; $i < $qtde; $i+=2):
		 		if(($i<($qtde-1)))
		 			$auxiliar[$cont]= ['left'=>$this->texto[$i],'right'=>$this->texto[$i+1]];
		 		else
		 			$auxiliar[$cont]= ['left'=>$this->texto[$i],'right'=>null];	 				
		 		$cont ++;
		 	endfor;
		 	$this->texto = $auxiliar;
	 	}
	 
	 	public function encryptRounds($i, $rounds)
	 	{
	 		$temp = null;
	 		$f = null;
	 		for($y = 0; $y < $rounds; $y++):
	 	        $tmp = $this->texto[$i]['left'];
		        $this->texto[$i]['left'] = $this->texto[$i]['right'] ^ $this->_F($this->texto[$i]['left']) ^ $this->key[$y];
		        $this->texto[$i]['right'] = $tmp;
	 	    endfor;
	 	}
	 
	 	public function decrypt($criptografado)
	 	{		
	 		$descriptografado = array();
	 		foreach ($criptografado as $valor):
	 			array_push($descriptografado, $this->decryptRounds($valor->left,$valor->right,$this->ROUNDS));
	 		endforeach;
	 		$resultado = array();

	 		foreach ($descriptografado as $valor):
	 			foreach ($valor as $lado):
	 				array_push($resultado,$lado);
	 			endforeach;
	 		endforeach;
	 		
	 		return $resultado;
	 	}
	 
	 	public function decryptRounds($left, $right, $rounds)
	 	{
	 	    $tmp = null;
	 	    for($i = 0; $i < $rounds; ++$i):
	 	        $tmp = $right;
	 	        $right = $left ^ $this->_F($right) ^ $this->key[$this->ROUNDS-$i-1];
	 	        $left = $tmp;
	 	    endfor;
	 	    return (object) ['left'=>$left,'right'=>$right];
	 	}

		public function getkey()
		{
			return $this->key;
		}
		
	}