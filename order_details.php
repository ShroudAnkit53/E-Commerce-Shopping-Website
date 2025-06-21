<?php 
session_start(); // Start session to use $_SESSION

include('Server/connection.php');

if(isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_details_result = $stmt->get_result();

    $total_amount = 0;
    $order_items = [];

    while($row = $order_details_result->fetch_assoc()) {
        $total_amount += $row['product_price'] * $row['product_quantity'];
        $order_items[] = $row;
    }

    // Save total and order ID to session
    $_SESSION['total_amount'] = $total_amount;
    $_SESSION['order_id'] = $order_id;

} else {
    header('location:account.php');
    exit();
}
?>

<?php include('Layouts/header.php'); ?>

<!-- Order Section -->
<section class="orders container my-5 py-3">
  <div class="container mt-5">
    <h2 class="font-weight-bolde text-center"><span>Order</span> Details</h2>
    <hr class="mx-auto" />
  </div>

  <table class="mt-5 pt-5">
    <tr>
      <th>Product</th>
      <th>Price</th>
      <th>Quantity</th>
    </tr>

    <?php foreach($order_items as $row): ?>
      <tr>
        <td>
          <div class="product-info">
            <img src="Assets/img/<?php echo $row['product_image'];?>" alt="" />
            <div>
              <p class="mt-3"><?php echo $row['product_name'];?></p>
            </div>
          </div>
        </td>

        <td>
          <span>₹ <?php echo $row['product_price'];?></span>
        </td>

        <td>
          <span><?php echo $row['product_quantity'];?></span>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

  <?php if($order_status == "not paid"){ ?>
    <form style="float: right;margin-top:15px;" action="payment.php" method="GET">
      <input type="submit" class="btn btn-primary" value="Pay Now">
    </form>
  <?php } ?>
</section>

<?php include('Layouts/footer.php'); ?>
