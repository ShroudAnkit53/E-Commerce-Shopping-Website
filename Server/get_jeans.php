<?php

include 'connection.php'; // Include the database connection file

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='jeans' OR product_category='pants' LIMIT 4"); // Prepare the SQL statement

$stmt->execute(); // Execute the statement
$jeans_products = $stmt->get_result(); // Get the result set from the executed statement

?>