<?php
namespace App\Services;

class PrinterService
{

    /**
     * Function that gets the total price from specific productcodes
     * @param array $productsCodes are the productcodes from products, for example ["ZA","YB"]
     * @param float $total is the total price from the cart
     * @return String
     *
     */

    public function printResult(float $totalPrice, array $productsCodes) : string
    {
       $total = (string) $totalPrice;
       $sequence = implode(', ', $productsCodes);

       return  "Total Price is: " . $totalPrice." for sequence: ".$sequence;
    }
}