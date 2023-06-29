<?php

namespace Pages;

require_once "Utils/RouteConstants.php";
use DependencyContainer;
use Services\IProductRepository;
use Utils\Router;

class DeleteProduct
{
    public function __construct(public readonly IProductRepository $productRepository)
    {
        //empty
    }
}

$component = DependencyContainer::getContainer()->get(DeleteProduct::class);

if (isset($_POST['submit'])) {
    $component->productRepository->delete($_POST['id']);
    Router::redirectToLocalPageByKey(ROUTE_List);
} else {
    $product = $component->productRepository->get($_GET['id']);
    ?>
    <div id="body" class="container pt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <h1 class="text-center">Delete</h1>
                <h3 class="text-center">Are you sure you want to delete this?</h3>
                <h4 class="text-center">Product</h4>
                <hr />
                <dl class="row">
                    <dt class="col-sm-2">Title&colon;</dt>
                    <?php echo "<dd class='col-sm-10'>$product->title</dd>";?>
                    <dt class="col-sm-2">Quantity&colon;</dt>
                    <?php echo "<dd class='col-sm-10'>$product->quantity</dd>";?>
                    <dt class="col-sm-2">Manufacturer&colon;</dt>
                    <?php echo "<dd class='col-sm-10'>$product->manufacturer</dd>";?>
                </dl>
                <form method="POST" action="/ProductManager/Outlet.php?page=delete">
                    <?php echo "<input name='id' type='hidden' value='$product->id'/>";?>
                    <div class="form-group d-flex flex-column justify-content-center gap-1">
                        <input type="submit" name="submit" value="Delete" class="btn btn-danger flex-grow-1" />
                        <a class="btn btn-primary flex-grow-1" href="/ProductManager/Outlet.php?page=list">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>