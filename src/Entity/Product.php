<?php
namespace App\Entity;

class Product
{
    protected $code;
    protected $price;
    protected $quantity = 0;

    public function getCode() : string
    {
        return $this->code;
    }

    public function setCode(string $code) : void
    {
        $this->code = $code;
    }

    public function getPrice() : float
    {
        return $this->price;
    }

    public function setPrice(float $price) : void
    {
        $this->price = $price;
    }

    public function getQuantity() : int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity) : void
    {
        $this->quantity = $quantity;
    }
}

