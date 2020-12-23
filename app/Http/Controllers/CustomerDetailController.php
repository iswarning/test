<?php

namespace App\Http\Controllers;
use App\Models\Contracts;
use Illuminate\Http\Request;

class CustomerDetailController extends Controller
{
    
    public function index(Request $request)
    {
        // dd($request->id);
        return view('customer-detail', [
            'customerId' => $request->id,
            'contracts' => Contracts::all(),
        ]);
    }
}
