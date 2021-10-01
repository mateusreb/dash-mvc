<?php

namespace App\Models;

use App\Framework\Database\DB;

class Product extends Model
{
    public static function listProducts()
    {     
        return DB::all('products');
    }

    public static function getProductInfo($product_id)
    {     
        return DB::find('products', 'product_id', $product_id);
    }

    public static function listProductPrices($product_id)
    {     
        return DB::allWhere('prices', 'product_id', $product_id);
    }

    public static function getProductPrice($price_id)
    {     
        return DB::find('prices', 'price_id', $price_id);
    }

    public static function getProductPriceByCost($cost)
    {     
        return DB::find('prices', 'cost', $cost);
    }

    public static function createProduct($data)
    {    
      //  print_r($data);
        foreach ($data as $value) {
            if (empty($value)) {
                return 0;               
            }
        }
        $date  = date('Y-m-d', strtotime($data['update-date']));

        $data = [
            'name' => $data['name'],
            'updated'=> $date,
            'status' => $data['status'],
            'version' => $data['version'],
            'hash' => $data['hash'],
            'description' => $data['description']
        ];
        return DB::insert('products', $data);
    }

    public static function updateProduct($data, $product_id)
    {    
        foreach ($data as $value) {
            if (empty($value)) {
                return 0;               
            }
        }        
        $data = [
            'name' => $data['name'],
            'updated'=> date('Y-m-d', strtotime($data['update-date'])),
            'status' => $data['status'],
            'version' => $data['version'],
            'hash' => $data['hash'],
            'description' => $data['description']
        ];
        return DB::update('product', $data, 'product_id', $product_id);
    }

    public static function deleteProduct($product_id)    
    {
        return DB::delete('product', 'product_id', $product_id);
    }
}