<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportUsersData implements FromCollection
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $result = collect([]);
        $header = [
          	'User Id',
            'Email',
          	'Phone',
            'Company_name',
          	'Defalut Address',
          	'Type',
          	'Category_name',
            'City',
            'Full Name',
        ];
        $result->push($header);

        foreach ($this->data as $item) {
            $row = [
                $item->id ?? '',
              	$item->email ?? '',
              	$item->phone ?? '',
              	$item->company_name ?? '',
              	$item->selectedAddress ?? '',
              	$item->user_type ?? '',
              	$item->category_name ?? '',
                $item->city->name ?? '',
                $item->full_name ?? '',
            ];
            $result->push($row);
        }

        return $result;
    }
}

