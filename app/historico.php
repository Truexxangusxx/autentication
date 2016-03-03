<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class historico extends Model
{

    protected $fillable = [
        'pagina', 'accion', 'usuario'
    ];
    
}
