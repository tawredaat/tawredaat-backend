<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProductBrand implements FromCollection
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
            'Product Id',
            'Product Name',
            'Product Arabic Name',
            'level One Category En',
          	'level One Category Ar',
            'level Two Category En',
          	'level Two Category Ar',
            'level Three Category En',
          	'level Three Category Ar',
            'Quantity',
            'Old Price',
            'New Price',
            'sku',
          	'Link',
        ];
        $result->push($header);

        foreach ($this->data as $item) {
            $row = [
                $item->id ?? '',
                $item->name ?? '',
              	$item->category->parent_category->parent_category->name ?? '',
              	$item->category->parent_category->parent_category->translations[0]['name'] ?? '',
              	$item->category->parent_category->name ?? '',
              	$item->category->parent_category->translations[0]['name'] ?? '',
              	$item->category->name ?? '',
              	$item->category->translations[0]['name'] ?? '',
                $item->translations[0]['name'] ?? '',
                $item->qty,
                $item->old_price,
                $item->new_price,
                $item->sku_code,
                'https://tawredaat.com/'. $item->slug() .'/p/' . $item->id,
            ];
            $result->push($row);
        }

        return $result;
    }
}
