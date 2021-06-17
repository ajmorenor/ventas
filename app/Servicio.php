<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{    
    protected $table = 'servicios';
    protected $fillable = ['registro','idempresa','idfuente','idmetodo', 'valorcobrado','fechamedicion','medido','observaciones','primercorreo','segundocorreo','tercercorreo'];
}
