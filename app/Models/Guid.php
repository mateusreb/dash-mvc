<?php

namespace App\Models;

use App\Framework\Database\DB;

class Guid extends Model
{
    public static function guidInformation($user_id)
    {
        return DB::find('guid', 'user_id', $user_id);
    }

    public static function registerGuid($user_id, $guid, $pc_name)
    {
        return DB::insert('guid', 
            ['reset_date' => date('Y-m-d H:m:s'),
            'reset_availability' => date('Y-m-d H:m:s'),
            'guid' => $guid,
            'user_id' => $user_id,
            'pc_name' => $pc_name]
        );
    }

    public static function updateGuid($user_id, $guid, $pc_name)
    {
        return DB::update('guid',             
            ['guid' => $guid,            
            'pc_name' => $pc_name],
            'user_id',
            $user_id
        );
    }

    public static function banGuid($user_id, $guid, $reason)
    {
        if(self::guidIsBanned($user_id, $guid))
        {
            return true;
        }        
        return DB::insert('ban', ['guid' => $guid,
            'user_id' => $user_id,
            'date' => date('Y-m-d H:m:s'),
            'reason' => $reason]); 
    }

    public static function unbanGuid($user_id, $guid)
    {
        if(DB::update('guid', ['status' => 'OK'],'user_id', $user_id))
        {
            return DB::delete('ban', 'guid', $guid);           
        }        
        return false;
    }

    public static function guidIsBanned($guid, $user_id)
    {
        if(DB::find('banned', 'guid', $guid) || DB::find('banned', 'user_id', $user_id))
        {
            return true;
        }   
        return false;
    }

    public static function resetGuid($user_id)
    {
        $user_info = DB::find('guid', 'user_id', $user_id);                   
        if(strtotime($user_info['reset_availability']) <= time() &&         
         $user_info['guid'] != '')
        {
            return DB::update(
                'guid',
                ['guid' => '', 
                'reset_date' => date('Y-m-d H:m:s',time()),
                'reset_availability' => date('Y-m-d H:m:s', strtotime('+7 day', time()))],
                'user_id', $user_id
            );
        }
        return false;
    }
}