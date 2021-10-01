<?php

namespace App\Controllers;

use App\Framework\Template\View;
use App\Framework\Helpers\Modals;
use App\Framework\Routing\Request;
use App\Framework\Routing\Redirect;
use App\Framework\Helpers\Csrf;

//Model
use App\Models\Licenses;
use App\Models\Product;

class LicensesController extends Controller
{
    public function createLicense()
    {
        $this->protect();
        $this->admin();
        $this->data['pagetitle'] = 'Create New License';
        $this->data['product-list'] = Product::listProducts();
        return View::make('admin.create-license', $this->data);
    }

    public function editLicense($license_id)
    {
        $this->protect();
        $this->admin();
        $this->data['pagetitle'] = 'Edit License';
        $this->data['license-info'] = Licenses::getLicenseInfo($license_id);
        $this->data['product-list'] = Product::listProducts();
        return View::make('admin.edit-license', $this->data);
    }

    public function manageLicenses($page_id = 1)
    {
        $this->protect(); 
        $this->admin();       
        $this->data['pagetitle'] = 'Manage Licenses';
        $this->data['page-id'] = $page_id;
        $this->data['licenses'] = Licenses::listLicenses($page_id);     
        $this->data['licenses-count'] = Licenses::licensesCount();   
        $this->data['modal'] = Modals::Alert(
            'modalDeleteLicense',
            'Attention',
            'Do you want to delete this license?',
            'warning',
            'exclamation-triangle',
            ['license-id'],
            '/delete-license'
        );
        return View::make('admin.manage-licenses', $this->data);
    }

    public function postDeleteLicense()
    {
        $this->protect();
        $this->admin();
        $Request = new Request();
        if(Csrf::validate($Request->input('_csrf')))
        { 
            if(Licenses::deleteLicense($Request->input('license-id')))
            {
                return Redirect::to(
                    '/manage-licenses',
                    ['alert-type' => 'success',
                    'alert-text' => "License successfully deleted."]
                );
            }
        }
        return Redirect::to(
            '/manage-licenses',
            ['alert-type' => 'danger',
            'alert-text' => 'Problem deleting license.']
        );
    }

    public function postCreateLicense()
    {
        $this->protect();
        $this->admin();
        $Request = new Request();
        if(Csrf::validate($Request->input('_csrf')))
        {      
            if(Licenses::createLicense($Request->body()))
            {                
                return Redirect::to(
                    "/manage-licenses",
                     ['alert-type' => 'success',
                      'alert-text' => 'License successfully created.']
                );
            }
        }
        return Redirect::to(
            "/manage-licenses",
            ['alert-type' => 'danger',
            'alert-text' => 'Problem to create license.']
        );
    }

    public function postEditLicense()
    {
        $this->protect();
        $this->admin();
        $Request = new Request();
        $license_id = $Request->input('license-id');

        if(Csrf::validate($Request->input('_csrf')))
        {           
            if(Licenses::updateLicense($Request->body(), $license_id))
            {
                return Redirect::to(
                    "/edit-license/{$license_id}",
                     ['alert-type' => 'success',
                      'alert-text' => 'License information successfully updated.']
                );
            }
        }
        return Redirect::to(
            "/manage-licenses/{$license_id}",
            ['alert-type' => 'danger',
            'alert-text' => 'Problem modifying license information.']
        );
    }

    public function postEditAllLicense()
    {
        $this->protect();
        $this->admin();
        $Request = new Request();  
  
        if(Csrf::validate($Request->input('_csrf')))
        {              
            $type = $Request->input('method') == 'add' ? 'ADD' : 'SUB';            
            if(Licenses::updateAllLicenses($Request->input('length'), $type))
            {
                return Redirect::to(
                    '/manage-licenses/',
                     ['alert-type' => 'success',
                      'alert-text' => 'License expiration successfully updated.']
                );
            }
        }
        return Redirect::to(
            '/manage-licenses/',
            ['alert-type' => 'danger',
            'alert-text' => 'Problem modifying all license expiration.']
        );
    }
    
    public function searchLicense()
    {
        $this->protect();  
        $this->admin();
        $Request = new Request();
        if($Request->input('search'))           
        {   
            $this->data['pagetitle'] = 'Manage Licenses';            
            $this->data['licenses'] = Licenses::filterLicenses(
                $Request->input('search')                                
            );
            $this->data['licenses-count'] = count($this->data['licenses']);
            
            $this->data['modal'] = Modals::Alert(
                'modalDeleteLicense',
                'Attention',
                'Do you want to delete this license?',
                'warning',
                'exclamation-triangle',
                ['user-id'],
                '/delete-license'
            );
            return View::make('admin.search-license', $this->data);
        }
        echo("teste");
    }
}