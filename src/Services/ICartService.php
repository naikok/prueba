<?php
namespace App\Services;
use App\Entity\Product;

interface ICartService
{
    public function resetCart() : void;

    public function addItem(string $code) : array; // return array of products

    public function removeItem(string $code) : array; // return array of products

    public function getTotalPrice() : float;

    public function setTotalPrice(float $price) : void;

    public function getProductsOnCart() : array; //return array of products

    public function getCartPrice() : float; //return float
}
