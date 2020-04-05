<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function reportByDate(Request $request)
    {
        $request->flash();

        $reportDate = DB::table('report')->select(DB::raw('FROM_UNIXTIME(UNIX_TIMESTAMP(created_at),\'%Y-%m-%d\') as date'))->distinct()->get();
        $reportViewsDate = DB::table('report_views')->select(DB::raw('FROM_UNIXTIME(UNIX_TIMESTAMP(created_at),\'%Y-%m-%d\') as date'))->distinct()->get();
        $dateSelect = Arr::collapse([$reportDate->toArray(), $reportViewsDate->toArray()]);

        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
        ]);

        $products = !empty($validator->validated()['date'])? DB::table('products')
            ->select('products.id', 'products.title', 'report.created_at as report_created_at', 'report_views.created_at as report_views_created_at', DB::raw('SUM(report.purchased) as total_purchshed'), DB::raw('SUM(report_views.total_views) as total_views'))->groupBy('products.id', 'products.title', 'report.created_at', 'report_views.created_at')
            ->join('report', 'products.id', '=', 'report.product_id')
            ->join('report_views', 'products.id', '=', 'report_views.product_id')
            ->whereBetween('report.created_at', [$validator->validated()['date'], date('Y-m-d', (strtotime($validator->validated()['date']) + (60 * 60 * 24)))])
            ->whereBetween('report_views.created_at', [$validator->validated()['date'], date('Y-m-d', (strtotime($validator->validated()['date']) + (60 * 60 * 24)))])
            ->paginate(3)->withPath('reportss',['date' => $validator->validated()['date']])
            : false;

        if(!empty($products)){
         $products->withPath(route('report', ['date' => $validator->validated()['date']]));
        }
        return view('select-date', [
            'dateSelect' => $dateSelect,
            'products' => $products
        ]);

    }

    public function reportStatisticOrPercent()
    {

        $percentCalculation = DB::table('products')
            ->select('products.id', 'products.title', DB::raw('((SUM(report.purchased) / SUM(report_views.total_views))*100 ) percent'))->groupBy('products.id', 'products.title')
            ->join('report', 'products.id', '=', 'report.product_id')
            ->join('report_views', 'products.id', '=', 'report_views.product_id')
            ->get();

        return view('report-percent', ['percentCalculation' => $percentCalculation]);
    }
}
