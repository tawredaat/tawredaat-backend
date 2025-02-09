<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportOrdersData implements FromCollection
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
        $header[] = 'Status';
        $header[] = 'Order ID';
        if (request()->input('view_type') == 'cancelled') {
            $header[] = 'Cancelled By';
            $header[] = 'Cancelled at';
        }
        $header[] = 'User ID';
        $header[] = 'User Name';
        $header[] = 'User Email';
        $header[] = 'User Phone';
        $header[] = 'Address';
        $header[] = 'Subtotal';
        $header[] = 'Total';
        // $header[] = 'Promocode';
        $header[] = 'Payment Type';
        $header[] = 'Added Time';
        $header[] = 'Ordered From';
        $result->push($header);
        foreach ($this->data as $order) {
            $row=[];
            $row[]=$order->status?$order->status->name : '---';
            $row[]=$order->id;
            if (request()->input('view_type') == 'cancelled'){
                $row[]=$order->cancelledBy ? $order->cancelledBy->name : '---';
                $row[]=$order->cancelled_at;
            }
            $row[]=$order->user ? $order->user->id :"removed!";
            $row[]=$order->user ? $order->user->name :"removed!";
            $row[]=$order->user ? $order->user->email :"removed!";
            $row[]=$order->user ? $order->user->phone :"removed!";
            $row[]=$order->address;
            $row[]=$order->subtotal;
            $row[]=$order->total;
            // $row[]=$order->promocode;
            $row[]=$order->payment ? $order->payment->name : 'removed';
            $row[]=$order->created_at;
            $row[]=$order->order_from ? $order->order_from : 'removed';
            $result->push($row);
        }
        return $result;
    }
}

