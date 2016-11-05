<?php

class speck
{
	protected $chave = array();	
	protected $criptografado = array();	
	protected $ROUNDS;	
	protected $texto;

	function __construct($texto)
	{
		$this->texto = $this->divide_esq_dir($texto);
		$this->chave =  ['left'=>0x0706050403020100,'right'=> 0x0f0e0d0c0b0a0908];
		return $this->ROUNDS = 32;	
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
				$this->embaralhar_ROUND($y,$this->chave['right']);
				$this->embaralhar_chave($this->chave['left'],$this->chave['right'],$i);
			endfor;
		endfor;
		return $this->texto;
	}

	public function embaralhar_ROUND($y,$chave)
	{
		$this->texto[$y]['left'] = ($this->texto[$y]['left'] >> 8) | ($this->texto[$y]['left'] << (8 * strlen($this->texto[$y]['left']) - 8)); 
		$this->texto[$y]['left'] += $this->texto[$y]['right'];
		$this->texto[$y]['left'] ^= $chave;
		$this->texto[$y]['right']= ($this->texto[$y]['right'] << 3) | ($this->texto[$y]['right'] >> (8 * strlen($this->texto[$y]['right']) - 3));
		$this->texto[$y]['right'] ^= $this->texto[$y]['left'];
	}
	public function embaralhar_chave($x, $y, $k)
	{
		$x = ($x >> 8) | ($x << (8 * strlen($x) - 8)); 
		$x += $y;
		$x ^= $k;
		$y = ($y << 3) | ($y >> (8 * strlen($y) - 3));
		$y ^= $x;
		return ['right'=>$x,'left'=>$y];
	}

} 