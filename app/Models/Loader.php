<?php

namespace App\Models;

//Framework
use App\Framework\Routing\Request;
use App\Framework\Xenforo\Xenforo;
use App\Framework\Database\DB;
use App\Framework\Helpers\Header;

//Model
use App\Models\User;
use App\Models\Reports;

class Loader extends Model
{
    public static function check()
    {
        $Request = new Request();

        if (!$Request->input('id'))
         {
            return base64_encode(json_encode(
                [
                    'status' => 'BAD_REQUEST',
                    'response' => null
                ],
                JSON_PRETTY_PRINT
            ));
        }
        $loader_info = DB::find('loader', 'loader_id', $Request->input('id'));
        return base64_encode(json_encode(
            [
                'status' => 'LOADER_OK',
                'response' =>
                [
                    'status' => $loader_info['status'],
                    'version' => $loader_info['version'],
                    'hash' => $loader_info['hash'],
                    'message' => $loader_info['message']
                ]
            ],
            JSON_PRETTY_PRINT
        ));
    }

    public static function auth()
    {
        $Request = new Request();

        if (!$Request->input('username') || !$Request->input('password') || !$Request->input('guid') || !$Request->input('info')) 
        {
            return base64_encode(json_encode(
                [
                    'status' => 'BAD_REQUEST',
                    'reponse' => null
                ],
                JSON_PRETTY_PRINT
            ));
        }
        if (Xenforo::xf()->auth($Request->input('username'), $Request->input('password'))) 
        {
            $xfuser_info =  Xenforo::xf()->GetUserInfoByName($Request->input('username'));
            $guid_banned = Guid::guidIsBanned($Request->input('guid'), $xfuser_info['user_id']);
            $guid_info = Guid::guidInformation($xfuser_info['user_id']);
 
            Reports::registerLogin([
                'user_id' => $xfuser_info['user_id'],
                 'date' => date('Y-m-d h:i:s'),
                 'ip' => Header::getUserIP(),
                 'platform' => 'Loader',
                 'status' => 'OK',
                 'info' => $Request->input('info')
            ]);

            if (!$guid_info) 
            {
                Guid::registerGuid($xfuser_info['user_id'], $Request->input('guid'), $Request->input('pc'));
                $guid_info = Guid::guidInformation($xfuser_info['user_id']);
            }
            if (!$guid_info['guid']) 
            {
                Guid::updateGuid($xfuser_info['user_id'], $Request->input('guid'), $Request->input('pc'));
                $guid_info = Guid::guidInformation($xfuser_info['user_id']);
            }
            if ($guid_banned) 
            {
                return base64_encode(json_encode(
                    [
                        'status' => 'TOKEN_BANNED', //76840fc4-3b98-4bc5-a2c0-dfbf50aedfdb
                        'reponse' => null
                    ],
                    JSON_PRETTY_PRINT
                ));
            }
            if ($guid_info['guid'] != $Request->input('guid')) {
                return base64_encode(json_encode(
                    [
                        'status' => 'TOKEN_ERROR',
                        'reponse' => null
                    ],
                    JSON_PRETTY_PRINT
                ));
            }
            return base64_encode(json_encode(
                [
                    'status' => 'LOGIN_OK',
                    'reponse' =>
                    [
                        'userinfo' =>
                        [
                            'usename' => $xfuser_info['username'],
                            'guid' => $guid_info['guid']
                        ],
                        'licenses' => User::getSubscriptions($xfuser_info['user_id'])
                    ]
                ],
                JSON_PRETTY_PRINT
            ));
        } 
        else 
        {            
            return base64_encode(json_encode(
                [
                    'status' => 'PASSWORD_ERROR',
                    'reponse' => null
                ],
                JSON_PRETTY_PRINT
            ));
        }
    }
}
