<?php

namespace App\Framework\Xenforo;

use XenForo_Autoloader;
use XenForo_Application;
use XenForo_Dependencies_Public;
use XenForo_Session;
use XenForo_Visitor;
use XenForo_Model;
use XenForo_Model_User;
use XenForo_Authentication_Abstract;
use XenForo_Template_Helper_Core;
use XenForo_DataWriter;
use Dark_TaigaChat_DataWriter_Message;

class Xenforo
{
    private static $instance;
    private static $config;

    //Group
    const GROUP_ADMIN   = 3;
    const GROUP_USER    = 2;
    const GROUP_VIP     = 6;

    //Sub group
    const SGROUP_PBLA   = 7;

    //bot
    const CHAT_BOT_ID   = 1;
    const CHAT_BOT_NAME = 'Payssion';

    //fx root
    //const XF_ROOT = 'https://www.warcheats.net/';

    public function getSessionUsername()
    {
        $dependencies = new XenForo_Dependencies_Public();
        $dependencies->preLoadData();
        XenForo_Session::startPublicSession();
        $visitor = XenForo_Visitor::getInstance();
        return ($visitor->username);
    }

    public function getUserGroup($username)
    {
        $userModel = XenForo_Model::create('XenForo_Model_User');
        $user = $userModel->getUserByName($username);
        return $user['user_group_id'];
    }

    public function setUserGroup($name, $group)
    {
        $userModel = XenForo_Model::create('XenForo_Model_User');
        $user = $userModel->getUserByName($name);
        $userId = $user['user_id'];
        $writer = XenForo_DataWriter::create('XenForo_DataWriter_User');
        if ($userId) 
        {
            $writer->setExistingData($userId);
        }
        $writer->set('user_group_id', $group);
        $writer->save();
    }

    public function banUser($user_id)
    {
        $userModel = XenForo_Model::create('XenForo_Model_User');        
        $userModel->ban($user_id, XenForo_Model_User::PERMANENT_BAN, 'Chargeback');
    }

    public function upgradeUser($user_id, $group_id)
    {
        if(XenForo_Model::create('XenForo_Model_User')->getUserById($user_id)['user_group_id'] == self::GROUP_USER)
        {
            $dataWriter = XenForo_DataWriter::create('XenForo_DataWriter_User');
            $dataWriter->setExistingData($user_id);
            $dataWriter->set('user_group_id', self::GROUP_VIP);
            $dataWriter->set('secondary_group_ids', strval($group_id));
            $dataWriter->save();
        }
    }

    public function downgradeUser($user_id, $group_id)
    {
        if(XenForo_Model::create('XenForo_Model_User')->getUserById($user_id)['user_group_id'] == self::GROUP_VIP)
        {
            $dataWriter = XenForo_DataWriter::create('XenForo_DataWriter_User');
            $dataWriter->setExistingData($user_id);
            $dataWriter->set('user_group_id', $group_id);
            $dataWriter->set('secondary_group_ids', '');
            $dataWriter->save();
        }
    }

    public function getUserInfoByName($username)
    {
       return XenForo_Model::create('XenForo_Model_User')->getUserByName($username);              
    }

    public function getUsersInfoArray()
    {
        $userModel = XenForo_Model::create('XenForo_Model_User');
        $criteria = array(
            'user_group_id' => [1,2,3,4,5]
        );
        $options = array(
            'join' => XenForo_Model_User::FETCH_USER_FULL,
            'order' => 'user_id'
        );
        return  $userModel->getModelFromCache('XenForo_Model_User')->getUsers($criteria, $options);
    }

    public function xenforoBot($message)
    {
        $alertModel = XenForo_Model::create('XenForo_Model_Alert');
        $alertModel->alertUser(1, 1, 'Scott', 'user', 1, 'from_admin', array("alert_text" => "Your custom alert text here"));  
        
        $dws = XenForo_DataWriter::create('Dark_TaigaChat_DataWriter_Message');
        $dws->setOption(Dark_TaigaChat_DataWriter_Message::OPTION_IS_AUTOMATED, true);
        $dws->set('user_id', 1);
        $dws->set('username', 'Scott');
        $dws->set('message', $message);
        $dws->save();
     }

    public function auth($user, $pass)
    {
        $db = XenForo_Application::getDb();
        $data = $db->fetchOne('SELECT auth.data FROM xf_user_authenticate AS auth INNER 
		JOIN xf_user AS user ON (user.user_id = auth.user_id) WHERE user.username = ?', $user);
        $auth = XenForo_Authentication_Abstract::createDefault();
        $auth->setData($data);
        $check = $auth->authenticate($user, $pass);
        return $check;
    }

    public function getConfig()
    {
        return $config['root'];
    }

    public function getAvatar($username)
    {        
        $userModel = XenForo_Model::create('XenForo_Model_User');
        $user = $userModel->getUserByName($username);        
        return self::$config['root'] . XenForo_Template_Helper_Core::callHelper('avatar', array($user, 's'));
    }

    public static function xf()
    {
        if(self::$instance === null)
        {
            self::$config = include_once __DIR__ . "/../../../config/xenforo.php";
            include_once('../../forum/library/XenForo/Autoloader.php');
            XenForo_Autoloader::getInstance()->setupAutoloader('../../forum/library');
            XenForo_Application::initialize('../../forum/library', '../../forum');
            XenForo_Application::set('page_start_time', time());
            self::$instance = new self;
        }
        return self::$instance;
    }
}
