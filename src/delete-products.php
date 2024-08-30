<?php
include  '../vendor/autoload.php';
use App\Repositories\ProductRepository;
use App\Database\DatabaseConnection;

// Get database connection
$dbConnection = DatabaseConnection::getConnection();
$productRepository = new ProductRepository($dbConnection);

if (isset($_POST['delete']) && !empty($_POST['products'])) {
    $selectedIds = $_POST['products'];
    foreach ($selectedIds as $id) {
        // Call a method in your repository to delete the product by SKU
        $productRepository->deleteProductById($id);
    }

    // Redirect back to the product list page
    header('Location: /');
    exit();
}
else{
     header('Location: /');
    exit();
}