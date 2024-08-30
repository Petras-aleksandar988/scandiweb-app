<?php

include  '../vendor/autoload.php';

use App\Models\Dvd;
use App\Models\Book;
use App\Models\Furniture;
use App\Models\Product;
use App\Database\DatabaseConnection;
use App\Repositories\ProductRepository;

try {
    // Get database connection
    $dbConnection = DatabaseConnection::getConnection();

    // Create repository instance
    $productRepository = new ProductRepository($dbConnection);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');

        $filteredData = array_filter($_POST, function($value) {
            return $value !== ''; 
        });
     

        $data = [
            'sku' => $filteredData['sku'] ?? '',
            'name' => $filteredData['name'] ?? '',
            'price' => $filteredData['price'] ?? '',
            'type' => $filteredData['type'] ?? ''
        ];

        $dynamicKeys = ['size', 'weight', 'height', 'width', 'length'];
foreach ($dynamicKeys as $key) {
    if (isset($filteredData[$key])) {
        $data[$key] = $filteredData[$key];
    }
}



        // Check if SKU already exists
        $query = "SELECT COUNT(*) AS count FROM produ WHERE sku = ?";
        $stmt = $dbConnection->prepare($query);
        $stmt->bind_param('s', $data['sku']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {

            echo json_encode(['status' => 'error','message' => 'SKU already exists. Please use a different SKU.']);
            exit;
        }

        echo json_encode(['status'=>'success']);
        $productRepository->saveProduct($data);
        
        exit;
    }

} catch (Exception $e) {
    // Catch any exceptions and return an error response
    echo json_encode(['status' => 'error','message' => 'An error occurred: ' . $e->getMessage()
    ]);
    exit;
}
