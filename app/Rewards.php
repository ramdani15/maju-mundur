<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Rewards extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'rewards';

    protected $fillable = [
    	'name', 'poin'
    ];
}
