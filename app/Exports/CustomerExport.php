<?php

namespace App\Exports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Customers::select('first_name', 'email', 'phone', 'id')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['Name', 'Email', 'Phone', 'ID'];
    }
}
