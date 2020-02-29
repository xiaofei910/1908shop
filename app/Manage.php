<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manage extends Model
{
    protected $table = 'logistics';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    //黑名单
    protected $guarded=[];
}
