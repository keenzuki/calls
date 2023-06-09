<?php

namespace App\Imports;

use DateTime;
use App\Contact;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Models\Customers;
use Auth;

class CustomerImport implements ToCollection, WithCalculatedFormulas, SkipsEmptyRows
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $i = -1;

        foreach ($collection as $record){
            $i++;

            if($i == 0){
                continue;
            }

            $contact = Customers::create([
                'first_name'=>$record[0],
                'last_name'=>$record[1],
                'phone'=>$record[2],
                'email'=>$record[3],	
                "agent_id"=>Auth::user()->id
            ]);

        }

        session()->flash('leads-uploaded-success','Leads were uploaded Successfully');

    }
}
