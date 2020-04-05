<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();

        return response()->json(['status' => 201, 'data' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['status' => 304, 'message' => $validator->getMessageBag()]);
        }

        $product = Products::create([
            'title' => $validator->attributes()['title'],
        ]);
        if ($product->save()) {
            return response()
                ->json(['status' => 201, 'data' => $product->attributesToArray()]);
        } else {
            return response()
                ->json(['status' => 304, 'message' => 'Error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $product = Products::findorfail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()
            ->json(['status' => 201, 'data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['status' => 304, 'message' => $validator->getMessageBag()]);
        }

        try {
            $product = Products::findorfail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $product->title = $validator->attributes()['title'];

        if ($product->save()) {
            return response()
                ->json(['status' => 201, 'data' => $product->attributesToArray()]);
        } else {
            return response()
                ->json(['status' => 304, 'message' => 'Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $product = Products::findorfail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        if ($product->delete()) {
            return response()
                ->json(['status' => 201]);
        } else {
            return response()
                ->json(['status' => 400]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reportByDate(Request $request)
    {
        $reportDate = DB::table('report')->select(DB::raw('FROM_UNIXTIME(UNIX_TIMESTAMP(created_at),\'%Y-%m-%d\') as date'))->distinct()->get();
        $reportViewsDate = DB::table('report_views')->select(DB::raw('FROM_UNIXTIME(UNIX_TIMESTAMP(created_at),\'%Y-%m-%d\') as date'))->distinct()->get();
        $dateSelect = Arr::collapse([$reportDate->toArray(), $reportViewsDate->toArray()]);

        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
        ]);
        if ($validator->fails()) {
            return response()
                ->json(['status' => 201, 'data' => ['dateSelect' => $dateSelect]]);
        }

        $products = !empty($validator->validated()['date']) ? DB::table('products')
            ->select('products.id', 'products.title', 'report.created_at as report_created_at', 'report_views.created_at as report_views_created_at', DB::raw('SUM(report.purchased) as total_purchshed'), DB::raw('SUM(report_views.total_views) as total_views'))->groupBy('products.id', 'products.title', 'report.created_at', 'report_views.created_at')
            ->join('report', 'products.id', '=', 'report.product_id')
            ->join('report_views', 'products.id', '=', 'report_views.product_id')
            ->whereBetween('report.created_at', [$validator->validated()['date'], date('Y-m-d', (strtotime($validator->validated()['date']) + (60 * 60 * 24)))])
            ->whereBetween('report_views.created_at', [$validator->validated()['date'], date('Y-m-d', (strtotime($validator->validated()['date']) + (60 * 60 * 24)))])
            ->get()
            : false;

        return response()
            ->json(['status' => 201, 'data' => ['dateSelect' => $dateSelect, 'products' => $products]]);

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportStatisticOrPercent()
    {

        $percentCalculation = DB::table('products')
            ->select('products.id', 'products.title', DB::raw('((SUM(report.purchased) / SUM(report_views.total_views))*100 ) percent'))->groupBy('products.id', 'products.title')
            ->join('report', 'products.id', '=', 'report.product_id')
            ->join('report_views', 'products.id', '=', 'report_views.product_id')
            ->get();

        return response()->json(['status' => 201, 'data' => ['percentCalculation' => $percentCalculation]]);
    }
}
