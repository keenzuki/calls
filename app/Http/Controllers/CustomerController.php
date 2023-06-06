<?php

namespace App\Http\Controllers;
use App\Models\Customers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        $data= Customers::orderBy('created_at', 'desc')->get();
        return view('calls.calls', compact('data'));
    }
}