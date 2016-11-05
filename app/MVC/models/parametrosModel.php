<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class parametrosModel extends Eloquent
{
	protected $table     = "parametros";
	protected $fillable  = ['usuario','tempo_limite','nivel_minimo','nivel_maximo'];
}

