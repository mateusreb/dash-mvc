<?php

namespace App\Controllers;

use Paymentwall_Pingback;
use Paymentwall_Base;
use App\Framework\Xenforo\Xenforo;
use App\Framework\Routing\Request;

//Models
use App\Models\System;
use App\Models\Reports;
use App\Models\Guid;
use App\Models\Paymentwall;
use App\Models\Product;

class PingbackController
{
    public function paymentwall()
    {

        require_once(dirname(__FILE__) . '../../Framework/Gateway/paymentwall.php');
        Paymentwall_Base::setApiType(Paymentwall_Base::API_GOODS);
        Paymentwall_Base::setAppKey('de07078e774b9d6c32dbbc6971d776d3');
        Paymentwall_Base::setSecretKey('46eba02f97a263302d8ac9288c6fbc5d');
        $pingback = new Paymentwall_Pingback($_GET, $_SERVER['REMOTE_ADDR']);
        if ($pingback->validate()) 
        {
            Reports::registerPingBack('Paymentwall', json_encode($_GET)); 
            $user_id = Xenforo::xf()->getUserInfoByName($pingback->getUserId())['user_id'];
            if ($user_id) 
            {                
                if (!System::checkUserExists($pingback->getUserId())) 
                {
                    if (!System::createUser($pingback->getUserId())) 
                    {
                        die("CreateUser ERROR!");
                    }
                }
                if ($pingback->isDeliverable()) 
                {   //send product   
                    if (!System::checkRefExists($pingback->getReferenceId())) 
                    {
                        if (System::insertLicense($user_id, $pingback->getProductId(), $pingback->getProductPeriodLength(), $pingback->getReferenceId())) 
                        {
                            if (Reports::registerTransaction($user_id, $pingback->getProductId(), $pingback->getProductPeriodLength(), $pingback->getProductPrice(), 'Paymentwall', $pingback->getReferenceId(), 0)) 
                            {
                                $delivery = Paymentwall::deliveryConfirmation('delivered', $pingback->getReferenceId(), Xenforo::xf()->getUserInfoByName($pingback->getUserId())['email'], "The product was delivered to the customer on " . date('Y/m/d H:i:s O'));
                                if($delivery == 'OK') 
                                {                                                             
                                    die("OK");
                                }
                                else
                                {
                                    print_r($delivery);
                                    die();
                                }
                            }
                        }
                    }
                } 
                else if ($pingback->isCancelable()) 
                {   //chageback
                    if (System::checkRefExists($pingback->getReferenceId())) 
                    {
                        if (System::banLicense($pingback->getReferenceId())) 
                        {
                            if (Guid::banGuid($user_id, '', 'Paymentwall fraud.')) 
                            {
                                die("OK");
                            }
                        }
                    }
                } 
            }            
            echo 'ERROR';
        } 
        else 
        {
            echo $pingback->getErrorSummary();
        }
    }

    public function payssion()
    {
        $Request = new Request();       // live_5f4f8d1c109eb066  1eef6a02fdc2b6ff50b3051eea9ac718
        $sig = md5(implode('|', array('live_5f4f8d1c109eb066', $Request->input('pm_id'), $Request->input('amount'), $Request->input('currency'), $Request->input('order_id'), $Request->input('state'), '1eef6a02fdc2b6ff50b3051eea9ac718')));
        Reports::registerPingBack('Payssion', json_encode($_POST));
        if ($sig == $Request->input('notify_sig')) 
        {             
            $user_id = Xenforo::xf()->getUserInfoByName($Request->input('order_id'))['user_id'];
            if ($user_id)
            {                
                if (!System::checkUserExists($Request->input('order_id'))) 
                {
                    if (!System::createUser($Request->input('order_id'))) 
                    {
                        die("CreateUser ERROR!");
                    }
                }
                if (!strcmp('completed', $Request->input('state')))
                {//send product   
                    if (!System::checkRefExists($Request->input('transaction_id'))) 
                    {
                        $license = Product::getProductPriceByCost(strstr($Request->input('amount'), '.', true));
                        if (System::insertLicense($user_id,  $license['product_id'], $license['length'], $Request->input('transaction_id'))) 
                        {
                            if (Reports::registerTransaction($user_id, $license['product_id'], $license['length'], $license['cost'], 'Payssion', $Request->input('transaction_id'), 0)) 
                            {
                                Xenforo::xf()->upgradeUser($user_id, Xenforo::SGROUP_PBLA);
                                header('HTTP/1.1 200 OK');
                                die("OK");
                            }
                        }
                    }
                } 
                else if (!strcmp('chargeback', $Request->input('state')))
                {//chageback
                    if (System::checkRefExists($Request->input('transaction_id')))
                    {
                        if (System::banLicense($Request->input('transaction_id')))
                        {
                            if (Guid::banGuid($user_id, '', 'Payssion fraud.'))
                            {
                                header('HTTP/1.1 200 OK');
                                Xenforo::xf()->downgradeUser($user_id, Xenforo::GROUP_USER);
                                die("OK");
                            }
                        }
                    }
                }
            }
        }
        else 
        {
           die("ERROR");
        } 
    }
}
