<?php
session_start();

if (!isset($_SESSION['total_amount'])) {
  // Redirect if no amount set
  header("Location: cart.php");
  exit();
}

$total_amount = $_SESSION['total_amount'];
$order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : null;

if ($total_amount <= 0) {
    // Redirect or show error
    header("Location: cart.php?error=invalid_amount");
    exit();
}

?>

<?php include('Layouts/header.php'); ?>

<!-- Checkout Form Section -->
<section class="container my-5 py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-12 mt-5 pt-5">
      <h3 class="text-center mb-4">Payment</h3>
      <!-- Order Summary -->
      <div class="card mb-4">
        <div class="card-body">
          <p><?php if (isset($_GET['order_status'])) {
                echo $_GET['order_status'];
              } ?></p>
          <h5 class="card-title">Order Summary</h5>
          <p class="card-text">Total Amount to Pay: <strong>₹ <?php echo number_format($total_amount, 2); ?></strong></p>
        </div>
      </div>
      <div class="text-center">
        <?php if ($total_amount > 0): ?>
          <a href="#" class="btn btn-primary">Proceed to Payment</a> <!-- Update with real payment gateway later -->
        <?php else: ?>
          <p class="text-danger">Add items to your cart to proceed with payment.</p>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php include('Layouts/footer.php'); ?>