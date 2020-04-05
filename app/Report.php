<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report';

    public function product()
    {
        return $this->hasOne('App\Products', 'id', 'product_id');
    }

    protected $fillable = ['product_id', 'amount', 'purchased', 'created_at', 'updated_at'];

}
