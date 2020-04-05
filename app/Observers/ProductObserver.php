<?php

namespace App\Observers;

use App\Products;
use App\ReportViews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param Products $products
     * @return void
     */
    public function created(Products $products)
    {
        ReportViews::create([
            'product_id' => $products->id,
            'total_views' => 0,
            'user_id' => Auth::authenticate()->id
        ]);
    }

    /**
     * @param Products $product
     */
    public function retrieved(Products $product)
    {
        ReportViews::where('product_id', '=', $product->id)
            ->update([
                'total_views' => DB::raw('total_views+1'),
            ]);
    }
}