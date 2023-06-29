<?php

require_once 'Startup.php';
require_once 'Models/Route.php';
require_once 'DependencyContainer.php';
require_once 'vendor/autoload.php';

use Utils\Router;


class Outlet {
    public function __construct()
    {
    }
}

$component = DependencyContainer::getContainer()->get(Outlet::class);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>1</title>
    <?php require_once "CommonStylesheets.php" ?>
</head>
<body>
<script src="/ProductManager/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<?php
$dependencyContainer = DependencyContainer::getContainer();
$startup = $dependencyContainer->get(Startup::class);

$routes = Router::getRoutes();

$currentPageKey = $_GET["page"] ?? "list";
if (str_contains($currentPageKey, '?'))
    $currentPageKey = explode('?', $currentPageKey)[0];

include_once $routes[strtolower($currentPageKey)];
?>
</body>
</html>