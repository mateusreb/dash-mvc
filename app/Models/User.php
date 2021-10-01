<?php

namespace App\Models;

use App\Framework\Database\DB;

class User extends Model
{
    public static function connectionsLog($user_id)
    {
        $query = DB::query(
            'SELECT * FROM connections 
            WHERE user_id=:user_id
            ORDER BY date DESC LIMIT 10'
        );
        $query->bindValue(":user_id", $user_id);
        $query->execute();        
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;        
    }

    public static function getSubscriptions($user_id)
    {
        $query = DB::query(
            "SELECT license.ref, license.expiration_date, license.status,
            product.status AS product_status, product.name,
            product.version, product.updated
            FROM license INNER JOIN product ON
            license.product_id = product.product_id 
            WHERE user_id=:user_id
            AND license.status = 'OK'
            AND expiration_date >= NOW()"
        );
        $query->bindValue(":user_id", $user_id);
        $query->execute();        
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;      
    }

    public static function getDownloads($user_id)
    {
        $query = DB::query(
            'SELECT license.ref, license.expiration_date, products.status,
            products.name, products.version, products.updated, products.product_id
            FROM license INNER JOIN products ON
            license.product_id = products.product_id 
            WHERE user_id=:user_id 
            AND expiration_date >= NOW()'
        );
        $query->bindValue(":user_id", $user_id);
        $query->execute();        
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;      
    }

    public static function getTransactions($user_id)
    {
        $query = DB::query(
            'SELECT * FROM orders INNER JOIN product ON
            orders.product_id = product.product_id 
            WHERE user_id=:user_id
            ORDER BY date DESC'
        );

        $query->bindValue(":user_id", $user_id);
        $query->execute();        
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;        
    }

    public static function getActivity($user_id)
    {
        $query = DB::query(
            'SELECT * FROM orders INNER JOIN product ON
            transactions.product_id = product.product_id 
            WHERE user_id=:user_id'
        );

        $query->bindValue(":user_id", $user_id);
        $query->execute();        
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;        
    }

    public static function getSubscriptionCount($user_id)    
    {
        $query = DB::query(
            'SELECT *
            FROM license INNER JOIN product ON
            license.product_id = product.product_id 
            WHERE user_id=:user_id 
            AND expiration_date >= NOW()'
        );
        $query->bindValue(":user_id", $user_id);
        $query->execute();        
        $result = $query->rowCount();
        $query->closeCursor();
        return $result;  
    }

    public static function getTransactionsCount($user_id)    
    {
        return DB::count('orders', 'user_id', $user_id);
    }

    public static function getResetCount($user_id)    
    {
        $user_info = DB::find('guid', 'user_id', $user_id);                   
        if(strtotime($user_info['reset_availability']) <= time())
            return 1;
        else
            return 0;
    }

    public static function getConnectionsCount($user_id)    
    {
       return DB::count('connections', 'user_id', $user_id);
    }
}