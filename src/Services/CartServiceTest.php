<?php
namespace App\Services;

use App\Persistence\IDataManager;
use App\Services\CartService;
use App\Entity\Product;

class CartServiceTest extends CartService
{
    /**
     *
     * Constructor
     * @param IDataManager $dataManager is the object that get access to the datasource, should be the type of the Interface IDataManager
     *
     */
    public function __construct(IDataManager $dataManager)
    {
        parent::__construct($dataManager);
    }

    /**
     * Function that sets the var totalPrice
     * @param float $price
     * @return void
     *
     */

    public function setTotalPrice(float $price): void
    {
        $this->totalPrice = $price;
    }

    /**
     * Function setProducts is the responsible for saving the products into the cart
     * @param Product[] $data
     * @return void
     *
     */

    public function setProducts(array $data) : void
    {
        $this->products = $data;
    }

    /**
     * Function that sets the whole list of products coming from the datasource
     * @param \StdClass[] $data
     * @return void
     *
     */

    public function setProductList(array $data) : void
    {
        $this->productList = $data;
    }

    /**
     * Function that checks the function getPriceFromProduct code from the base class, as it is a private method, we make it publick
     * @param \StdClass[] $data
     * @return void
     *
     */

    public function testGetPriceFromProductCode(string $code) : float
    {
        return parent::getPriceFromProductCode($code);
    }
}