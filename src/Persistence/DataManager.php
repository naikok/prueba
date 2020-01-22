<?php
namespace App\Persistence;
use App\Persistence\IDataManager;

class DataManager implements IDataManager
{
    CONST DATA_SOURCE = "/Persistence/DataSource/ProductPrices.json";

    /**
     * Function that read the main file from a specific path provided
     *
     * @param string $path is the directory where the file is located
     * @return string
     *
     */

    private function readFile(string $path) : string
    {
        return file_get_contents($path);
    }

    /**
     * Function that read the main datasource, in this case read a json but could be a database, csv, file...
     * In order to improve this we can use a factory that give us more flexibiliy
     * @param array $productsCodes are the productcodes from products, for example ["ZA","YB"]
     * @param float $total is the total price from the cart
     * @return array of StdClass
     *
     */

    public function readData() : array //return array of stdclcass
    {
        $path = getcwd() . self::DATA_SOURCE;
        $data = $this->readFile($path);

        $data = json_decode($data);


        return $data;
    }
}