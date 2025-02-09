<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportUserRFQs implements FromCollection
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
        $header[] = 'ID';
        $header[] = 'User Name';
        $header[] = 'Description';
        $header[] = 'Status';
        $header[] = 'Admin Response';
        $header[] = 'User Response';

        $result->push($header);

        foreach ($this->data as $user_rfq) {
            $row = [];
            $row[] = $user_rfq->id;
            $row[] = $user_rfq->user->name;
            $row[] = $user_rfq->description;
            $row[] = $user_rfq->status;
            $row[] = $user_rfq->admin_response;
            $row[] = $user_rfq->user_response;
            $result->push($row);
        }
        return $result;
    }
}
