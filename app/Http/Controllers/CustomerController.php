<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CustomerImport;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(){
        $data= Customers::paginate(10);
       // dd($data);
        return view('calls.customers', compact('data'));
    }

    public function store(Request $request){
        $data=$request->validate([
            'myfile'=>'required|mimes:xlsx, xls'
        ]);
        Excel::import(new CustomerImport, request()->file('myfile'));
        return back()->with('successful-import','Customers Uploaded successfully');
    }

    public function query(){
        $users = Customers::all();
       return json_encode($users);
    }

    public function export(){
        return Excel::download(new CustomerExport, 'customers.xlsx');
        
    }
}