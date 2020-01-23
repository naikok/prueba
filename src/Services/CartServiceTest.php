<?php
namespace App\Services;

use App\Persistence\IDataManager;
use App\Services\CartService;

class CartServiceTest extends CartService
{
    public function __construct(IDataManager $dataManager)
    {
        parent::__construct($dataManager);
    }

    protected $products = [];
    protected $dataManager = null;
    protected $productList = [];
    protected $totalPrice = 0.00;

    public function setTotalPrice(float $price): void
    {
        $this->totalPrice = $price;
    }

    public function setProducts(array $data) : void
    {
        $this->products = $data;
    }

    public function setProductList(array $data) : void
    {
        $this->productList = $data;
    }

    public function testGetPriceFromProductCode(string $code) : float
    {
        return parent::getPriceFromProductCode($code);
    }
}