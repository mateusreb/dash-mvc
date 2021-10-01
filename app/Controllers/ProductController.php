<?php
namespace App\Controllers;

use App\Framework\Template\View;
use App\Framework\Routing\Request;
use App\Framework\Routing\Redirect;
use App\Framework\Helpers\Csrf;
use App\Framework\Helpers\Modals;

//Model
use App\Models\Product;

class ProductController extends Controller
{    
    public function manageProducts()
    {
        $this->protect();
        $this->admin();
        $this->data['pagetitle'] = 'Manage Products';   
        $this->data['product-list'] = Product::listProducts(); 
        $this->data['modal'] = Modals::Alert(
            'modalDeleteProduct',
            'Attention',
            'Do you want to delete this product?',
            'warning',
            'exclamation-triangle',
            ['product-id'],
            '/manage-products/detete'
        );              
        return View::make('admin.manage-products', $this->data);
    }

    public function editProduct($product_id)
    {
        $this->protect();
        $this->admin();
        $this->data['product-info'] = Product::getProductInfo($product_id);
        if($this->data['product-info'])
        {
            $this->data['pagetitle'] = 'Edit Product - ' . $this->data['product-info']['name']; 
            return View::make('admin.edit-product', $this->data);
        }
        else
        {
            return Redirect::to(
                '/manage-products',
                ['alert-type' => 'danger',
                'alert-text' => 'Product not found.']
            );
        }
    }

    public function createProduct()
    {
        $this->protect();
        $this->admin();
        $this->data['_csrf'] = Csrf::generate();
        $this->data['pagetitle'] = 'Create New Product'; 
        return View::make('admin.create-product', $this->data);
    }

    public function postEditProduct()
    {
        $this->protect();
        $this->admin();
        $Request = new Request();
        if(Csrf::validate($Request->input('_csrf')))
        {         
            $product_id = $Request->input('product_id');            
            if(Product::updateProduct($Request->body(), $product_id))
            {
                return Redirect::to(
                    "/manage-products/edit/{$product_id}",
                     ['alert-type' => 'success',
                      'alert-text' => 'Product information successfully updated.']
                );
            }
        }
        return Redirect::to(
            "/manage-products/{$product_id}/edit",
            ['alert-type' => 'danger',
            'alert-text' => 'Problem modifying product information.']
        );
    }

    public function postCreateProduct()
    {
        $this->protect();
        $this->admin();
        $Request = new Request();
        if(Csrf::validate($Request->input('_csrf')))
        {         
            if(Product::createProduct($Request->body()))
            {
                return Redirect::to(
                    '/manage-products',
                    ['alert-type' => 'success',
                    'alert-text' => 'Successfully created product.']
                );
            }
        }
        return Redirect::to(
            '/manage-products/create',
            ['alert-type' => 'danger',
            'alert-text' => 'Problem creating a new product.']
        );
    }

    public function postDeleteProduct()
    {
        $this->protect();
        $this->admin();
        $Request = new Request();
        if(Csrf::validate($Request->input('_csrf')))
        { 
            if(Product::deleteProduct($Request->input('product-id')))
            {
                return Redirect::to(
                    '/manage-products',
                    ['alert-type' => 'success',
                    'alert-text' => "Product successfully deleted ( {$Request->input('product-id')} )."]
                );
            }
        }
        return Redirect::to(
            '/manage-products',
            ['alert-type' => 'danger',
            'alert-text' => 'Problem deleting product.']
        );
    }
}