<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Transactions extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'transactions';

    protected $fillable = [
    	'customer_id', 'merchant_id', 'product_id', 'amount', 'paid', 'refund', 'success'
    ];
}
