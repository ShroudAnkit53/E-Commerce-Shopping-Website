<?php 
include 'Server/connection.php';



// Default values
$category = '';
$price = 10000;
$whereClause = '1'; // default: show all

// If search form is submitted
if (isset($_POST['search'])) {
    $category = $_POST['category'] ?? '';
    $price = $_POST['price'] ?? 10000;

    // Build dynamic WHERE clause
    $whereClause = "price <= $price";
    if (!empty($category)) {
        $category = $conn->real_escape_string($category);
        $whereClause .= " AND category = '$category'";
    }

    // Save search params in session to persist on pagination
    session_start();
    $_SESSION['category'] = $category;
    $_SESSION['price'] = $price;
} elseif (isset($_GET['page'])) {
    // On pagination, keep previous filter state from session
    session_start();
    if (isset($_SESSION['price'])) $price = $_SESSION['price'];
    if (isset($_SESSION['category'])) $category = $_SESSION['category'];

    $whereClause = "price <= $price";
    if (!empty($category)) {
        $category = $conn->real_escape_string($category);
        $whereClause .= " AND category = '$category'";
    }
} else {
    // Clear filter session on direct visit
    session_start();
    session_unset();
    session_destroy();
}
?>

<?php include('Layouts/header.php'); ?>

<section class="shop-section my-5 py-5">
  <div class="container mt-5 py-5">
    <div class="row">

      <!-- Filter -->
      <div class="col-lg-3">
        <form action="shop.php" method="POST">
          <h5><span style="color: rgb(236,126,9);">Search</span> Products</h5>
          <hr />
          <div class="mb-4">
            <p><strong>Category</strong></p>
            <?php
            $categories = ['shoes', 'shirts', 'jeans', 'pants', 'watches', 'bags'];
            foreach ($categories as $cat) {
                $checked = ($category === $cat) ? 'checked' : '';
                echo "<div class='form-check'>
                        <input type='radio' name='category' id='cat_$cat' value='$cat' class='form-check-input' $checked>
                        <label for='cat_$cat' class='form-check-label'>" . ucfirst($cat) . "</label>
                      </div>";
            }
            ?>
          </div>
          <div class="mb-4">
            <p><strong>Price (up to ₹<?= htmlspecialchars($price) ?>)</strong></p>
            <input type="range" name="price" class="form-range" min="1" max="10000" value="<?= htmlspecialchars($price) ?>" />
          </div>
          <input type="submit" name="search" value="Search" class="btn btn-primary w-100" />
        </form>
      </div>

      <!-- Products -->
      <div class="col-lg-9">
        <h3 style="font-weight: 500;"><span>Our</span> Shop</h3>
        <hr />
        <p>Check out our featured products</p>
        <div class="row">
          <?php
          // Pagination Setup
          $limit = 9;
          $page = $_GET['page'] ?? 1;
          $offset = ($page - 1) * $limit;

          // Count total matching products
          $count_sql = "SELECT COUNT(*) AS total FROM shop_items WHERE $whereClause";
          $count_result = $conn->query($count_sql);
          $total = $count_result->fetch_assoc()['total'];
          $total_pages = ceil($total / $limit);

          // Fetch products with filters & pagination
          $sql = "SELECT * FROM shop_items WHERE $whereClause LIMIT $limit OFFSET $offset";
          $result = $conn->query($sql);

          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  ?>
                  <div onclick="window.location.href='single_product.php?id=<?= $row['id'] ?>';" class="product text-center col-lg-4 col-md-6 col-sm-12 mb-4">
                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="img-fluid mb-3" />
                    <div class="star">
                      <?php for ($i = 0; $i < ($row['rating'] ?? 4); $i++) echo '<i class="fas fa-star"></i>'; ?>
                    </div>
                    <h5 class="p-name"><?= htmlspecialchars($row['name']) ?></h5>
                    <h4 class="p-price">₹<?= htmlspecialchars($row['price']) ?></h4>
                    <button class="buy-btn">Buy Now</button>
                  </div>
              <?php
              }
          } else {
              echo "<p class='text-center'>No products found.</p>";
          }
          ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <nav class="mt-4">
          <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
            </li>
          </ul>
        </nav>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php include('Layouts/footer.php'); ?>
