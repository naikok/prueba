<?php
namespace App\Services;

use App\Entity\Product;
use App\Persistence\IDataManager;
use App\Services\ICartService;

class CartService implements ICartService
{
    protected $products = null;
    protected $dataManager = null;
    protected $productList = [];
    protected $totalPrice = null;

    /**
     *
     * Constructor
     * @param IDataManager $dataManager is the object that get access to the datasource, should be the type of the Interface IDataManager
     *
     */

    public function __construct(IDataManager $dataManager)
    {
        $this->products = []; //it will be containing the product line
        $this->dataManager = $dataManager;
        $this->productList = $this->dataManager->readData(); //database or json list
        $this->totalPrice = 0.00;
    }

    /**
     * Function that search into the datasource the price by product code, it returns a float with the price associated to the product
     * @param string $code, for example ZA
     * @return float
     *
     */

    private function getPriceFromProductCode(string $code) : float
    {
        $price = 0.00;

        if (is_array($this->productList) && !empty($this->productList)) {
            foreach($this->productList as $product) {
                if ($product->code == $code) {
                    $price = (float) $product->price;
                    break;
                }
            }
        }

        return $price;
    }

    /**
     * Function that search into the datasource if exists any discount associated to the product code
     * @param string $code, for example ZA
     * @return \StdClass
     *
     */

    private function checkDiscountFromProductCode(string $code) : \StdClass
    {
        $discount = new \StdClass();
        if (is_array($this->productList) && !empty($this->productList)) {
            foreach($this->productList as $product) {
                if ($product->code == $code) {
                    if (!is_null($product->offer)) {
                        $discount = $product->offer;
                        break;
                    }
                }
            }
        }

        return $discount;
    }

    /**
     * Function that returns a price for a specific product codes, it returns the complete price associated to its ammount of products
     * @param Product $product
     * @return float
     *
     */

    private function calculatePriceFromProductLine(Product $product) : float
    {
        $itemsForProduct = (int) $product->getQuantity();
        $quantity = (float) $itemsForProduct;

        $priceProduct = (float) $product->getPrice();
        $price = $quantity * $priceProduct;
        $discount = $this->checkDiscountFromProductCode($product->getCode());

        if (isset($discount) && property_exists($discount, 'when') && property_exists( $discount, 'percentageoff')) {
            $whenQuantity = (int) $discount->when;
            $offPercentage = (float) $discount->percentageoff;

            $resto = (int) ($itemsForProduct % $whenQuantity);

            if ($resto == 0) {
                $priceOff = ($offPercentage / 100) * $price;
                $price = (float) ($price - $priceOff);
            }

            if ($resto > 0) {
                $priceBase = (float) $this->getPriceFromProductCode($product->getCode());
                $priceOff = ($offPercentage / 100) * $priceBase;
                $numberProductsWithDisccount = (float) ($itemsForProduct - $resto);
                $priceDisccount = (float) ($priceBase - $priceOff) * $numberProductsWithDisccount;
                $priceNormal = (float) ($priceBase * $resto);
                $price = (float) ($priceDisccount + $priceNormal);
            }
        }

        return $price;
    }

    /**
     * Function that search in the list of products added, if it was already there, the product found is returned,
     * otherwise throws an Exception because object was not
     * already added into the cart
     * @param Product $product
     * @return Product
     *
     */

    private function checkIfExistsItemOnCart(string $code) : Product
    {
        $productFound = null;

        if (is_array($this->products) && !empty($this->products)) {
            foreach($this->products as $product) {
                if ($product->getCode() == $code) {
                    $productFound = $product;
                    break;
                }
            }
        }

        if (is_null($productFound)) {
            throw new \Exception("Object not found already on cart");
        }

        return $productFound;
    }

    /**
     * Function that set the total price for the cart into the var $totalPrice
     * @param float $price
     * @return void
     *
     */

    public function setTotalPrice(float $price) : void
    {
        $this->totalPrice = $this->totalPrice + $price;
    }

    /**
     * Function that returns the totalPrice in order to get the total price for the cart
     * @return float
     *
     */

    public function getTotalPrice() : float
    {
        return $this->totalPrice;
    }

    /**
     * Function that add an item into the cart by a product code provided as parameter
     * @param string $code
     * @return void
     *
     */

    public function addItem(string $code) : array
    {
        $price = (float) $this->getPriceFromProductCode($code);

        if ($price > 0.00) {
            try {
                //we update quantity for that product as it was already on the cart
                $product = $this->checkIfExistsItemOnCart($code);
            } catch(\Exception $e){
                //new Product generated on the cart
                $product = new Product();
            }

            $product->setCode($code);
            $product->setPrice($price);
            $quantity = $product->getQuantity() + 1;
            $product->setQuantity($quantity);
        }

        $this->products[] = $product;

        return $this->products;
    }

    /**
     * Function used to remove an item from the cart, not implemented yet as is not required for the problem so far
     *
     * @param string $code
     * @return Product[]
     *
     */

    public function removeItem(string $code): array
    {
        // TODO: Implement removeItem() method.
    }

    /**
     * Function used to remove an item from the cart, not implemented yet
     *
     * @param string $code
     * @return Product[]
     *
     */

    public function resetCart(): void
    {
        $this->products = []; //it will be containing the product line
        $this->productList = $this->dataManager->readData(); //database or json list
        $this->totalPrice = 0.00;
    }

    /**
     * Function that returns the whole list of products added into the cart
     *
     * @param string $code
     * @return Product[]
     *
     */
    
    public function getProductsOnCart() : array
    {
       return $this->products;
    }

    /**
     * Function that returns the price from the whole cart
     * @return float
     *
     */
    
    public function getCartPrice() : float
    {
        $productLines = [];

        if (is_array($this->products) && !empty($this->products)) {
            foreach($this->products as $key => $product) {
                if (!in_array($product->getCode(), $productLines)) {
                    $priceProductItems = (float)$this->calculatePriceFromProductLine($product);
                    $productLines[] = $product->getCode();
                    $this->setTotalPrice($priceProductItems);
                }
            }
        }

        return $this->getTotalPrice();
    }
}
