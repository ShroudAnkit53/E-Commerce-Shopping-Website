<?php
include 'Server/connection.php';
session_start();

// Clear corrupted cart data (optional for testing only)
// unset($_SESSION['cart']);

if (isset($_POST['add_to_cart'])) {
  if (isset($_SESSION['cart'])) {
    $product_array_ids = array_column($_SESSION['cart'], 'product_id');
    if (!in_array($_POST['product_id'], $product_array_ids)) {
      $product_array = array(
        'product_id' => $_POST['product_id'],
        'product_name' => $_POST['product_name'],
        'product_price' => $_POST['product_price'],
        'product_image' => $_POST['product_image'],
        'product_quantity' => $_POST['product_quantity']
      );
      $_SESSION['cart'][] = $product_array;
    } else {
      echo "<script>alert('Product already added to cart')</script>";
    }
  } else {
    $product_array = array(
      'product_id' => $_POST['product_id'],
      'product_name' => $_POST['product_name'],
      'product_price' => $_POST['product_price'],
      'product_image' => $_POST['product_image'],
      'product_quantity' => $_POST['product_quantity']
    );
    $_SESSION['cart'][] = $product_array;
  }
} else if (isset($_POST['remove_product'])) {
  foreach ($_SESSION['cart'] as $key => $value) {
    if ($value['product_id'] == $_POST['product_id']) {
      unset($_SESSION['cart'][$key]);
      echo "<script>alert('Product removed from cart')</script>";
      break;
    }
  }
} else if (isset($_POST['edit_quantity'])) {
  foreach ($_SESSION['cart'] as &$item) {
    if ($item['product_id'] == $_POST['product_id']) {
      $item['product_quantity'] = $_POST['product_quantity'];
      break;
    }
  }
} else if (!isset($_POST['add_to_cart']) && !isset($_POST['remove_product']) && !isset($_POST['edit_quantity'])) {
  // header("Location: index.php");
}

function calculateTotalAmount()
{
  $totalAmount = 0;

  // Loop through each item in the cart and calculate the total
  if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $item) {
      $totalAmount += $item['product_price'] * $item['product_quantity'];
    }
  }

  return $totalAmount;
}

$total = calculateTotalAmount();
$shipping = ($total >= 2000) ? 50 : (($total >= 1000) ? 25 : 0);
$grand_total = $total + $shipping;

// Store total in session for checkout
$_SESSION['total_amount'] = $grand_total;
?>

<?php include('Layouts/header.php'); ?>

  <!-- Cart Section -->
  <section class="cart container my-5 py-5">
    <div class="container mt-5">
      <h2 class="font-weight-bold"><span>Your</span> Cart</h2>
      <hr>
    </div>

    <table class="mt-5 pt-5">
      <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>SubTotal</th>
      </tr>

      <?php
      $total = 0;
      if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
          if (!isset($value['product_id'], $value['product_name'], $value['product_price'], $value['product_image'], $value['product_quantity'])) {
            continue;
          }

          $product_name = $value['product_name'] ?? 'Unnamed';
          $product_price = (float)($value['product_price'] ?? 0);
          $product_quantity = (int)($value['product_quantity'] ?? 1);
          $product_image = $value['product_image'] ?? 'default.jpg';
          $product_id = $value['product_id'];

          $subtotal = $product_price * $product_quantity;
          $total += $subtotal;
      ?>
          <tr>
            <td>
              <div class="product-info">
                <img src="Assets/img/<?php echo $product_image; ?>" alt="">
                <div>
                  <p><?php echo $product_name; ?></p>
                  <small><span>₹</span><?php echo $product_price; ?></small>
                  <br>
                  <form method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <input type="submit" name="remove_product" class="remove-btn" value="Remove" style="width: 100;">
                  </form>
                </div>
              </div>
            </td>
            <td>
              <form method="POST" action="cart.php">
                <input type="number" name="product_quantity" value="<?php echo $product_quantity; ?>" min="1" required>
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input type="submit" name="edit_quantity" class="edit-btn" value="Edit" style="border: none; background-color: white;">
              </form>
            </td>
            <td><span>₹</span><span class="product-price"><?php echo $subtotal; ?></span></td>
          </tr>
      <?php
        }
      } else {
        echo "<tr><td colspan='3'>Your cart is empty.</td></tr>";
      }
      ?>
    </table>

    <div class="cart-total">
      <table>
        <tr>
          <td>SubTotal</td>
          <td>₹ <?php echo $total; ?></td>
        </tr>
        <tr>
          <td>Shipping</td>
          <td>₹ <?php echo $shipping; ?></td>
        </tr>
        <tr>
          <td>Total</td>
          <td>₹ <?php echo $grand_total; ?></td>
        </tr>
      </table>
    </div>
    <div class="checkout-container">
      <button class="btn checkout-btn" id="checkoutBtn">Checkout</button>
    </div>

  </section>


  <script>
    document.getElementById("checkoutBtn").addEventListener("click", function() {
      var form = document.createElement("form");
      form.method = "POST";
      form.action = "checkout.php";
      document.body.appendChild(form);
      form.submit();
    });
  </script>

<?php include('Layouts/footer.php'); ?>