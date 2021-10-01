<?php

namespace App\Controllers;

use App\Framework\Template\View;
use App\Framework\Xenforo\Xenforo;
use App\Framework\Helpers\Csrf;
use App\Framework\Routing\Redirect;
use App\Framework\Routing\Request;

//Models
use App\Models\User;
use App\Models\Product;
use App\Models\Guid;
use App\Models\Download;

class UserController extends Controller
{
    public function purchase()
    {        
        $this->protect();
        $this->data['pagetitle'] = 'Purchase';
        $this->data['subtitle'] = '';
        $this->data['product-list'] = Product::listProducts();
        $this->data['buy-info'] = Xenforo::xf()->getUserInfoByName($this->data['username']);
        return View::make('user.purchase', $this->data);
    }

    public function purchaseSelect($product_id)
    {
        $this->protect();
        $this->data['pagetitle'] = 'Plans';
        $this->data['subtitle'] = '';
        $this->data['buy-info'] = Xenforo::xf()->getUserInfoByName($this->data['username']);
        $this->data['product-info'] = Product::listProductPrices($product_id);
        $this->data['product_name'] = Product::getProductInfo($product_id)['name'];
        return View::make('user.purchase.select', $this->data);
    }    

    public function payssion()
    {
        $this->protect();
        $this->data['pagetitle'] = 'Payssion';
        $this->data['subtitle'] = '';
        $this->data['buy-info'] = Xenforo::xf()->getUserInfoByName($this->data['username']);
        return View::make('user.payssion', $this->data);
    }

    public function download()
    {
        $this->protect();
        $this->data['pagetitle'] = 'Download';
        $this->data['subtitle'] = '';
        $this->data['download-list'] = User::getDownloads($this->data['user-id']);
        return View::make('user.download', $this->data);
    }

    public function licenses()
    {
        $this->protect();
        $this->data['pagetitle'] = 'Download';
        $this->data['subtitle'] = '';
        $this->data['download-list'] = User::getDownloads($this->data['user-id']);
        return View::make('user.download', $this->data);
    }

    public function token()
    {
        $this->protect();
        $this->data['pagetitle'] = 'Reset Token';
        $this->data['subtitle'] = 'Here you can reset your token.';
        $this->data['token-information'] = Guid::guidInformation($this->data['user-id']);
        $this->data['token-information']['status'] = Guid::guidIsBanned($this->data['token-information']['guid'], $this->data['user-id']);
        return View::make('user.token', $this->data);
    }

    public function postPurchaseFinish()
    {
        $Request = new Request();
        if (Csrf::validate($Request->input('_csrf'))) 
        {
            if($Request->input('plan'))
            {
                $this->protect();
                $this->data['pagetitle'] = 'Checkout';
                $this->data['subtitle'] = '';
                $this->data['buy-info'] = Xenforo::xf()->getUserInfoByName($this->data['username']);
                $this->data['price-info'] = Product::getProductPrice($Request->input('plan'));  
                $this->data['product-info'] = Product::getProductInfo($this->data['price-info']['product_id']);            
                return View::make('user.purchase.finish', $this->data);
            }
            else
            {
                return Redirect::to(
                    "/purchase",
                    [
                        'alert-type' => 'danger',
                        'alert-text' => 'please, selecta a plan.'
                    ]
                );
            }
        }
        return Redirect::to(
            "/purchase",
           [
                'alert-type' => 'danger',
                'alert-text' => 'An unexpected error has occurred, please try again.'
            ]
        );
    }

    public function postDownload()
    {
        $Request = new Request();
        if (Csrf::validate($Request->input('_csrf'))) 
        {
            if(Download::download($this->data['username']))
            {
                return;
            }              
        }       
        return Redirect::to(
            "/purchase",
            [
                'alert-type' => 'danger',
                'alert-text' => 'For security reasons try downloading again.'
            ]
        );        
    }

    public function postResetToken()
    {
        $Request = new Request();
        if (Csrf::validate($Request->input('_csrf'))) {
            if (Guid::resetGuid($this->data['user-id'])) {
                return Redirect::to(
                    '/reset-token',
                    [
                        'alert-type' => 'success',
                        'alert-text' => 'Token reset successfully.'
                    ]
                );
            } else {
                return Redirect::to(
                    '/reset-token',
                    [
                        'alert-type' => 'danger',
                        'alert-text' => 'Problem when resetting token.'
                    ]
                );
            }
        }
    }

    public function transactions()
    {
        $this->protect();
        $this->data['pagetitle'] = 'Transactions';
        $this->data['subtitle'] = 'Here shows your last transactions.';
        $this->data['user-transactions'] = User::getTransactions($this->data['user-id']);
        return View::make('user.transactions', $this->data);
    }

    public function connections()
    {
        $this->protect();
        $this->data['pagetitle'] = 'Connections';
        $this->data['subtitle'] = '';
        $this->data['login-log'] = User::connectionsLog($this->data['user-id']);
        return View::make('user.connections', $this->data);
    }
}
