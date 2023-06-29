<?php

require_once "Utils\Router.php";
use Models\Route;
use Utils\Router;

class Startup
{
    public function __construct()
    {
        Router::registerRoute(new Route(key: "list", pagePath: "Pages/ProductList.php"));
        Router::registerRoute(new Route(key: "create", pagePath: "Pages/CreateProduct.php"));
        Router::registerRoute(new Route(key: "edit", pagePath: "Pages/EditProduct.php"));
        Router::registerRoute(new Route(key: "delete", pagePath: "Pages/DeleteProduct.php"));
    }
}