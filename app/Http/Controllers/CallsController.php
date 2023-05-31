<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calls;

class CallsController extends Controller
{
    public function index(){
        $data= Calls::orderBy('created_at', 'desc')->get();
        return view('calls.calls', compact('data'));
    }

    public function search(Request $request){
        $result= $request->validate([
            'name' => 'alpha',
            'phone' => 'numeric',
            'date' => 'date|before_or_equal:today'
        ]);
        $name= $request->name;
        $phone= $request->phone;
        $date= $request->date;
        $data= Calls::where('name', '=', $name)
                    ->orWhere('phone', '=', $phone)
                    ->orWhereDate('created_at', '=', $date)
                        ->get();
        return view('calls.calls', compact('data'));
    }

    function import(Request $request){
        
        $this->validate($request, [
            'select_file' => 'required | mimes:xls,xlsx'
        ]);
        // dd($data);
        $path=$request->file('select_file')->getRealPath();
        $info= Excel::load($path)->get();

        if($data->count()>0){
            foreach ($info->toArray() as $key => $value) {
                foreach($value as $row){
                    $insert[]=array(
                        'name' => $row['name'],
                        'phone' => $row['phone']
                    );
                }
            }
            if(!empty($insert)){
                Calls::table('calls')->insert($data);
            }
        }
        return back()->with('success', 'data inserted successfully');
    }
    public function info($id){
        $data= Calls::where('id','=',$id)->get();
        return view('calls.info', compact('data'));
    }
}
