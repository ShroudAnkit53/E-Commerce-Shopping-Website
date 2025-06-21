<?php
session_start();
include('Server/connection.php'); // Make sure this file connects to your DB

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT user_name, user_email, user_password FROM users WHERE user_id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_query->store_result();
$user_query->bind_result($user_name, $user_email, $stored_password_hash);
$user_query->fetch();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $old_password = $_POST['oldPassword'];
  $new_password = $_POST['newPassword'];
  $confirm_password = $_POST['confirmPassword'];

  // Check old password
  if (!password_verify($old_password, $stored_password_hash)) {
    $message = "❌ Incorrect old password!";
  } elseif ($new_password !== $confirm_password) {
    $message = "❌ New passwords do not match!";
  } else {
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $update_query = $conn->prepare("UPDATE users SET user_password = ? WHERE user_id = ?");
    $update_query->bind_param("si", $new_hashed_password, $user_id);

    if ($update_query->execute()) {
      $message = "✅ Password changed successfully!";
    } else {
      $message = "❌ Failed to update password. Please try again.";
    }
  }
}

//get orders
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();

  $orders = $stmt->get_result();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShopBag - Online Shopping</title>
  <link rel="icon" type="image/png" href="Assets/img/logo.png" />
  <!-- Bootstrap CSS  -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
    crossorigin="anonymous" />
  <!-- Style Link  -->
  <link rel="stylesheet" href="Assets/css/style.css" />
  <!-- Font Awesome  -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <style>
    .orders th,
    .orders td {
      text-align: right;
      padding: 12px 15px;
      border: 1px solid #ddd;
    }

    .orders th {
      background-color: rgb(236, 126, 9);
      color: black;
    }

    .orders tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .orders tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>

<body>
  <!-- Navbar  -->
  <nav class="navbar navbar-expand-lg navbar-light py-3 fixed-top" style="background-color: rgb(197, 191, 191);">
    <div class="container d-flex justify-content-between align-items-center">
      <!-- Logo -->
      <a class="navbar-brand" href="#">
        <img src="Assets/img/logo.png" alt="Logo" height="40">
      </a>

      <!-- Toggler for Mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Nav Links + Icons -->
      <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" href="main.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shop.php">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact Us</a>
          </li>
        </ul>

        <!-- 🔁 Move this here -->
        <div class="nav-icons d-flex align-items-center">
          <a href="cart.php"><i class="fa-solid fa-cart-shopping me-3"></i></a>
          <a href="account.php"><i class="fa-solid fa-circle-user"></i></a>
        </div>
      </div>

    </div>
  </nav>

  <!-- Account Section  -->
  <section class="my-5 py-5">
    <div class="row container mx-auto">
      <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
        <h3 class="font-weight-bold">Account Info</h3>
        <hr class="mx-auto" />
        <div class="account-info">
          <p>Name: <span><?php echo $user_name; ?></span></p>
          <p>Email: <span><?php echo $user_email; ?></span></p>
          <p><a href="" id="order-btn">Your Orders</a></p>
          <p><a href="logout.php" id="logout-btn">LogOut</a></p>
        </div>
      </div>

      <div class="col-lg-6 col-md-12 col-sm-12">
        <form action="" method="POST" id="account-form">
          <h3>Change Password</h3>
          <hr class="mx-auto" />
          <?php if (!empty($message)) {
            echo "<p style='color:red;'>$message</p>";
          } ?>
          <div class="form-group">
            <label for="">Old Password</label>
            <input
              type="password"
              name="oldPassword"
              class="form-control"
              placeholder="Enter Old Password"
              required />
          </div>
          <div class="form-group">
            <label for="">New Password</label>
            <input
              type="password"
              name="newPassword"
              class="form-control"
              placeholder="Enter New Password"
              required />
          </div>
          <div class="form-group">
            <label for="">Confirm Password</label>
            <input
              type="password"
              name="confirmPassword"
              class="form-control"
              placeholder="Confirm New Password"
              required />
          </div>
          <div class="form-group">
            <input
              type="submit"
              value="Change Password"
              class="btn"
              id="change-pass-btn" />
          </div>
        </form>
      </div>

    </div>
  </section>

  <!-- Order Section  -->
  <section class="orders container my-5 py-3">
    <div class="container mt-2">
      <h2 class="font-weight-bolde text-center"><span>Your</span> Cart</h2>
      <hr class="mx-auto" />
    </div>

    <table class="mt-5 pt-5">
      <tr>
        <th>Order ID</th>
        <th>Order Cost</th>
        <th>Order Status</th>
        <th>Order Date</th>
        <th>Order Details</th>
      </tr>

      <?php while ($row = $orders->fetch_assoc()): ?>

        <tr>
          <td>
            <!-- <div class="product-info">
                <img src="Assets/img/studs-1.jpg" alt="" />
                <div>
                  <p class="mt-3"><?php echo $row['order_id']; ?></p>
                </div>
              </div> -->
            <span><?php echo $row['order_id']; ?></span>
          </td>

          <td>
            <span><?php echo $row['order_cost']; ?></span>
          </td>

          <td>
            <span><?php echo $row['order_status']; ?></span>
          </td>

          <td>
            <span><?php echo $row['order_date']; ?></span>
          </td>

          <td>
            <form method="POST" action="order_details.php">
              <input type="hidden" name="order_status" value="<?php echo $row['order_status']; ?>" />
              <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>" />
              <input type="submit" name="order_details_btn" class="btn order-details-btn" value="Details" />
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </section>

<?php include('Layouts/footer.php'); ?>