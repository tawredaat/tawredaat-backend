<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportOrderDetailsData implements FromCollection
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $result = collect([]);
        $header = [];
        $header[] = 'Order Details';
        $header[] = 'Product Id';
        $header[] = 'Product Name';
        $header[] = 'Product Arabic Name';
        $header[] = 'Sku Code ';
        $header[] = 'Internal Code';
        $header[] = 'Quantity';
        $header[] = 'Price';
        $header[] = 'Total';
        $result->push($header);

        foreach ($this->data->items as $item) {
            $row = [];
            $row[] = "--";
            $row[] = $item->shopProduct ? $item->shopProduct->id : "removed";
            $row[] = $item->shopProduct ? $item->shopProduct->name : "removed";
            $row[] = $item->shopProduct ? ($item->shopProduct->translations[0]['name'] ?? "removed") : "removed"; // Using null coalescing operator
            $row[] = $item->shopProduct ? $item->shopProduct->sku_code : "removed";
            $row[] = $item->shopProduct ? $item->shopProduct->internal_code : "removed";
            $row[] = $item->quantity;
            $row[] = $item->price;
            $row[] = $item->amount;
            $result->push($row);
        }

        $row = [];
        $latitude = $this->data->userAddress->latitude ?? null;
        $longitude = $this->data->userAddress->longitude ?? null;

        if ($latitude !== null && $longitude !== null) {
            $locationUrl = "https://www.google.com/maps/search/?api=1&query=$latitude,$longitude";
        } else {
            $locationUrl = "Location not Iserted"; // Fallback message
        }

        $row[] =
            "Order Id: " . $this->data->id
            . "\r\n" . "Subtotal: " . $this->data->subtotal
            . "\r\n" . "Total: " . $this->data->total
            . "\r\n" . "Address: " . $this->data->address
            . "\r\n" . "Address Type: " . ($this->data->userAddress->address_type ?? 'N/A')
            . "\r\n" . "Reciever Name: " . ($this->data->userAddress->reciever_name ?? 'N/A')
            . "\r\n" . "Reciever Phone: " . ($this->data->userAddress->reciever_phone ?? 'N/A')
            . "\r\n" . "Location: " . $locationUrl
            . "\r\n" . "Payment: " . $this->data->payment->name
            . "\r\n" . "Placed at: " . $this->data->created_at;

        $result->push($row);
        $row = [];

        if ($this->data->user) {
            $row[] = "User ID: " . $this->data->user->id
                . "\r\n" . " Name: " . $this->data->user->full_name
                . "\r\n" . " Email: " . $this->data->user->email
                . "\r\n" . " Phone: " . $this->data->user->phone
          		. "\r\n" . " User Type: " . $this->data->user->user_type;
            $result->push($row);
        }

        return $result;
    }
}
