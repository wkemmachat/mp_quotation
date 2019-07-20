<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            // 'id'     => $row[0],
            'user_key_in_id'    => 1,
            'productId' => $row[1],
            'productName' => $row[2],
            'created_at' => now(),
            'updated_at' => now(),
            'productCategoryRunning_id' => $row[3],
            'active' => 1,
            'min' => 0,
        ]);
    }
}
