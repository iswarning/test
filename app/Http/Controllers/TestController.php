<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDF;
class TestController extends Controller
{
    public function index()
    {
        // return DB::table('contracts')
        //     ->select('*', DB::raw('count(DISTINCT customers.id)'))
        //     ->join('customers','contracts.customer_id','=','customers.id')
        //     ->where('customers.name','like','%richar%')
        //     ->groupBy('contracts.contract_no')
        //     ->get();
        // $dataNotUpdate = User::all();
        // $dataUpdated = array(
        //     ''
        // );
    }
}
