<?php include('partials-front/menu.php'); ?>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <!-- Navbar content goes here -->
        </div>
    </section>
    <!-- Navbar Section Ends Here -->

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php
                // Get search keyword
                $search = mysqli_real_escape_string($conn, $_POST['search']);
            ?>
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php
                // SQL query to get foods based on search keyword
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
                // Execute query
                $res = mysqli_query($conn, $sql);
                // Check whether food available or not
                if(mysqli_num_rows($res) > 0) {
                    // Food available
                    while($row = mysqli_fetch_assoc($res)) {
                        // Get details
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
            ?>
            <div class="food-menu-box">
                <div class="food-menu-img">
                    <?php
                        // Check whether image name is available or not
                        if($image_name != "") {
                    ?>
                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Food Image" class="img-responsive img-curve">
                    <?php
                        } else {
                            // Image not available
                            echo "<div class='error'>Image not available.</div>";
                        }
                    ?>
                </div>
                <div class="food-menu-desc">
                    <h4><?php echo $title; ?></h4>
                    <div class="food-price">
                        <h5><?php echo $price; ?></h5>
                    </div>
                    <div class="food-detail">
                        <p><?php echo $description; ?></p><br>
                        <a href="<?php echo SITEURL;?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
                    // Food not available
                    echo "<div class='error'>Food not found.</div>";
                }
            ?>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    <!-- Footer Section Starts Here -->
    <?php include('partials-front/footer.php'); ?>
    <!-- Footer Section Ends Here -->
</body>
