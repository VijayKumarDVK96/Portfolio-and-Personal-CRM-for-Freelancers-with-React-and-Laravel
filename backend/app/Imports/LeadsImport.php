<?php

namespace App\Imports;

use App\Http\Models\Lead;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class LeadsImport implements ToModel, WithHeadingRow, SkipsOnError, SkipsOnFailure {

    use Importable, SkipsErrors;
    
    public function model(array $row) {
        return new Lead([
            'name'     => $row['Name'],
            'contact_no'    => $row['Contact No.'],
            'address'    => $row['Address'],
            'website'    => $row['Website'],
            'instagram'    => $row['Instagram'],
            'remarks' => $row['Comments'],
            'created_at' => $row['Created At'],
        ]);
    }

    public function onFailure(Failure ...$failure) {
        return $failure;
    }
}
