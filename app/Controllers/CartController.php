<?php

namespace Cart\Controllers;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Cart\Models\Product;
use Slim\Router;
use Cart\Basket\Basket;


class CartController{


    protected $basket;
    protected $product;

   public function __construct(Basket $basket, Product $product){

   	   $this->basket = $basket;
   	   $this->product = $product;


   }


	public function index(Request $request, Response $response, Twig $view)

	{
		

	return $view->render($response, 'cart/index.twig');	
	
	
     }

     public function add($slug, $quantity, Request $request, Response $response,Router $router)
     {
              $product = $this->product->where('slug', $slug)->first();

              if(!$product){

              	return $response->withRedirect($router->pathFor('home'));
              }

              try {
              	
              	$this->basket->add($product, $quantity);
                 

              }
              catch (QuantityExceededException $e){

                   //

              }
                

                return $response->withRedirect($router->pathFor('cart.index'));
     }

}