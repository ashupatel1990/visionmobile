<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;

class ProductsImport implements ToModel
{
    public function model(array $row)
    {
        dd($row);
        return new Product([
            'name' => $row[0],
            'description' => $row[1],
            'price' => $row[2],
        ]);
    }
}