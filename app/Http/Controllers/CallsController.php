<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calls;
use App\Models\Customers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeadImport;
use Illuminate\Support\Facades\DB;


class CallsController extends Controller
{
    public function callupdate(Request $request){
        $phone=$request->hiddenPhone;
        $reason=$request->reason;
        $status=$request->status;
        $greeting=$request->howAreYou;
        $call= Calls::where('phone','=', $phone)->first();
        if($call){
            if($status==1){
                $data= Calls::where('phone','=',$phone)->update([
                    'status'=> $status,
                    'greeting'=> $greeting,
                    'reason'=>null
                ]);
            }
            elseif($status==2){
                $data= Calls::where('phone','=',$phone)->update([
                    'status'=> $status,
                    'reason'=> $reason,
                    'greeting'=>null
                ]);
            }
            if($data){
                return redirect()->route('makecall')->with('success','Call updated successfully');
            }else{
                return redirect()->route('makecall')->with('error','Failed to update');
            }
        }else{
            $data=Calls::create([
                'phone'=>$phone,
                'status'=>$status,
                'reason'=>$reason,
                'greeting'=>$greeting
            ]);
            if($data){
                return redirect()->route('makecall')->with('success','Call record created successfully');
            }else{
                return redirect()->route('makecall')->with('error','Failed to create call record');
            }
        }
    }

    public function search(Request $request)
    {
        $name = $request->input('name');
        $phone = $request->input('phone');
        $toDate = $request->input('toDate');
        $froDate = $request->input('froDate');
    
        $query = DB::table('customers');
    
        if ($name) {
            $query->where('first_name', '=', $name);
        }
    
        if ($phone) {
            $query->where('phone', '=', $phone);
        }
    
        if ($froDate && $toDate) {
            $query->whereBetween('updated_at', [$froDate, $toDate]);
        }
    
        $data = $query->paginate(10);
    
        return view('calls.customers', compact('data'));
    }
    

}
