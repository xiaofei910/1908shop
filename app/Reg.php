<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reg extends Model
{
   	protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    //黑名单
    protected $guarded=[];
}
