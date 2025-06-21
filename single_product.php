<?php

include 'Server/connection.php'; // Include the database connection file

if(isset($_GET['product_id'])) {
  $product_id = $_GET['product_id']; // Get the product_id from the URL
  $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?"); // Prepare the SQL statement
  $stmt->bind_param("i", $product_id); // Bind the product_id parameter to the SQL statement

  $stmt->execute(); // Execute the statement
  $product = $stmt->get_result(); // Get the result set from the executed statement
} else {
    // Redirect to the home page or show an error message
    header("Location: index.php");
    exit();
}


?>

<?php include('Layouts/header.php'); ?>

    <!-- Single Product Section  -->
    <section class="container single-product my-5 pt-5">
      <div class="row mt-5">
        <?php while($row = $product->fetch_assoc()): ?>
        <div class="col-lg-5 col-md-6 col-sm-12">
          <img
            src="Assets/img/<?php echo $row['product_image']; ?>"
            alt=""
            class="img-fluid w-100 pb-1"
            id="mainImg"
          />
          <div class="small-img-group">
            <div class="small-img-col">
              <img
                src="Assets/img/<?php echo $row['product_image']; ?>"
                alt=""
                class="small-img"/>
            </div>
            <div class="small-img-col">
              <img
                src="Assets/img/<?php echo $row['product_image2']; ?>"
                alt=""
                class="small-img"
              />
            </div>
            <div class="small-img-col">
              <img
                src="Assets/img/<?php echo $row['product_image3']; ?>"
                alt=""
                class="small-img"
              />
            </div>
            <div class="small-img-col">
              <img
                src="Assets/img/<?php echo $row['product_image4']; ?>"
                alt=""
                class="small-img"
              />
            </div>
          </div>
        </div>
        
        <div class="col-lg-6 col-md-12 col-sm-12">
            <h6 id="product-title"><?php echo $row['product_name']; ?></h6>
            <h3 class="py-4" id="product-category"><?php echo $row['product_category']; ?></h3>
            <h2 id="product-price"><?php echo $row['product_price']; ?></h2>
            <!-- input and button -->
            <form method="post" action="cart.php">
              <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
              <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
              <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
              <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
              <input type="number" name="product_quantity" id="" value="1">
              <button class="buy-btn" name="add_to_cart" type="submit">Add to Cart</button>  
            </form>
            <h4 class="mt-5 mb-5">Product Details</h4>
            <span id="product-description">
            <?php echo $row['product_description']; ?>
            </span>   
        </div>
        <?php endwhile; ?>
      </div>
    </section>

    <!-- Related Products Section -->
    <section id="related-products" class="my-5 pb-5">
      <div class="container text-center mt-5 py-5">
        <h3><span>Related</span> Products</h3>
        <hr />
        <p>Here you can check out our featured products</p>
      </div>
      <div class="row mx-auto container-fluid">
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img
            src="Assets/img/stylish-shoes.jpg"
            alt=""
            class="img-fluid mb-3"
          />
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name">Nike Shoes</h5>
          <h4 class="p-price">₹845.0</h4>
          <button class="buy-btn">Buy Now</button>
          <button class="buy-btn" id="btn2">Add to Cart</button>
        </div>
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img src="Assets/img/studs.jpg" alt="" class="img-fluid mb-3" />
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <!-- <i class="fas fa-star"></i> -->
          </div>
          <h5 class="p-name">Nivea Football Shoes</h5>
          <h4 class="p-price">₹699.0</h4>
          <button class="buy-btn">Buy Now</button>
          <button class="buy-btn" id="btn2">Add to Cart</button>
        </div>
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img src="Assets/img/shoes-1.jpg" alt="" class="img-fluid mb-3" />
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name">Bata Shoes</h5>
          <h4 class="p-price">₹1499.0</h4>
          <button class="buy-btn">Buy Now</button>
          <button class="buy-btn" id="btn2">Add to Cart</button>
        </div>
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img src="Assets/img/studs-2.jpg" alt="" class="img-fluid mb-3" />
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <!-- <i class="fas fa-star"></i> -->
          </div>
          <h5 class="p-name">Adidas Predator Studs</h5>
          <h4 class="p-price">₹3099.0</h4>
          <button class="buy-btn">Buy Now</button>
          <button class="buy-btn" id="btn2">Add to Cart</button>
        </div>
      </div>
    </section>

    
    <script>
        var mainImg = document.getElementById("mainImg");
        var smallImg = document.getElementsByClassName("small-img");
        
        var productTitle = document.getElementById("product-title");
        var productCategory = document.getElementById("product-category");
        var productPrice = document.getElementById("product-price");
        var productDescription = document.getElementById("product-description");
        
        for (let i = 0; i < smallImg.length; i++) {
            smallImg[i].onclick = function() {
                mainImg.src = smallImg[i].src;
                productTitle.innerText = smallImg[i].getAttribute("data-title");
                productCategory.innerText = smallImg[i].getAttribute("data-category");
                productPrice.innerText = smallImg[i].getAttribute("data-price");
                productDescription.innerText = smallImg[i].getAttribute("data-description");
            }
        }
        
    </script>

<?php include('Layouts/footer.php'); ?>


