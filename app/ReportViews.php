<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportViews extends Model
{
    protected $table = 'report_views';

    public function product()
    {
        return $this->hasOne('App\Products','id', 'product_id');
    }

    protected $fillable = ['total_views', 'product_id', 'user_id'];

}
