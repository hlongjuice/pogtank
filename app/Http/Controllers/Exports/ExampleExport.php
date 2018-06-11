<?php

namespace App\Http\Controllers\Exports;

use App\Models\Admin\Project\Porlor4Job;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExampleExport implements FromCollection
{
    public function collection()
    {
        return Porlor4Job::first();
    }
}