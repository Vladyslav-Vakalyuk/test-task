<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function getReportStatisticOrPercent()
    {
        return DB::table('products')
            ->select('products.id', 'products.title', DB::raw('((SUM(report.purchased) / SUM(report_views.total_views))*100 ) percent'))->groupBy('products.id', 'products.title')
            ->join('report', 'products.id', '=', 'report.product_id')
            ->join('report_views', 'products.id', '=', 'report_views.product_id')
            ->get();
    }

    /**
     * @param null $date
     * @return \Illuminate\Database\Query\Builder
     */
    public function getStatisticByDate($date = null)
    {
        $product = DB::table('products')
            ->select('products.id', 'products.title', 'report.created_at as report_created_at', 'report_views.created_at as report_views_created_at', DB::raw('SUM(report.purchased) as total_purchshed'), DB::raw('SUM(report_views.total_views) as total_views'))->groupBy('products.id', 'products.title', 'report.created_at', 'report_views.created_at')
            ->join('report', 'products.id', '=', 'report.product_id')
            ->join('report_views', 'products.id', '=', 'report_views.product_id');

        if (!is_null($date)) {
            $product->whereBetween('report.created_at', [$date, date('Y-m-d', (strtotime($date) + (60 * 60 * 24)))])
                ->whereBetween('report_views.created_at', [$date, date('Y-m-d', (strtotime($date) + (60 * 60 * 24)))]);
        }

        return $product;
    }

}