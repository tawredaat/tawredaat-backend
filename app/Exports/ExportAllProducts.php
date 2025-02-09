<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportAllProducts implements FromCollection
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
          	'level One Category En',
          	'level One Category Ar',
            'level Two Category En',
          	'level Two Category Ar',
            'level Three Category En',
          	'level Three Category Ar',
          	'Brand Name En',
          	'Brand Name Ar',
            'Product Name En',
            'Product Name Ar',
            'Quantity',
          	'Show',
            'Old Price',
            'New Price',
            'sku',
          	'link'
        ];
        $result->push($header);

        foreach ($this->data as $item) {
            $row = [
                $item->id ?? '',
              	$item->category->parent_category->parent_category->name ?? '',
              	$item->category->parent_category->parent_category->translations[0]['name'] ?? '',
              	$item->category->parent_category->name ?? '',
              	$item->category->parent_category->translations[0]['name'] ?? '',
              	$item->category->name ?? '',
              	$item->category->translations[0]['name'] ?? '',
              	$item->brand->name ?? '',
              	$item->brand->translations[0]['name'] ?? '',
                $item->name ?? '',
                $item->translations[0]['name'] ?? '',
                $item->qty == 0 ? 'out of stock' : $item->qty,
              	$item->show == 0 ? 'hidden' : 'shown',
                $item->old_price ?? 0,
                $item->new_price ?? 0,
                $item->sku_code ?? 0,
              	'https://tawredaat.com/'. $item->slug() .'/p/' . $item->id,
            ];
            $result->push($row);
        }

        return $result;
    }
}
