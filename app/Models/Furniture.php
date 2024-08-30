<?php

namespace App\Models;

class Furniture extends Product

{
    private $height;
    private $width;
    private $length;

    protected function initializeAdditionalAttributes(array $args)
    {
        $this->setHeight($args[5] ?? null);
        $this->setWidth($args[6] ?? null);
        $this->setLength($args[7] ?? null);
    }

    // Getters
 
    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getLength()
    {
        return $this->length;
    }

    // Setters
   
    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function saveAttributes($productId, $dbConnection)
    {
        // Store the results of the getter methods in variables
        $height = $this->getHeight();
        $width = $this->getWidth();
        $length = $this->getLength();
    
        // Prepare and execute the SQL query
        $query = "UPDATE produ SET height = ?, width = ?, length = ? WHERE id = ?";
        $stmt = $dbConnection->prepare($query);
        $stmt->bind_param('iiid', $height, $width, $length, $productId);
        $stmt->execute();
    }


    public function getAdditionalAttributes()
    {
        $dimension = intval($this->getHeight()) . 'x' . intval($this->getWidth()) . 'x' . intval($this->getLength());

        return [
            'Dimension' => $dimension,
        ];
    }


    public static function createFromRow(array $row): self
    {
        return new self(
            $row['id'],
            $row['sku'],
            $row['name'],
            $row['price'],
            $row['product_type'],
            $row['height'] ?? null,
            $row['width'] ?? null,
            $row['length'] ?? null,
        );
    }
}
