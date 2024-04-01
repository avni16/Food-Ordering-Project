<?php include('partials-front/menu.php')?>
<?php
    // Check whether food id is set or not
    if(isset($_GET['food_id']))
    {
        // Get the food id and details of the selected food
        $food_id = $_GET['food_id'];

        // Get details of selected food
        $sql="SELECT * FROM tbl_food WHERE id=$food_id";

        // Execute query
        $res=mysqli_query($conn,$sql);

        // Count rows
        if(mysqli_num_rows($res) == 1) {
            // We have data
            // Get data from database
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        } else {
            // Food not available
            // Redirect to homepage
            header('location:'.SITEURL);
            exit(); // Stop further execution
        }
    } else {
        // Redirect to homepage
        header('location:' .SITEURL);
        exit(); // Stop further execution
    }

    // Check if the form is submitted
    if(isset($_POST['submit'])) {
        // Get form data
        $food = $_POST['food'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $total = $price * $qty;
        $order_date = date("Y-m-d h:i:sa");
        $status = "Ordered";
        $customer_name = $_POST['full-name'];
        $customer_contact = $_POST['contact'];
        $customer_email = $_POST['email'];
        $customer_address = $_POST['address'];

        // Insert order data into the database
        $sql = "INSERT INTO tbl_order (food, price, qty, total, order_date, status, customer_name, customer_contact, customer_email, customer_address) VALUES ('$food', $price, $qty, $total, '$order_date', '$status', '$customer_name', '$customer_contact', '$customer_email', '$customer_address')";
        $res = mysqli_query($conn, $sql);

        if($res) {
            // Order placed successfully
            header('Location: order-success.php');
            exit();
        } else {
            // Failed to place order
            echo "Failed to place order. Please try again.";
        }
    }
?>
<!-- Navbar Section Ends Here -->

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>
        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>
                <div class="food-menu-img">
                    <?php 
                        // Check whether the image is available or not
                        if($image_name=="")
                        {
                            // Image not available
                            echo "<div class='error'>Image not available.</div>";
                        }
                        else
                        {
                            // Image available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Hawain Pizza" class="img-responsive img-curve">
                            <?php
                        }
                    ?>
                </div>
                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">
                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hidden" name="price" id="base-price" value="<?php echo $price; ?>">
                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" id="quantity" class="input-responsive" value="1" min="1" required>
                    <div class="order-label">Total Price</div>
                    <p id="total-price">$<?php echo $price; ?></p>
                </div>
            </fieldset>
            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>
                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>
                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>
                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>
             
                
                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
        </form>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->
<?php include('partials-front/footer.php')?>
<script>
    document.getElementById('quantity').addEventListener('change', function() {
        var quantity = parseInt(this.value);
        var basePrice = parseFloat(document.getElementById('base-price').value);
        var totalPrice = quantity * basePrice;
        document.getElementById('total-price').innerText = '$' + totalPrice.toFixed(2);
    });
</script>
