<?php  

include __DIR__ . '/../../vendor/autoload.php';

use App\Repositories\ProductRepository;
use App\Database\DatabaseConnection;

// Get database connection
$dbConnection = DatabaseConnection::getConnection();

// Create repository instance
$productRepository = new ProductRepository($dbConnection);

// Get products and display them
$products = $productRepository->getAllProducts();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="app/css/styles.css"> <!-- Link to your CSS file -->
</head>
<body>