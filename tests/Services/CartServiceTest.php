<?php
namespace App\Tests\Services;

use App\Persistence\DataManager;
use PHPUnit\Framework\TestCase;
use App\Services\CartServiceTest;

class CartServiceTestTest extends TestCase
{
    protected $dataManagerMock = null;


    private function getMockDataManager()
    {
        $expected = [];

        $this->dataManagerMock = $this->getMockBuilder(DataManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $product1 = new \StdClass();
        $product1->code = "ZA";
        $product1->price = "2.00";

        $offer1 = new \StdClass();
        $offer1->when = "4";
        $offer1->percentageoff = "12.5";

        $product1->offer = $offer1;

        $product2 = new \StdClass();
        $product2->code = "YB";
        $product2->price = "12.00";
        $product2->offer = null;

        $expected[] = $product1;
        $expected[] = $product2;

        $this->dataManagerMock
            ->expects($this->exactly(1))
            ->method('readData')
            ->willReturn($expected);

        return $this->dataManagerMock;
    }

    //TESTING PRIVATE METHOD FROM BASE CLASS, not use of reflection
    public function testGetPriceFromProductCodeReturnsOk()
    {

        $cartServiceTest = new CartServiceTest($this->getMockDataManager());

        $cartServiceTest->setTotalPrice(0.00);
        $data = [];
        $cartServiceTest->setProducts($data);

        $productList = [];

        $product1 = new \StdClass();
        $product1->code = "ZA";
        $product1->price = "2.00";

        $offer1 = new \StdClass();
        $offer1->when = "4";
        $offer1->percentageoff = "12.5";

        $product1->offer = $offer1;

        $product2 = new \StdClass();
        $product2->code = "YB";
        $product2->price = "12.00";
        $product2->offer = null;

        $productList[] = $product1;
        $productList[] = $product2;

        $cartServiceTest->setProductList($productList);

        $code = "ZA";
        $expected = 2.00;
        $result = $cartServiceTest->testGetPriceFromProductCode($code);

        $this->assertEquals($expected, $result);
    }
}