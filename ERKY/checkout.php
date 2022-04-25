<?php
    include_once "php/db-con.php";
    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    }
    
    if(isset($_POST['place_order'])){
        $c_id = $user_id;
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $amount = $_POST['amount'];

        //Order Date
        $dt = date("Y-m-d");
        
        //Shipping Date
        $s_dt = date("Y-m-d");
        $s_date=date_create($s_dt);
        date_add($s_date,date_interval_create_from_date_string("1 day"));
        $s_set = date_format($s_date,"Y-m-d");

        //Delivery Date
        $d_dt = date("Y-m-d");
        $d_date=date_create($d_dt);
        date_add($d_date,date_interval_create_from_date_string("7 days"));
        $d_set = date_format($d_date,"Y-m-d");
        

        $orders = mysqli_query($conn, "SELECT * FROM `customer` WHERE CustomerID = $user_id;");
        
        if(mysqli_num_rows($orders) > 0){
                mysqli_query($conn, "INSERT INTO `orders` (CustomerID, Address, City, State, Zip, Contact, Email, OrderDate, ShippingDate, DeliveryDate, Amount)
                VALUES ('$c_id','$address','$city','$state','$zip','$contact','$email','$dt','$s_set','$d_set','$amount');");
                header("location:receipt.php");
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERKY Apple Products | Checkout</title>

    <!-- Website Icon -->
    <link rel="icon" href="img/logo.png" type="image/png" sizes="20x20">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/checkout.css">
    <!-- CSS Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- FontAwesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap"
        rel="stylesheet">

        <script type="text/javascript">
            window.history.forward();
        </script>
</head>

<body >
    <!-- Navbar -->
    <section class="navbar-section">
        <div class="navbar_container">
            <div class="navbar_nb">
                <div class="logo">
                    <a href="http://localhost/ERKY/"><img src="img/logo.png" alt=""></a>
                </div>
                <div class="nav_icon">
                    <a href=""><i class="fa-solid fa-circle-user"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Navbar -->
    <form action=""method="POST">
        <section class="checkout-form border rounded">
            <div class="row m-1">
                <div class="col-md-12 bg-dark p-2">
                    <div class="row">
                        <div class="col-6">
                            <span class="payment-title">Payment Method</span>
                        </div>
                        <div class="col-6">    
                            <span class="payment-method">Cash on Delivery</span>
                        </div>
                    </div>
                </div> 
            </div>
            
            <div class="row d-flex flex-sm-row-reverse pt-2 m-2 b-bottom">
                <div class="col-md-5 px-3">
                    <div class="row border-bottom pb-2">
                        <div class="col-6">
                            <span class="price-cart-title">My Cart</span>
                        </div>
                        <div class="col-6">
                            <?php
                                $count = mysqli_query($conn, "SELECT * FROM `orderdetail` WHERE CustomerID = '$user_id'") or die('query failed');
                                $row_count = mysqli_num_rows($count);
                                    echo "<span class='cart_count'>$row_count</span>";
                                
                            ?>
                        </div>
                    </div>
                    <div class='row mt-4'>
                    <?php
                        $select_cart = mysqli_query($conn, "SELECT * FROM `orderdetail` WHERE `CustomerID`='$user_id'");
                        $total = 0;
                        $grand_total = 0;
                        if(mysqli_num_rows($select_cart) > 0){
                            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                            $total_price = $fetch_cart['UnitPrice'] * $fetch_cart['Quantity'];
                            $grand_total = $total += $total_price;

                            echo "
                                
                                <div class='col-6 border-bottom py-2'>
                                    <span class='d-block price-title'>".$fetch_cart['ProductName']."</span>
                                    <span class='d-block price-subtitle'>".$fetch_cart['Color'].",".$fetch_cart['StorageCapacity']."GB</span>
                                </div>
                                <div class='col-6 border-bottom py-2'>
                                    <span class='d-block price'>₱ ".number_format($total_price,2)."</span>
                                </div>
                            ";
                            }
                    ?>
                    </div>
                    <div class="row">
                        <div class="col-6 py-2">
                            <span class="d-block">Delivery Charges</span>
                        </div>
                        <div class="col-6 py-2">
                            <span class="d-block text-success text-end">FREE</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 py-2"><span class="d-block">Grand Total</span></div>
                        <div class="col-6 py-2 text-end">
                            <span class="d-block fw-bold g-total">₱ <?= number_format($grand_total,2); }?></span>
                        <input type="hidden" name="amount" value="<?= $grand_total;?>">
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <span class="checkout-title">Billing Address</span>
                <span class="checkout-subtitle">Kindly complete the <span class="text-danger">*</span>required fields in the form.</span>
                    <div class="row cust-name mx-1">
                        <?php
                            $select = mysqli_query($conn, "SELECT * FROM `customer` WHERE `CustomerID`='$user_id'");
                            if(mysqli_num_rows($select_cart) > 0){
                                while($fetch = mysqli_fetch_assoc($select)){
                                    echo"    
                                    <div class='col-6'>
                                        <span class='fw-bold'>Customer's name :</span>
                                    </div>
                                    <div class='col-6'>
                                        <span class='fst-italic'>".$fetch['CustomerName']."</span>
                                        <input type='hidden' name='name' value='".$fetch['CustomerName']."' readonly>
                                    </div>
                                    ";
                                }
                            }
                        ?>
                        

                        
                    </div>
                    <div class="row mt-1">
                        <div class="col-12">
                            <label for="contact"><span class="text-danger">*</span>Address</label>
                            <input type="text" name="address" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">
                            <label for="city"><span class="text-danger">*</span>City</label>
                            <input type="text" name="city" autocomplete="off" required>
                        </div>
                        <div class="col-4">
                            <label for="barangay"><span class="text-danger">*</span>State</label>
                            <input type="text" name="state" autocomplete="off" required>
                        </div>
                        <div class="col-4">
                            <label for="zip"><span class="text-danger">*</span>Zip</label>
                            <input type="text" name="zip" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <label for="contact"><span class="text-danger">*</span>Contact No.</label>
                            <input type="tel" name="contact" placeholder="09xxxxxxx" pattern="[0]{1}[0-9]{10}" autocomplete="off" required>
                        </div>
                        <div class="col-6">
                            <label for="email">Email (Optional)</label>
                            <input type="email" name="email" placeholder="example@gmail.com" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-6">
                            <button type="submit" name="place_order" class="btn btn-dark w-100">Place Order</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" name="cancel" class="btn btn-danger w-100">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </section> 
    </form>

</body>

</html>