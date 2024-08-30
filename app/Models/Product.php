<?php

namespace App\Models;

abstract class Product
{   
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct($id, $sku, $name, $price, $type , ...$args)
    {
        $this->setId($id);
        $this->setSku($sku);
        $this->setName($name);
        $this->setPrice($price);
        $this->setType($type);

        $this->initializeAdditionalAttributes(func_get_args());
    }
    abstract protected function initializeAdditionalAttributes(array $args);


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
    abstract public function getAdditionalAttributes();



    
    abstract public function saveAttributes($productId, $dbConnection);
 
    public static function createProductFromRow(array $row): self
    {
        $type = strtolower($row['product_type']);
        $class = 'App\\Models\\' . ucfirst($type);
    
        // Debugging output
    
        if (class_exists($class)) {
            return $class::createFromRow($row);
        }
    
        throw new \Exception("Invalid product type: " . $type);
    }
    
    

    
}