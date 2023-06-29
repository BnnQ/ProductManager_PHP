<?php

namespace Pages;

use DependencyContainer;
use Services\IProductRepository;

class ProductList
{
    public function __construct(public readonly IProductRepository $productRepository)
    {
        //empty
    }
}

$component = DependencyContainer::getContainer()->get(ProductList::class);
?>

<div id="body" class="container pt-3">
    <div class="row">
        <a href="/ProductManager/Outlet.php?page=create" class="btn btn-success flex-grow-1">Create New</a>
    </div>
    <?php
    $numberOfProducts = count($component->productRepository->getAll());
    echo "<div class='row text-center'>Number of products: $numberOfProducts</div>"
    ?>
    <div class="row">
        <table class="table flex-grow-1 flex-shrink-0">
            <thead>
            <tr>
                <th>
                    Id
                </th>
                <th>
                    Title
                </th>
                <th>
                    Quantity
                </th>
                <th>
                    Manufacturer
                </th>
                <th>
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $products = $component->productRepository->getAll();
            foreach ($products as $product) {
                echo "<tr><td>$product->id</td><td>$product->title</td><td>$product->quantity</td><td>$product->manufacturer</td>";
                echo "<td><ul class='list-inline m-0'><li class='list-inline-item'><a href='/ProductManager/Outlet.php?page=edit&id=$product->id' class='btn btn-outline-warning btn-sm rounded-0' data-toggle='tooltip' title='Edit'><i class='fa-solid fa-pen-to-square'></i></a></li><li class='list-inline-item'><a href='/ProductManager/Outlet.php?page=delete&id=$product->id' class='btn btn-outline-danger btn-sm rounded-0' data-toggle='tooltip' title='Delete'><i class='fa-solid fa-trash-can'></i></a></li></ul></td>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
