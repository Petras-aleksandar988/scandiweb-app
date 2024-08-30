<?php

namespace App\Models;

class Book extends Product
{
    private $weight;

    protected function initializeAdditionalAttributes(array $args)
    {
        $this->setWeight($args[5] ?? null);
    }

    // Getter
    public function getWeight()
    {
        return $this->weight;
    }

    // Setter
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

 public function saveAttributes($productId, $dbConnection)
{
    $weight = $this->getWeight();

    $query = "UPDATE produ SET weight = ? WHERE id = ?";
    $stmt = $dbConnection->prepare($query);
    $stmt->bind_param('di', $weight, $productId);
    $stmt->execute();
}


    public function getAdditionalAttributes()
    {
        return ['weight' => intval($this->getWeight()) . ' KG'];
    }

    public static function createFromRow(array $row): self
    {
        return new self(
            $row['id'],
            $row['sku'],
            $row['name'],
            $row['price'],
            $row['product_type'],
            $row['weight']
        );
    }
}
