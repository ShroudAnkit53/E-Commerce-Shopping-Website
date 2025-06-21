<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>


<?php include('Layouts/header.php'); ?>
      
    <!-- Home  -->
    <section id="home">
        <div class="container">
            <h5>NEW ARRIVALS</h5>
            <h1><span>Best Prices</span> this Season</h1>
            <p>Discover the latest trends in fashion and accessories at unbeatable prices. Shop now and elevate your style!</p>
            <button>Shop Now</button>
        </div>
    </section>

    <!-- Brands  -->
    <section id="brand" class="container">
      <h2 class="section-heading" style="margin-top: 35px;"><span>Best Brands</span> We Sell</h2>
      <div class="row">
        <img src="Assets/img/brand1.png" alt="Brand 1" class="image-fluid col-lg-3 col-md-6 col-sm-12">
        <img src="Assets/img/brand2.png" alt="Brand 2" class="image-fluid col-lg-3 col-md-6 col-sm-12">
        <img src="Assets/img/brand3.png" alt="Brand 3" class="image-fluid col-lg-3 col-md-6 col-sm-12">
        <img src="Assets/img/brand4.png" alt="Brand 4" class="image-fluid col-lg-3 col-md-6 col-sm-12">
      </div>
    </section>

    <!-- New  -->
    <section id="new" class="w-100">
      <h2 class="section-heading"><span>Best</span> Values</h2>
      <div class="row p-0 m-0">
        <!-- One  -->
        <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
          <img src="Assets/img/shoes.jpg" alt="Img1" class="img-fluid">
          <div class="details">
            <h2>Extremely Awesome Shoes</h2>
            <button class="text-uppercase">Shop Now</button>
          </div>
        </div>
        <!-- Two  -->
        <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
          <img src="Assets/img/jacket.jpg" alt="Img1" class="img-fluid">
          <div class="details">
            <h2>Awesome Jacket</h2>
            <button class="text-uppercase">Shop Now</button>
          </div>
        </div>
        <!-- Three  -->
        <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
          <img src="Assets/img/watches.jpg" alt="Img1" class="img-fluid">
          <div class="details">
            <h2>50% OFF Watches</h2>
            <button class="text-uppercase">Shop Now</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured  -->
    <section id="featured" class="my-5 pb-5">
      <div class="container text-center mt-5 py-5">
        <h3><span>Our</span> Featured</h3>
        <hr>
        <p>Here you can check out our featured products</p>
      </div>
      <div class="row mx-auto container-fluid">

        <?php include('Server/get_featured_products.php'); ?>

        <?php while($row = $featured_products->fetch_assoc()): ?>

        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img src="Assets/img/<?php echo $row['product_image'];?>" alt="" class="img-fluid mb-3">
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name"><?php echo $row['product_name'];?></h5>
          <h4 class="p-price"><?php echo $row['product_price'];?></h4>
          <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a></a>
        </div>

        <?php endwhile; ?>
      </div>
    </section>

    <!-- Banner  -->
    <section id="banner" class="my-5 py-5">
      <div class="container">
        <h4>MID SEASON'S SALE</h4>
        <h1>Autumn Collection <br> UP TO 30% OFF</h1>
        <button class="text-uppercase">shop now</button>
      </div>
    </section>

    <!-- Clothes -->
    <section id="featured" class="my-5 pb-5">
      <div class="container text-center mt-5 py-5">
        <h3><span>Shirts</span> & Sports Jerseys</h3>
        <hr>
        <p>Here you can check out our amazing Shirts, T-Shirts and Jerseys of your favourite team</p>
      </div>
      <div class="row mx-auto container-fluid">

        <?php include('Server/get_shirts.php'); ?>

        <?php while($row = $shirts_products->fetch_assoc()): ?>

        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img src="Assets/img/<?php echo $row['product_image'];?>" alt="" class="img-fluid mb-3">
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name"><?php echo $row['product_name'];?></h5>
          <h4 class="p-price"><?php echo $row['product_price'];?></h4>
          <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a></a>
        </div>

        <?php endwhile; ?>
      </div>
      <div class="container text-center mt-2 py-2">
        <p>For More Brands and Products <a href="">Click More</a></p>
      </div>
    </section>  

    <!-- Shoes  -->
    <section id="featured" class="my-5 pb-5">
      <div class="container text-center mt-3 py-3">
        <h3><span>Best</span> Shoes and Studs</h3>
        <hr>
        <p>Here you can check out our amazing shoes and studs</p>
      </div>
      <div class="row mx-auto container-fluid">

        <?php include('Server/get_shoes.php'); ?>

        <?php while($row = $shoes_products->fetch_assoc()): ?>
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img src="Assets/img/<?php echo $row['product_image'];?>" alt="" class="img-fluid mb-3">
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name"><?php echo $row['product_name'];?></h5>
          <h4 class="p-price"><?php echo $row['product_price'];?></h4>
          <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
        </div>

        <?php endwhile; ?>
      </div>
      <div class="container text-center mt-2 py-2">
        <p>For More Brands and Products <a href="">Click More</a></p>
      </div>
    </section>

    <!-- Watches -->
    <section id="featured" class="my-5 pb-5">
      <div class="container text-center mt-3 py-3">
        <h3><span>Best</span> Watches</h3>
        <hr>
        <p>Here you can check out our amazing watches</p>
      </div>
      <div class="row mx-auto container-fluid">

        <?php include('Server/get_watches.php'); ?>

        <?php while($row = $watches_products->fetch_assoc()): ?>
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img src="Assets/img/<?php echo $row['product_image'];?>" alt="" class="img-fluid mb-3">
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name"> <?php echo $row['product_name'];?></h5>
          <h4 class="p-price"><?php echo $row['product_price'];?></h4>
          <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
        </div>
        <?php endwhile; ?>
      </div>
      <div class="container text-center mt-2 py-2">
        <p>For More Brands and Products <a href="">Click More</a></p>
      </div>
    </section>

    <!-- Jeans and Pants  -->
    <section id="featured" class="my-5 pb-5">
      <div class="container text-center mt-3 py-3">
        <h3><span>Jeans</span> and Pants</h3>
        <hr>
        <p>Here you can check out our amazing jeans and pants</p>
      </div>
      <div class="row mx-auto container-fluid">

        <?php include('Server/get_jeans.php'); ?>

        <?php while($row = $jeans_products->fetch_assoc()): ?>
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img src="Assets/img/<?php echo $row['product_image'];?>" alt="" class="img-fluid mb-3">
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name"><?php echo $row['product_name'];?></h5>
          <h4 class="p-price"><?php echo $row['product_price'];?></h4>
          <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
        </div>
        <?php endwhile; ?>
      </div>
      <div class="container text-center mt-2 py-2">
        <p>For More Brands and Products <a href="">Click More</a></p>
      </div>
    </section>

<?php include('Layouts/footer.php'); ?>
    