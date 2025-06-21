<?php 
session_start();
include 'connection.php';

// ✅ Ensure user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('location: ../checkout.php?message=please login/register first');
    exit();
}

// ✅ Proceed if checkout form is submitted
if (isset($_POST['checkout'])) {

    // Get user input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total_amount'];
    $order_status = "not paid";
    $user_id = $_SESSION['user_id'];
    $order_date = date("Y-m-d H:i:s");

    // Insert order into orders table
    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("dsissss", $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);

    if (!$stmt->execute()) {
        // Optional: handle order insert failure
        header('location: ../checkout.php?message=Error placing order');
        exit();
    }

    // Get inserted order ID
    $order_id = $stmt->insert_id;

    // Loop through cart and insert items into order_items
    foreach ($_SESSION['cart'] as $key => $product) {
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];
        $product_image = $product['product_image'];

        $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("iissiiis", $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);
        $stmt1->execute();
    }

    // Optionally clear the cart after placing order
    // unset($_SESSION['cart']);

    // Redirect to payment page
    header('location: ../payment.php?order_status=order placed successfully');
    exit();
}
?>
