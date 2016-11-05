<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class usuariosModel extends Eloquent
{
	protected $table     = "usuarios";
	protected $fillable  = ['nome','email','chave'];
}

