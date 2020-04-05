<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetReportByData;
use App\Http\Requests\StoreProduct;
use App\Products;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

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
    public function store(StoreProduct $request)
    {
        $product = Products::create([
            'title' => $request->title,
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
        $product = $this->findOrFail($id);

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
    public function update(StoreProduct $request, $id)
    {
        $product = $this->findOrFail($id);

        $product->title = $request->title;

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
        $product = $this->findOrFail($id);

        if ($product->delete()) {
            return response()
                ->json(['status' => 201]);
        } else {
            return response()
                ->json(['status' => 400]);
        }
    }

    /**
     * @param GetReportByData $request
     * @param ProductRepositoryInterface $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportByDate(GetReportByData $request, ProductRepositoryInterface $repository)
    {
        $date = isset($request->date) ? $request->date : null;

        $products = $repository->getStatisticByDate($date)->get();

        return response()
            ->json(['status' => 201, 'data' => ['products' => $products]]);

    }

    /**
     * @param ProductRepositoryInterface $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportStatisticOrPercent(ProductRepositoryInterface $repository)
    {
        $percentCalculation = $repository->getReportStatisticOrPercent();

        return response()->json(['status' => 201, 'data' => ['percentCalculation' => $percentCalculation]]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function findOrFail($id)
    {
        try {
            $product = Products::findorfail($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(response()->json([
                'status' => 404,
                'message' => 'Record not found',
            ], 404));
        }

        return $product;
    }
}
