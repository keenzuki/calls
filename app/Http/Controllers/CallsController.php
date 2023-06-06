<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calls;
use App\Models\Customers;


class CallsController extends Controller
{
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
    public function callupdate(Request $request){

        // $info=$request->validate([

        // ])
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
                return back()->with('success','Call updated successfully');
            }else{
                return back()->with('error','Failed to update');
            }
        }else{
            $data=Calls::create([
                'phone'=>$phone,
                'status'=>$status,
                'reason'=>$reason,
                'greeting'=>$greeting
            ]);
            if($data){
                return back()->with('success','Call record created successfully');
            }else{
                return back()->with('error','Failed to create call record');
            }
        }
    }
}
