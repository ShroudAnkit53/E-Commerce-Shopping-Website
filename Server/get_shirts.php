<?php

include 'connection.php'; // Include the database connection file

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='shirts' LIMIT 8"); // Prepare the SQL statement

$stmt->execute(); // Execute the statement
$shirts_products = $stmt->get_result(); // Get the result set from the executed statement

?>