<?php
    include_once "php/db-con.php";

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ERKY Apple Products</title>

    <!-- Website Icon -->
    <link rel="icon" href="img/logo.png" type="image/png" sizes="20x20">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/main.css">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

    <!-- Navbar -->
    <section id="navbar-section">
        <div class="navbar-container">
            <div class="navbar-nb">
                <div class="logo">
                    <a href=""><img src="img/logo.png" alt=""></a>
                </div>
                <nav>
                    <ul id="menu-items">
                        <li><a class="nav-items" href="">Home</a></li>
                        <li><a class="nav-items" href="#products">Product</a></li>
                        <li><a class="nav-items" href="#about-section">About ERKY</a></li>
                        <li><a class="nav-items" href="#service-section">Services</a></li>
                        <li><a class="nav-items" href="#contact-section">Contact</a></li>
                    </ul>
                </nav>
                <div class="dropdown">
                <?php
                    $select_user = mysqli_query($conn, "SELECT * FROM `customer` WHERE CustomerID = '$user_id'") or die('query failed');
                    if(mysqli_num_rows($select_user) > 0){
                        $fetch_user = mysqli_fetch_assoc($select_user);
                    }
                ?>
                <button class="nav-icon dropbtn fa-solid fa-circle-user" onclick="dropdown()"></button>
                <?php 
                    echo "<span class='user'>".$fetch_user['Username']."</span>"; 
                ?>
                    <div id="myDropdown" class="dropdown-content">
                        <a href='account.php'>Account</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
                <a class="nav-icon" href="cart.php"><i class="fa-solid fa-cart-shopping"></i>
                    <sup>
                        <?php
                            $count = mysqli_query($conn, "SELECT * FROM `orderdetail` WHERE CustomerID = '$user_id'") or die('query failed');
                            $row_count = mysqli_num_rows($count);
                                echo "<span id='cart_count'>$row_count</span>";
                            
                        ?>
                    </sup>
                </a>
                <i class="bar-icon fa-solid fa-bars" onclick="menutoggle()"></i>
            </div>
        </div>
        <script src="js/index-navbar.js"></script>
        <!-- Toggle for Menu -->
        <script src="js/index-toggle.js"></script>
    </section>
    <!-- End Navbar -->

    <!-- Hero Banner -->
    <section id="hero-section">
        <div class="hero">
            <div>
                <h1>
                    <span>Brilliant. </span>
                    <span>In every way. </span>
                    <span>The ultimate. </span>
                </h1>
                <a href="help.html" class="btn">Learn More</a>
            </div>
        </div>
    </section>
    <!-- End Hero Banner -->

    <?php include_once "php/cart-items.php"; 
        if(isset($_GET['success'])){
            echo "<div class='msg msg-success'>Thank you for your order!</div>";
        }
    ?>
    <!-- Product -->
    <section id="products">
        <div class="title-container">
            <h1>
                <i class="fa-solid fa-store"></i> Product
            </h1>
        </div>
        <div class="p-filter">
            <span class="product tablink focus" onclick="AppleModel(event,'iPhone')">iPhone</span>
            <span class="product tablink" onclick="AppleModel(event,'iPad')">iPad</span>
            <span class="product tablink" onclick="AppleModel(event,'MacBook')">MacBook</span>
            <span class="product tablink" onclick="AppleModel(event,'Accessories')">Accessories</span>
        </div>
        
        

        <!-- Category: iPhone -->
        <div id='iPhone' class='product-box apple '>
            <?php
            $sql = "SELECT * FROM `product` WHERE `CategoryID` = 1;";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<form action='?id=".$row['ProductID']."#products' method='post'>
                            <div class='card'>
                                <div class='product-image'>
                                    <img src='data:image;base64," . base64_encode($row['ProductImage']) . "' alt=''>
                                </div>
                                <div class='product-content'>
                                    <span class='product-name'>" . $row['ProductName'] . " <span class='p-color'>".$row['Color']."</span></span>
                                    <input type='hidden' name='name' value='".$row['ProductName']."'>
                                    <input type='hidden' name='img' value='".base64_encode($row['ProductImage'])."'>
                                    <input type='hidden' name='color' value='".$row['Color']."'>
                                    <span class='p-description'>" . $row['ProductDescription'] . "</span>
                            <div class='select'>
                                <label>Storage</label>
                                <label>Quantity</label>
                            </div>
                            <div class='select'>
                                <span class='storage'>".$row['StorageCapacity']."GB</span>
                                <input type='hidden' name='storage' value='".$row['StorageCapacity']."'>
                                <input type='number' id='qty' name='quantity' value='1' min='1' max='10'>
                            </div>
                            <div class='p-item'>
                                        <span class='p-price'>₱ " .number_format($row['UnitPrice'],2). "</span>
                                        <input type='hidden' name='price' value='".$row['UnitPrice']."'>
                                        <button type='submit' name='addcart' class='p-cart' value='AddToCart' onclick=location.href='index.php#products'><i class='fa-solid fa-cart-plus'></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        ";
                } 
            } else {
                echo "<div class='p-nothing'>
                        <i class='nothing-icon fa-solid fa-heart-crack'></i>
                        <span>Something went wrong. Try again.</span>
                    </div>";
            }
            ?>
        </div>
        <!-- End Category: iPhone -->

        <!-- Category: iPad -->
        <div id="iPad" class="product-box apple" style="display: none;">
            <?php
            $sql = "SELECT * FROM `product` WHERE `CategoryID` = 2;";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<form action='?id=".$row['ProductID']."#products' method='post'>
                            <div class='card'>
                                <div class='product-image'>
                                    <img src='data:image;base64," . base64_encode($row['ProductImage']) . "' alt=''>
                                </div>
                                <div class='product-content'>
                                    <span class='product-name'>" . $row['ProductName'] . " <span class='p-color'>".$row['Color']."</span></span>
                                    <input type='hidden' name='name' value='".$row['ProductName']."'>
                                    <input type='hidden' name='img' value='".base64_encode($row['ProductImage'])."'>
                                    <input type='hidden' name='color' value='".$row['Color']."'>
                                    <span class='p-description'>" . $row['ProductDescription'] . "</span>
                            <div class='select'>
                                <label>Storage</label>
                                <label>Quantity</label>
                            </div>
                            <div class='select'>
                                <span class='storage'>".$row['StorageCapacity']."GB</span>
                                <input type='hidden' name='storage' value='".$row['StorageCapacity']."'>
                                <input type='number' id='qty' name='quantity' value='1' min='1' max='10'>
                            </div>
                            <div class='p-item'>
                                        <span class='p-price'>₱ " .number_format($row['UnitPrice'],2). "</span>
                                        <input type='hidden' name='price' value='".$row['UnitPrice']."'>
                                        <button type='submit' name='addcart' class='p-cart' value='AddToCart' onclick=location.href='index.php#products'><i class='fa-solid fa-cart-plus'></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        ";
                } 
            } else {
                echo "<div class='p-nothing'>
                        <i class='nothing-icon fa-solid fa-heart-crack'></i>
                        <span>Something went wrong. Try again.</span>
                    </div>";
            }
            ?>
        </div>
        <!-- End Category: iPad -->

        <!-- Category: MacBook -->
        <div id="MacBook" class="product-box apple" style="display: none;">
            <?php
            $sql = "SELECT * FROM `product` WHERE `CategoryID` = 3;";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<form action='?id=".$row['ProductID']."#products' method='post'>
                            <div class='card'>
                                <div class='product-image'>
                                    <img src='data:image;base64," . base64_encode($row['ProductImage']) . "' alt=''>
                                </div>
                                <div class='product-content'>
                                    <span class='product-name'>" . $row['ProductName'] . " <span class='p-color'>".$row['Color']."</span></span>
                                    <input type='hidden' name='name' value='".$row['ProductName']."'>
                                    <input type='hidden' name='img' value='".base64_encode($row['ProductImage'])."'>
                                    <input type='hidden' name='color' value='".$row['Color']."'>
                                    <span class='p-description'>" . $row['ProductDescription'] . "</span>
                            <div class='select'>
                                <label>Storage</label>
                                <label>Quantity</label>
                            </div>
                            <div class='select'>
                                <span class='storage'>".$row['StorageCapacity']."GB</span>
                                <input type='hidden' name='storage' value='".$row['StorageCapacity']."'>
                                <input type='number' id='qty' name='quantity' value='1' min='1' max='10'>
                            </div>
                            <div class='p-item'>
                                        <span class='p-price'>₱ " .number_format($row['UnitPrice'],2). "</span>
                                        <input type='hidden' name='price' value='".$row['UnitPrice']."'>
                                        <button type='submit' name='addcart' class='p-cart' value='AddToCart' onclick=location.href='index.php#products'><i class='fa-solid fa-cart-plus'></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        ";
                } 
            } else {
                echo "<div class='p-nothing'>
                        <i class='nothing-icon fa-solid fa-heart-crack'></i>
                        <span>Something went wrong. Try again.</span>
                    </div>";
            }
            ?>
        </div>
        <!-- End Category: MacBook -->

        <!-- Category: Accessories -->
        <div id="Accessories" class="product-box apple" style="display: none;">
            <?php
            $sql = "SELECT * FROM `product` WHERE `CategoryID` IN (4,5);";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<form action='?id=".$row['ProductID']."#products' method='post'>
                            <div class='card'>
                                <div class='product-image'>
                                    <img src='data:image;base64," . base64_encode($row['ProductImage']) . "' alt=''>
                                </div>
                                <div class='product-content'>
                                    <span class='product-name'>" . $row['ProductName'] . " <span class='p-color'>".$row['Color']."</span></span>
                                    <input type='hidden' name='name' value='".$row['ProductName']."'>
                                    <input type='hidden' name='img' value='".base64_encode($row['ProductImage'])."'>
                                    <input type='hidden' name='color' value='".$row['Color']."'>
                                    <span class='p-description'>" . $row['ProductDescription'] . "</span>
                            <div class='select'>
                                <label>Storage</label>
                                <label>Quantity</label>
                            </div>
                            <div class='select'>
                                <span class='storage'>N/A</span>
                                <input type='hidden' name='storage' value='".$row['StorageCapacity']."'>
                                <input type='number' id='qty' name='quantity' value='1' min='1' max='10'>
                            </div>
                            <div class='p-item'>
                                        <span class='p-price'>₱ " .number_format($row['UnitPrice'],2). "</span>
                                        <input type='hidden' name='price' value='".$row['UnitPrice']."'>
                                        <button type='submit' name='addcart' class='p-cart' value='AddToCart' onclick=location.href='index.php#products'><i class='fa-solid fa-cart-plus'></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        ";
                } 
            } else {
                echo "<div class='p-nothing'>
                        <i class='nothing-icon fa-solid fa-heart-crack'></i>
                        <span>Something went wrong. Try again.</span>
                    </div>";
            }
            ?>
        </div>
        <!-- End Category: Accessories -->

        <script src="js/index-category.js"></script>

    </section>
    <!-- End Product -->

    <!-- About -->
    <section id="about-section">
        <div class="about-section">
            <div class="about">
                <img class="about-logo" src="img/logo.png" alt="">
                <h1 class="about-title">ABOUT ERKY</h1>
                <p>ERKY APPLE PRODUCTS is a legitimate reseller who sells Apple products online with high quality
                    products and authentic apple products in affordable price. ERKY started opening a
                    business way back in the year 2020. Its goal was to answer inquiry, provide
                    important details to the consumers and safe transactions.</p>
            </div>
        </div>
    </section>
    <!-- End About -->

    <!-- Services -->
    <section id="service-section">
        <div class="service-section">
            <div class="service-top">
                <i class="the-icon fa-solid fa-bolt"></i>
                <h1 class="service-title">SERVICES</h1>
                <p>Why choose ERKY? Here are some services that we offer just for you!</p>
            </div>
            <div class="service-container">
                <div class="service-item">
                    <i class="fa-solid fa-truck-fast"></i>
                    <h2>On-Time Delivery</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis debitis rerum, magni voluptatem
                        sed architecto placeat beatae tenetur officia quod</p>
                </div>
                <div class="service-item">
                    <i class="fa-solid fa-calendar-check"></i>
                    <h2>Easy Order System</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis debitis rerum, magni voluptatem
                        sed architecto placeat beatae tenetur officia quod</p>
                </div>
                <div class="service-item">
                    <i class="fa-solid fa-user-group"></i>
                    <h2>Safe Transaction</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis debitis rerum, magni voluptatem
                        sed architecto placeat beatae tenetur officia quod</p>
                </div>
                <div class="service-item">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <h2>1 Year Warranty</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis debitis rerum, magni voluptatem
                        sed architecto placeat beatae tenetur officia quod</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Services -->

    <!-- divider -->
    <!-- End divider -->

    <!-- Contact -->
    <section id="contact-section">
        <div class="contact-section">
            <div class="contact-container">
                <i class="the-icon fa-solid fa-comments"></i>
                <h1 class="contact-title">CONTACT US</h1>
                <p>Leave your concerns here...</p>
                <div class="contact-info">
                    <form action="">
                        <input type="text" placeholder="Full Name" required>
                        <input type="email" placeholder="Email" required>
                        <input type="text" placeholder="Order No." required>
                        <textarea name="" id="" rows="10" placeholder="Your Message..."></textarea>
                        <button class="btn-submit" type="submit"><i class="fa-solid fa-paper-plane"></i>
                            Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact -->

    <!-- Footer -->
    <section id="footer-section">
        <div class="footer-section">
            <div class="footer">
                <ul class="footer-container ">
                    <li class="footer-items"><img class="footer-logo" src="img/logo.png" alt=""></li>
                </ul>
                <ul class="footer-container">
                    <li class="footer-items"><a href="" class="footer-header">Products</a></li>
                    <li class="footer-items"><a href="#products" class="footer-link">iPhone</a></li>
                    <li class="footer-items"><a href="#products" class="footer-link">iPad</a></li>
                    <li class="footer-items"><a href="#products" class="footer-link">MacBook</a></li>
                    <li class="footer-items"><a href="#products" class="footer-link">Accessories</a></li>
                </ul>
                <ul class="footer-container">
                    <li class="footer-items"><a href="" class="footer-header">Useful Links</a></li>
                    <li class="footer-items"><a href="#about-section" class="footer-link">ABOUT ERKY</a></li>
                    <li class="footer-items"><a href="#service-section" class="footer-link">SERVICES</a></li>
                    <li class="footer-items"><a href="#contact-section" class="footer-link">CONTACT</a></li>
                </ul>
                <ul class="footer-container">
                    <li class="footer-items"><a href="" class="footer-header">We Accept</a></li>
                    <!-- <li class="footer-items"><a href="" class="footer-link"><i class="fa-solid fa-building-columns"></i>
                            Bank Transfer</a></li>
                    <li class="footer-items"><a href="" class="footer-link"><i class="fa-solid fa-credit-card"></i>
                            ECPAY</a></li> -->
                    <li class="footer-items"><a href="" class="footer-link"><i class="fa-solid fa-truck"></i> Cash on
                            Delivery</a></li>
                    <li class="footer-items"><a href="" class="footer-link"><i class="fa-solid fa-hand-holding-dollar"></i> Cash on Pickup</a></li>

                </ul>
                <ul class="footer-container">
                    <li class="footer-items"><a href="" class="footer-header">Connected:</a></li>
                    <li class="footer-items"><a href="https://www.facebook.com" class="footer-link"><i class="fa-brands fa-facebook"></i>
                            Facebook</a></li>
                    <li class="footer-items"><a href="https://www.instagram.com" class="footer-link"><i class="fa-brands fa-instagram"></i>
                            Instagram</a></li>
                    <li class="footer-items"><a href="https://www.tiktok.com" class="footer-link"><i class="fa-brands fa-tiktok"></i>
                            Tiktok</a></li>
                    <li class="footer-items"><a href="https://www.messenger.com" class="footer-link"><i class="fa-brands fa-facebook-messenger"></i> Messenger</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End Footer -->

    <!-- Nav Ads -->
    <section class="nav-ads">
        <div class="nav-container">
            <div class="navslides navslide">
                <img src="img/banner/iphone13.png" style="width:100%">
            </div>
            <div class="navslides navslide">
                <img src="img/banner/ipad.png" style="width:100%">
            </div>
            <div class="navslides navslide">
                <img src="img/banner/macbook.png" style="width:100%">
            </div>
            <div class="navslides navslide">
                <img src="img/banner/airpods.png" style="width:100%">
            </div>
            <script src="js/index-navslide.js"></script>
        </div>
    </section>
    <!-- Nav Ads -->





</body>

</html>