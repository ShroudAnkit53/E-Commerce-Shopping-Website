<?php

include 'connection.php'; // Include the database connection file

$stmt = $conn->prepare("SELECT * FROM products LIMIT 4"); // Prepare the SQL statement

$stmt->execute(); // Execute the statement
$featured_products = $stmt->get_result(); // Get the result set from the executed statement

?>