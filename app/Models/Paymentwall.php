<?php

namespace App\Models;

use Paymentwall_Base;
use Paymentwall_GenerericApiObject;

class Paymentwall
{
    public static function deliveryConfirmation($status, $payment_id, $email, $details)
    {
        require_once(dirname(__FILE__) . '../../Framework/Gateway/paymentwall.php');
        Paymentwall_Base::setApiType(Paymentwall_Base::API_GOODS);
        Paymentwall_Base::setSecretKey('1dbaff5f05ace9c26b9fbf42facf1005');        
        $delivery = new Paymentwall_GenerericApiObject('delivery');
        $response = $delivery->post(array(
            'payment_id' => $payment_id,         
            'type' => 'digital',
            'status' => $status,
            'is_test' => 1,
            'estimated_delivery_datetime' => date('Y/m/d H:i:s O'),
            'estimated_update_datetime' => date('Y/m/d H:i:s O'),
            'refundable' => true,
            'details' => $details,
            'shipping_address[email]' => $email,
            'reason' => 'none',
            'attachments[0]' => '',
            'attachments[1]' => '',
        ));        
        if (isset($response['success'])) 
        {
            return 'OK';
        } 
        else if (isset($response['error'])) 
        {
            return $response;            
        }
    }

}