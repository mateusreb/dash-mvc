<?php

namespace App\Models;

use App\Framework\Database\DB;

class Users extends Model
{
    public static function createUser($data = [])
    {
        return DB::insert('users', $data);
    }    

    public static function deleteUser($user_id)
    {
        return DB::delete('user', 'user_id', $user_id);
    }

    public static function getUserInfo($user_id)
    {        
        $query = DB::query(
            'SELECT user.user_id, user.username, user.ip, guid.guid, guid.user_id 
            FROM user INNER JOIN guid ON user.user_id = guid.user_id WHERE user.user_id=:user_id'
        );
        $query->bindValue(":user_id", $user_id);
        $query->execute();        
        $result = $query->fetch();
        $query->closeCursor();
        return $result;        
    }

    public static function listUsersVIP()
    {     
        $query = DB::query(
            'SELECT user.user_id, user.username, user.ip, user.buys, guid.guid, guid.user_id 
            FROM user INNER JOIN guid ON user.user_id = guid.user_id'
        );        
        $query->execute();        
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;
    }

    public static function updateUser($data, $user_id)
    {    
        foreach ($data as $value) 
        {
            if (empty($value)) 
            {
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
        return DB::update('user', $data, 'product_id', $user_id);
    }
}