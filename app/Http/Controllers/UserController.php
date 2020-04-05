<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function eagerLoading($id)
    {
        //eagerLoading
        $reportByUserId = Users::with(['reportViews' => function ($query) use ($id) {
        }])->where('id', '=', $id)->get();
    }
}
