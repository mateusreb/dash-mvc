<?php

namespace App\Models;

use App\Framework\Database\DB;
use App\Framework\Xenforo\Xenforo;

class Licenses extends Model
{
    public static function getLicenseInfo($license_id)
    {
        $query = DB::query(
            'SELECT license.license_id, license.buy_date,
            license.status,
            license.expiration_date,
            user.username, product.name
            FROM license, user, product
            WHERE license.product_id = product.product_id
            AND license.user_id = user.user_id
            AND license.license_id = :license_id'
        );
        $query->bindValue(":license_id", $license_id);
        $query->execute();        
        $result = $query->fetch();
        $query->closeCursor();
        return $result;       
    }

    public static function createLicense($data)
    {    
        foreach ($data as $value) 
        {
            if (empty($value)) 
            {
                return 0;               
            }
        }        
        $data = [   
            'user_id' => Xenforo::xf()->GetUserInfoByName($data['name'])['user_id'],         
            'buy_date'=> date('Y-m-d H:i:s', strtotime($data['acquired-date'])),
            'expiration_date' => date('Y-m-d H:i:s', strtotime($data['expire-date'])),
            'product_id' => $data['product-id'],
            'ref' => hash('crc32', time())        
        ];
        Xenforo::xf()->upgradeUser($data['user_id'], Xenforo::SGROUP_PBLA); 
        return DB::insert('license', $data);
    }

    public static function updateLicense($data, $license_id)
    {    
        foreach ($data as $value) 
        {
            if (empty($value)) 
            {
                return 0;               
            }
        }        
        $data = [            
            'buy_date'=> date('Y-m-d H:i:s', strtotime($data['acquired-date'])),
            'expiration_date' => date('Y-m-d H:i:s', strtotime($data['expire-date'])),
            'product_id' => $data['product-id'],
            'status' => $data['status']
        ];
        return DB::update('license', $data, 'license_id', $license_id);
    }

    public static function updateAllLicenses($length, $type)
    {
        $query = DB::query(
            "UPDATE license
            SET expiration_date = DATE_{$type}(expiration_date, INTERVAL :length DAY)
            WHERE expiration_date >= NOW()"
        );
        $query->bindValue(":length", $length);
        $result = $query->execute();
        $query->closeCursor(); 
        return $result;
    }

    public static function listLicenses($page_id)
    {
        $max_rows = 10;     
        $from = ($page_id-1) * $max_rows;           

        $query = DB::query(
            "SELECT license.license_id, license.buy_date,
            license.status,
            license.expiration_date,
            users.username, product.name
            FROM license, users, product
            WHERE license.product_id = product.product_id
            AND license.user_id = users.id  AND license.expiration_date >= NOW() 
            ORDER BY license.license_id DESC LIMIT {$from}, {$max_rows}"
        );
        $query->execute();        
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;
    }

    public static function deleteLicense($license_id)    
    {
        return DB::delete('license', 'license_id', $license_id);
    }

    public static function licensesCount()
    {
        $query = DB::query('SELECT license_id FROM license WHERE expiration_date >= NOW()');
        $query->execute();        
        $result = $query->rowCount();
        $query->closeCursor();
        return $result;       
    }

    public static function filterLicenses($user)
    {
        $query = DB::query(
            "SELECT license.license_id, license.buy_date,
            license.expiration_date,
            user.username, product.name
            FROM license, user, product
            WHERE license.product_id = product.product_id
            AND license.user_id = user.user_id
            AND user.username = :user"
        );
        $query->bindValue(":user", $user);
        $query->execute();        
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;       
    }
}