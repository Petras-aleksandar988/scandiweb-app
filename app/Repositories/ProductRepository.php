<?php 

namespace App\Repositories;
use App\Models\Product;

class ProductRepository
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM produ ORDER BY id DESC";
        $result = $this->dbConnection->query($query);

        $products = [];

        while ($row = $result->fetch_assoc()) {
            $product = Product::createProductFromRow($row);
            $products[] = $product;
        }

        return $products;
    }

    public function saveProduct(array $data)
    {
        // Determine the type and create the corresponding product class
        $typeForClass = strtolower($data['type']);
        $class = 'App\\Models\\' . ucfirst($typeForClass);
    
        if (!class_exists($class)) {
            throw new \Exception("Invalid product type.");
        }
        $args = array_values(array_slice($data, 4));
        // Create the product object dynamically
        $product = new $class(
            null,
            $data['sku'],
            $data['name'],
            $data['price'],
            $data['type'],
            ...$args,
        );
        // Extract values from the product object into variables
        $sku = $product->getSku();
        $name = $product->getName();
        $price = $product->getPrice();
        $type = $product->getType();
    
        // Insert into the products table (only static attributes)
        $query = "INSERT INTO produ (sku, name, price, product_type) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bind_param('ssss',  $sku,  $name,  $price, $type);
        $stmt->execute();
    
        // Get the inserted product ID
        $productId = $this->dbConnection->insert_id;
    
        // Delegate the saving of type-specific attributes to the product object
        $product->saveAttributes($productId, $this->dbConnection);
    }

    public function deleteProductById($id)
    {
        $query = "DELETE FROM produ WHERE id = ?";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

      
    }

  

}