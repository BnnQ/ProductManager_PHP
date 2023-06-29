<?php

use FiveTwo\DependencyInjection\Container;
use Pages\CreateProduct;
use Pages\DeleteProduct;
use Pages\EditProduct;
use Pages\ProductList;
use Services\IProductRepository;
use Services\MySqlLocalProductRepository;

class DependencyContainer
{
    private static ?Container $container = null;

    public static function getContainer(): Container {
        if (self::$container == null) {
            self::$container = new Container();

            self::$container
                ->addSingletonClass(Startup::class)
                ->addTransientClass(Outlet::class)
                ->addTransientClass(ProductList::class)
                ->addTransientClass(CreateProduct::class)
                ->addTransientClass(EditProduct::class)
                ->addTransientClass(DeleteProduct::class)
                ->addSingletonImplementation(IProductRepository::class, MySqlLocalProductRepository::class)
                ->addSingletonClass(MySqlLocalProductRepository::class);
        }

        return self::$container;
    }

}