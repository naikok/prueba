<?php
namespace App\Tests;

use App\BusinessService\Terminal;
use App\Services\CartService;
use PHPUnit\Framework\TestCase;
use App\Entity\Product;
use App\Services\PrinterService;

class TerminalTest extends TestCase
{
    protected $cartServiceMock = null;
    protected $printerServiceMock = null;

    public function testScanItemReturnArray()
    {
        $this->cartServiceMock = $this->getMockBuilder(CartService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->printerServiceMock = $this->getMockBuilder(PrinterService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $code= "ZA";
        $price = 2.00;

        $output = [];
        $product = new Product();
        $product->setCode($code);
        $product->setPrice($price);

        $output[] = $product;

        $this->cartServiceMock
            ->expects($this->once())
            ->method('addItem')
            ->with($code)
            ->willReturn($output);

        $terminal = new Terminal($this->cartServiceMock, $this->printerServiceMock);
        $resultado = $terminal->scanItem($code);

        $this->assertTrue(is_array($resultado) && !empty($resultado));

        if (is_array($resultado) && !empty($resultado)){
            foreach($resultado as $item) {
                $this->assertTrue($item instanceof Product);
            }
        }

        $this->assertEquals($code, $resultado[0]->getCode());
    }

    public function testGetTotalReturnFloat()
    {
        $this->cartServiceMock = $this->getMockBuilder(CartService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->printerServiceMock = $this->getMockBuilder(PrinterService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $expected = 2.00;

        $this->cartServiceMock
            ->expects($this->once())
            ->method('getCartPrice')
            ->willReturn($expected);

        $terminal = new Terminal($this->cartServiceMock, $this->printerServiceMock);
        $price = $terminal->getTotal();
        $this->assertEquals($expected, $price);
    }

    public function testGetProductsReturnArray()
    {
        $this->cartServiceMock = $this->getMockBuilder(CartService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->printerServiceMock = $this->getMockBuilder(PrinterService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $code= "ZA";
        $price = 2.00;

        $output = [];
        $product = new Product();
        $product->setCode($code);
        $product->setPrice($price);

        $output[] = $product;

        $this->cartServiceMock
            ->expects($this->once())
            ->method('getProductsOnCart')
            ->willReturn($output);

        $this->printerServiceMock = $this->getMockBuilder(PrinterService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $terminal = new Terminal($this->cartServiceMock, $this->printerServiceMock);
        $products = $terminal->getProducts();

        $this->assertIsArray($products);
        $this->assertCount(1, $products);
    }

    public function testPrintOutputReturnString()
    {

        $this->cartServiceMock = $this->getMockBuilder(CartService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->printerServiceMock = $this->getMockBuilder(PrinterService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $productCodes = ["ZA","YB"];

        $product1 = new Product();
        $product1->setCode("ZA");
        $product1->setPrice("2.00");

        $product2 = new Product();
        $product2->setCode("YB");
        $product2->setPrice("12.00");

        $products = [];
        $products[] = $product1;
        $products[] = $product2;

        $this->cartServiceMock
            ->expects($this->exactly(2))
            ->method('addItem')
            ->withAnyParameters()
            ->willReturn($products);

        $expected = "Total Price is: 14.00 for sequence: ZA, YB";

        $this->printerServiceMock
            ->expects($this->exactly(1))
            ->method('printResult')
            ->withAnyParameters()
            ->willReturn($expected);

        $terminal = new Terminal($this->cartServiceMock, $this->printerServiceMock);
        $result = $terminal->printOutput($productCodes);

       $this->assertEquals($expected, $result);
    }

}