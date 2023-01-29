<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $table = 'accessLog';  
    protected $fillable = [
        'date',
        'course'
    ];
}
