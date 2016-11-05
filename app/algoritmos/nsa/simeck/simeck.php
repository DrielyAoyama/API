<?php

class simeck
{
	protected $chave = array();	
	protected $criptografado = array();	
	protected $ROUNDS;	
	protected $texto;

	protected $LROT16;

	function __construct($texto)
	{
		$this->texto = $this->divide_esq_dir($texto);
		$this->chave = array(0x0100,0x0908,0x1110,0x1918);    
		$this->ROUNDS = 32;    
	}

	public function getChave()
	{
		return $this->chave;
	}

	public function divide_esq_dir($array_bits)
	{
		$auxiliar = array();
	 	$cont = 0;
	 	for ($i=0; $i < strlen($array_bits); $i+=2):
	 		if(($i<strlen($array_bits)-1))
	 			$auxiliar[$cont]= ['left'=>$array_bits[$i],'right'=>$array_bits[$i+1]];
	 		else
	 			$auxiliar[$cont]= ['left'=>$array_bits[$i],'right'=>null];	 				
	 		$cont ++;
	 	endfor;

	 	return $auxiliar;
	}

	public function criptografar()
	{
		for ($y=0; $y < count($this->texto); $y++):		
			for ($i=0; $i < $this->ROUNDS; $i++):
				$this->embaralhar_ROUND($y,$this->chave);
			endfor;
		endfor;
		return $this->texto;
	}

	public function embaralhar_ROUND($y,$chave)
	{
		$temp = $this->texto[$y]['left'];
		$this->texto[$y]['left'] = (($this->texto[$y]['left']) & $this->LROT16(($this->texto[$y]['left']), 5)) ^ $this->LROT16(($this->texto[$y]['left']), 1) ^ ($this->texto[$y]['right']) ^ $chave; 
		$this->texto[$y]['right']=$temp;
	}

	private function LROT16($x,$r)
	{
		return ((($x) << ($r)) | (($x) >> (16 - ($r))));
	}
} 