<?php
require '../vendor/autoload.php';

use App\BusinessService\Terminal;
use App\Persistence\DataManager;
use App\Services\CartService;
use App\Services\PrinterService;
use App\Controllers\CartController;

$dataManager = new DataManager();
$cartService = new CartService($dataManager);
$printerService = new PrinterService();

$terminal  = new Terminal($cartService, $printerService);


$productCodes = ["ZA", "YB", "FC", "GD", "ZA", "YB", "ZA", "ZA"]; // this could be obtained by get in the request, example


/* fully working and tests functionality
echo "Case 1 :".$terminal->printOutput($productCodes);

$cartService->resetCart();
$productCodes = ["FC","FC","FC","FC","FC","FC","FC"];

echo "Case 2 :".$terminal->printOutput($productCodes);

$cartService->resetCart();
$productCodes = ["ZA","YB","FC","GD"];

echo "Case 3 :".$terminal->printOutput($productCodes);
*/




$controller = new CartController($terminal);
$controller->Index($productCodes);

