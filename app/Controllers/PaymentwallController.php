<?php

namespace App\Controllers;

use Paymentwall_Base;
use Paymentwall_Pingback;
use App\Framework\Xenforo\Xenforo;

//Models
use App\Models\System;
use App\Models\Reports;
use App\Models\Guid;

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
                                die("OK");
                            }
                        }
                    }
                } else if ($pingback->isCancelable()) 
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
                        die('removeLicense');
                    }
                    die('checkRefExists');
                } else if ($pingback->isUnderReview()) 
                {
                    // set "pending" status to order
                    echo '3';
                }
            }
            echo 'ERROR'; // Paymentwall expects response to be OK, otherwise the pingback will be resent
        } else 
        {
            echo $pingback->getErrorSummary();
        }
    }

    public function confirmation()
    {
        echo 'OK';
    }

    public function payssion()
    {
        header('HTTP/1.1 200 OK');
        //Reports::registerPingBack('Payssion', json_encode($_GET)); 
        $fp = fopen('log.txt', 'a');
        fwrite($fp, "Log: " . json_encode($_GET) . "\n");
		fwrite($fp, "Log: " . json_encode($_POST) . "\n");
        fclose($fp);
        echo "OK";
    }
}
