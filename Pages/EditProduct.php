<?php

namespace Pages;

require_once "Utils/RouteConstants.php";
use DependencyContainer;
use Models\Product;
use Services\IProductRepository;
use Utils\Router;

class EditProduct
{
    public function __construct(public readonly IProductRepository $productRepository)
    {
        //empty
    }
}

$component = DependencyContainer::getContainer()->get(EditProduct::class);

if (isset($_POST['submit'])) {
    $product = Product::parseFromAssoc($_POST);
    $component->productRepository->edit($product->id, $product);
    Router::redirectToLocalPageByKey(ROUTE_List);
} else {
    $product = $component->productRepository->get($_GET['id']);
    ?>
    <div id="body" class="container pt-3">
        <div class="row">
            <h1>Edit</h1>
            <h4>Product</h4>
            <hr />
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <form method="POST" action="/ProductManager/Outlet.php?page=edit">
                        <?php echo "<input name='id' type='hidden' value='$product->id'/>";?>
                        <div class="form-group">
                            <label for="title" class="control-label">Title:</label>
                            <?php echo "<input name='title' id='title' type='text' class='form-control' value='$product->title' required/>";?>
                        </div>
                        <div class="form-group">
                            <label for="quantity" class="control-label">Quantity:</label>
                            <?php echo "<input name='quantity' id='quantity' type='number' class='form-control' value='$product->quantity' required/>";?>
                        </div>
                        <div class="form-group">
                            <label for="manufacturer" class="control-label">Manufacturer:</label>
                            <?php echo "<input name='manufacturer' id='manufacturer' type='text' class='form-control' value='$product->manufacturer' required/>";?>
                        </div>
                        <div class="form-group pt-2">
                            <div>
                                <input type="submit" name="submit" value="Save" class="btn btn-primary w-100"/>
                            </div>
                            <div class="pt-1">
                                <a class="btn btn-secondary w-100" href="/ProductManager/Outlet.php?page=list">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>