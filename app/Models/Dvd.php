<?php

namespace App\Models;

class Dvd extends Product
{
    private $size;

    protected function initializeAdditionalAttributes(array $args)
    {
        $this->setSize($args[5] ?? null);
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function saveAttributes($productId, $dbConnection)
    {
        $size = $this->getSize();
    
        $query = "UPDATE produ SET size = ? WHERE id = ?";
        $stmt = $dbConnection->prepare($query);
        $stmt->bind_param('ii', $size, $productId);
        $stmt->execute();
    }
    

    public function getAdditionalAttributes()
    {
        return ['size' => intval($this->getSize()) . ' MB'];
    }
    public static function createFromRow(array $row): self
    {
        return new self(
            $row['id'],
            $row['sku'],
            $row['name'],
            $row['price'],
            $row['product_type'],
            $row['size']
        );
    }
}
