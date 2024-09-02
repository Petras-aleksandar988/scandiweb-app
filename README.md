Live link Published:
https://aleksa-scandiweb.shop/

To test in local environment:

1. Clone the repository
2. Using XAMPP or another method for creating a local MySQL database, make a database named scandiwweb and a table named 'produ' (use .env-example and make own .env file in root directory and fill out with asked info). You can use this SQL statement to inject table:
 CREATE TABLE produ ( id INT(11) NOT NULL AUTO_INCREMENT, sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, price DECIMAL(10,2) NOT NULL, product_type ENUM('dvd', 'book', 'furniture') NOT NULL, size INT(10) DEFAULT NULL, weight INT(10) DEFAULT NULL, height INT(10) DEFAULT NULL, width INT(10) DEFAULT NULL, length INT(10) DEFAULT NULL, PRIMARY KEY (id), INDEX (sku) ) .
3. Start local server with the command php -S localhost:8000 form root directory


