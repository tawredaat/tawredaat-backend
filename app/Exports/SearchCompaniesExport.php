<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\SearchStore;

class SearchCompaniesExport implements FromCollection
{
    private $start_date;
    private $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date=$start_date;
        $this->end_date=$end_date;
    }

    public function collection()
    {
        $results = SearchStore::where('search_type','company')->when( ($this->start_date && $this->end_date),function ($query){
            return $query->whereBetween('created_at',[Carbon::parse($this->start_date), Carbon::parse($this->end_date)]);
        })->get();

        $results_collection = collect([]);
        $results_collection->push(['Value', 'Date Time']);
        foreach ($results as $result) {
            $results_collection->push([
                $result->search_value,
                $result->created_at
            ]);
        }
        return $results_collection;
    }
}

