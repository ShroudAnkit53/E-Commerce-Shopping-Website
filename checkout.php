<?php
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: index.php?message=please login/register first");
  exit();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// ✅ Check if total amount exists
if (!isset($_SESSION['total_amount'])) {
  header("Location: cart.php");
  exit();
}

$total_amount = $_SESSION['total_amount'];
?>
<?php include('Layouts/header.php'); ?>

<!-- Checkout Form Section -->
<section class="container my-5 py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-12 mt-5 pt-5">
      <h3 class="text-center mb-4">Checkout</h3>

      <!-- Order Summary -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Order Summary</h5>
          <p class="card-text">Total Amount to Pay: <strong>₹ <?php echo number_format($total_amount, 2); ?></strong></p>
        </div>
      </div>

      <form action="Server/place_order.php" method="POST">
        <p class="text-center" style="color:red;">
          <?php if (isset($_GET['message'])) {
            echo $_GET['message']; ?>
            <br><a href="index.php" class="btn btn-primary mt-2">Login</a>
          <?php } ?>
        </p>

        <div class="mb-3">
          <label for="checkout-name" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="checkout-name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="checkout-email" class="form-label">Email</label>
          <input type="email" class="form-control" id="checkout-email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="checkout-phone" class="form-label">Phone</label>
          <input type="text" class="form-control" id="checkout-phone" name="phone" required>
        </div>
        <div class="mb-3">
          <label for="checkout-city" class="form-label">City</label>
          <input type="text" class="form-control" id="checkout-city" name="city" required>
        </div>
        <div class="mb-3">
          <label for="checkout-address" class="form-label">Address</label>
          <textarea class="form-control" id="checkout-address" name="address" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100" name="checkout" style="background-color: rgb(236, 126, 9);color:black;border:none;">Place Order</button>
      </form>
    </div>
  </div>
</section>

<?php include('Layouts/footer.php'); ?>
