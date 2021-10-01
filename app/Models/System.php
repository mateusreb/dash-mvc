<?php

namespace App\Models;

use App\Framework\Database\DB;
use App\Framework\Xenforo\Xenforo;

class System extends Model
{
    public static function checkUserExists($username)
    {
        return DB::find('users', 'username', $username);
    }

    public static function createUser($username)
    {
        $xfuser = Xenforo::xf()->getUserInfoByName($username);
        if($xfuser)
        {
            return DB::insert('users', ['user_id' => $xfuser['user_id'], 'username' => $xfuser['username']]);
        }
        else
        {
            return false;
        }
    } 

    public static function checkRefExists($ref)
    {
        return DB::find('transactions', 'ref', $ref);
    }

    private static function checkLicenseExists($user_id, $product_id)
    {
        $query = DB::query(
            'SELECT * FROM license WHERE user_id = :user_id AND product_id = :product_id AND expiration_date >= NOW()'
        );
        $query->bindValue(":user_id", $user_id);
        $query->bindValue(":product_id", $product_id);
        $query->execute();        
        $result = $query->fetch();
        $query->closeCursor();
        return $result;       
    }

    public static function insertLicense($user_id, $product_id, $length, $ref)
    {
        if(self::checkLicenseExists($user_id, $product_id))
        {
            $query = DB::query(
                "UPDATE license 
                SET ref=:ref, buy_date=NOW(), expiration_date = DATE_ADD(expiration_date, INTERVAL :length DAY)
                WHERE user_id = :user_id
                AND product_id = :product_id
                AND expiration_date >= NOW()"
            );
        }
        else
        {
            $query = DB::query(
                "INSERT INTO license (ref, buy_date, expiration_date, user_id, product_id)
                VALUES (:ref, NOW(), DATE_ADD(NOW(), INTERVAL :length DAY), :user_id, :product_id)"
            );            
        }          
        $query->bindValue(':ref', $ref);
        $query->bindValue(':user_id', $user_id);
        $query->bindValue(':product_id', $product_id);
        $query->bindValue(':length', $length);
        $result = $query->execute();
        $query->closeCursor(); 
        return $result;
    }

    public static function banLicense($ref)
    {        
        if(DB::update('transactions', ['type' => 2], 'ref', $ref))
        {
            return DB::update('license', ['status' => 'BANNED'], 'ref', $ref); 
        } 
    }
    public static function listUsersExpiredLicenses()
    {
        $query = DB::query(
            'SELECT user_id, username FROM users 
            WHERE users.user_id IN (SELECT user.user_id
            FROM users, license
            WHERE users.user_id = license.user_id 
            AND license.expiration_date < NOW()) 
            AND users.user_id NOT IN (SELECT user.user_id
            FROM users, license
            WHERE users.user_id = license.user_id 
            AND license.expiration_date > NOW())'
        );
        $query->execute();
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;
    }

    public static function downgradeUsersExpiredLicenses()
    {
        $query = DB::query(
            'SELECT user_id, username FROM users 
            WHERE users.user_id IN (SELECT user.user_id
            FROM users, license
            WHERE users.user_id = license.user_id 
            AND license.expiration_date < NOW())
            AND users.user_id NOT IN (SELECT user.user_id
            FROM users, license
            WHERE users.user_id = license.user_id 
            AND license.expiration_date > NOW())'
        );
        $query->execute();
        foreach($query->fetchAll() as $user)
        {
            Xenforo::xf()->downgradeUser($user['user_id'], Xenforo::GROUP_USER);
        }
        $query->closeCursor();
    }
}
