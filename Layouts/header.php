<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShopBag - Online Shopping</title>
  <link rel="icon" type="image/png" href="Assets/img/logo.png">
  <!-- Bootstrap CSS  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <!-- Style Link  -->
  <link rel="stylesheet" href="Assets/css/style.css">
  <!-- <link rel="stylesheet" href="Assets/css/loader.css"> -->
  <!-- Font Awesome  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
          <!-- <a href="#" id="toggle-switch" class="me-3">
            <i class="fa-solid fa-toggle-off"></i>
          </a> -->
          <a href="cart.php"><i class="fa-solid fa-cart-shopping me-3"></i></a>
          <a href="account.php"><i class="fa-solid fa-circle-user"></i></a>
        </div>
      </div>

    </div>
  </nav>

  <!-- <script src="Assets/js/script.js"></script> -->
