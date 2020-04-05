<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetReportByData;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @param Request $request
     * @param ProductRepositoryInterface $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reportByDate(GetReportByData $request, ProductRepositoryInterface $repository)
    {
        $request->flash();

        if (empty($request->date)) {
            session()->forget('date');
        }

        $date = $request->date;

        $products = $repository->getStatisticByDate($date);

        $products = $products->paginate(3)->withPath(route('report', ['date' => $date]));

        return view('select-date', [
            'products' => $products
        ]);

    }

    /**
     * @param ProductRepositoryInterface $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportStatisticOrPercent(ProductRepositoryInterface $repository)
    {
        $percentCalculation = $repository->getReportStatisticOrPercent();

        return view('report-percent', ['percentCalculation' => $percentCalculation]);
    }
}
