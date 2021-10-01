<?php

namespace App\Controllers;

use App\Framework\Template\View;
use App\Framework\Xenforo\Xenforo;
use App\Framework\Helpers\Csrf;
use App\Framework\Routing\Redirect;
use App\Framework\Routing\Request;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Checkout\Session;

class BuyController extends Controller
{
  public function checkout()
  {
    $this->data['pagetitle'] = 'Stripe';
    $this->data['description'] = '';
    return View::make('user.purchase.stripe', $this->data);
  }

  public function sucess()
  {
    //$this->data['pagetitle'] = 'Stripe';
    //$this->data['description'] = '';
    //return View::make('user.purchase.stripe', $this->data);
    echo 'success';
  }

  public function checkoutSession()
  {
    $apikey = 'sk_test_51HFHmtLZVrpu8S5YDvw4m47NY7xdiIGPOwM1vyiJv7jUss7fsOYa4D2S6QFqa1d3UJsB5nAtIXx8gpUloWrTEb6Z00S9vdLpi0';
    require_once(dirname(__FILE__) . '../../Framework/Gateway/stripe.php');
    Stripe::setApiKey($apikey);
    //print_r(Customer::retrieve('ClienteTeste'));

    //$customer = Customer::create(['id' => 'ClienteTeste', 'description' => 'My First Test Customer (created for API docs)']);
    //print_r($customer);
    //$stripe = new \Stripe\StripeClient($apikey);
    /*$session = Session::create([
      'customer' => 'ClienteTeste',
      'payment_method_types' => ['card'],
      'line_items' => [[
        'price_data' => [
          'currency' => 'usd',
          'product_data' => [
            'name' => 'VIP PBLA',
          ],
          'unit_amount' => 900,
        ],
        'quantity' => 1,
      ]],
      'mode' => 'payment',
      'success_url' => 'http://panel.localhost.com/stripe-success',
      'cancel_url' => 'http://panel.localhost.com/stripe-checkout',
    ]);
    $response = array(
      'status' => 1,
      'message' => 'Checkout Session created successfully!',
      'sessionId' => $session['id']
    );
    echo json_encode($response);*/
  }
}
