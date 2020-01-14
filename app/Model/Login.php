<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table='login';

    protected $primaryKey='id';
   
    public $timestamps = false;

    protected $guarded = [];
}
