<?php
namespace Services;

use Models\Product;

interface IProductRepository {
    /**
     * @return Product[]
     */
    public function getAll() : array;

    public function get(int $id) : Product;

    public function add(Product $entity) : void;
    public function edit(int $id, Product $editedProduct) : void;

    public function delete(int $id) : void;
}