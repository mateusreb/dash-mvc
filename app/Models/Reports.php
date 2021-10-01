<?php

namespace App\Models;

use App\Framework\Database\DB;

class Reports extends Model
{
    public static function registerLogin($data)
    {    
        if(DB::update('users', ['ip' => $data['ip']], 'user_id', $data['user_id']))
        {
            return DB::insert('connections', $data);
        }
    }

    public static function registerPingBack($service, $data)
    {
        return DB::insert('pingback', ['service' => $service, 'date' =>  date('Y-m-d H:i:s'), 'data' => $data]);
    }

    public static function registerLog($type, $count)
    {
        return DB::insert('logs', ['type' => $type, 'date' =>  date('Y-m-d H:i:s'), 'count' => $count]);
    }

    public static function registerTransaction($user_id, $product_id, $length, $price, $provider, $ref, $type)
    {
        return DB::insert('transactions',
            ['user_id' => $user_id,
            'product_id' => $product_id,
            'length' => $length,
            'amount' => $price,
            'platform' => $provider,
            'ref' => $ref,
            'type' => $type,
            'date' => date('Y-m-d H:i:s')
        ]);
    }
}