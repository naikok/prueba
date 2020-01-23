<?php
namespace App\Controllers;
use \HttpMessage;

/*
 * This can be improved by using an http code interface for making the response better
 *
 */
class CartController
{
    private $terminal;

    public function __construct($terminal)
    {
        $this->terminal = $terminal;
    }

    public function index($productCodes)
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