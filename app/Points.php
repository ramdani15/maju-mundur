<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Points extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'points';

    protected $fillable = [
    	'poin', 'customer_id'
    ];
}
