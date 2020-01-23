<?php
namespace App\Controllers;

use App\BusinessService\Terminal;

class CartController
{
    private $terminal;

    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function index(array $productCodes) : string
    {
        header('Content-Type: application/json');

        try {
            $response = (["status" => 200, "message" => $this->terminal->printOutput($productCodes)]);
        } catch(\Exception $e) {
            $response = (["status" => $e->getCode(), "message" => $e->getMessage()]);
        }

        echo $response;
    }
}
