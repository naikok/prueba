<?php
namespace App\Persistence;

interface IDataManager
{
    public function readData() : array; // return array
}