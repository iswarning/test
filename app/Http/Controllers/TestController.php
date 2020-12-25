<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TestController extends Controller
{
    

    public function index(Request $req)
    {
        // dd($req->birthday);
        $Validator = Validator::make($req->all(), [
            'birthday' => 'present|required'
        ]);
        if($Validator->fails()){
            dd($Validator->errors()->all());
        }
        die('fgh');
        // return view('test');
    }
}
