<?php
namespace App\BusinessService;

use App\Persistence\DataManager;
use App\Services\CartService;
use App\Entity\Product;
use App\Services\PrinterService;

class Terminal
{
    public $cartService = null;
    public $dataManager = null;
    public $printerService = null;

    /**
     *
     * Constructor
     * @param CartService $cartService
     * @param PrinterService $printerService
     * @return bool
     *
     */

    public function __construct(CartService $cartService, PrinterService $printerService)
    {
        $this->cartService = $cartService;
        $this->printerService = $printerService;
    }

    /**
     * Function for adding a new item into the cart
     * @param
     * @param string $code
     * @return Product[]
     *
     */

    public function scanItem(string $code) : array
    {
        return $this->cartService->addItem($code);
    }

    /**
     * Function that returns the price from all products within the cart
     * @return float
     *
     */

    public function getTotal() : float
    {
        return $this->cartService->getCartPrice();
    }

    /**
     * Function that returns all products included within the cart
     * @param
     * @return Product[]
     *
     */

    public function getProducts() : array
    {
        return $this->cartService->getProductsOnCart();
    }

    /**
     * Function that gets the total price from specific productcodes
     * @param
     * @return String
     *
     */

    public function printOutput(array $productCodes) : string
    {
        foreach ($productCodes as $productCode) {
            $this->scanItem($productCode);
        }

        return $this->printerService->printResult($this->getTotal(), $productCodes);
    }
}
