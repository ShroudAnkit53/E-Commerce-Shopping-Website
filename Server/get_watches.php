<?php

include 'connection.php'; // Include the database connection file

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='watches' LIMIT 4"); // Prepare the SQL statement

$stmt->execute(); // Execute the statement
$watches_products = $stmt->get_result(); // Get the result set from the executed statement

?>