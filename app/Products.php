<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findorfail($id)
 */
class Products extends Model
{
    protected $table = 'products';

    public function report()
    {
        return $this->hasOne('App\Report', 'product_id');
    }

    public function reportView()
    {
        return $this->hasOne('App\ReportViews', 'product_id');
    }

    protected $fillable = ['title'];

    public $timestamps = false;

}
