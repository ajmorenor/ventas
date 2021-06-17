<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relacion extends Model
{
    protected $table = 'relaciones';
    protected $fillable = [ 'idempresa','idfuente'];
}
