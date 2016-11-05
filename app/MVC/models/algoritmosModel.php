<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class algoritmosModel extends Eloquent
{
	protected $table     = "algoritmos";
	protected $fillable  = ['nome','nivel','media_tempo_processamento','qtde_execucoes','mao_unica','implementado'];
}

