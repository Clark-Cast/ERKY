<?php
include_once "php/db-con.php";
include_once "php/cart-items.php";

$user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    }

    if(isset($_POST['update'])){
        $update_value = $_POST['quantity'];
        $update_id = $_POST['target_id'];
        $update_quantity_query = mysqli_query($conn, "UPDATE `orderdetail` SET `Quantity` = '$update_value' WHERE `OrderDetailID` = '$update_id';");
        if($update_quantity_query){
            header('location:cart.php?updated_item=1');
        }
    }

    if(isset($_POST['remove'])){
        $remove_id = $_POST['target_id'];
        mysqli_query($conn, "DELETE FROM `orderdetail` WHERE `OrderDetailID` = '$remove_id';");
        header('location:cart.php?removed_item=1');
    }

   

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERKY Apple Products | Add to Cart</title>

    <!-- Website Icon -->
    <link rel="icon" href="img/logo.png" type="image/png" sizes="20x20">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/cart.css">
    <!-- CSS Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- FontAwesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap"
        rel="stylesheet">

</head>

<body>
    <!-- Navbar -->
    <section class="navbar-section">
        <div class="navbar_container">
            <div class="navbar_nb">
               <div class="logo">
                    <a href="http://localhost/ERKY/"><img src="img/logo.png" alt=""></a>
                </div>
            </div>
            <script src="js/index-navbar.js"></script>
        </div>
    </section>
    <!-- End Navbar -->
    <?php
        if(isset($_GET['updated_item'])){
            echo "<div class='msg msg-primary'>Product updated successfully!
                    <span class='close-btn' onclick=this.parentElement.style.display='none';><i class='fa-solid fa-circle-xmark'></i></span> 
                </div>";
        }
        if(isset($_GET['removed_item'])){
            echo "<div class='msg msg-danger'>Product removed successfully!
                    <span class='close-btn' onclick=this.parentElement.style.display='none';><i class='fa-solid fa-circle-xmark'></i></span> 
                </div>";
        }
        
    ?>
    
    <div class="cart-items">
        <a class="go-back py-3" href='http://localhost/ERKY/'><i class="fa-solid fa-arrow-left-long"></i> Continue Shopping</a>
        <div class="row mt-3 p-1">
            <div class="col-md-7 order-details mb-3 p-3">
                <span class="cart-title mt-2"><i class="fa-solid fa-cart-shopping"></i> MyCart </span>
                <?php
                
                    $p_select = mysqli_query($conn, "SELECT * FROM `orderdetail` WHERE `CustomerID` = '$user_id'") or die('query failed');
                    if(mysqli_num_rows($p_select) > 0){
                        while($cart = mysqli_fetch_assoc($p_select)){
                            $sub_total = $cart['UnitPrice'] * $cart['Quantity'];
                            @$grand_total += $sub_total;
                            @$g_total = number_format($grand_total);
                             
                        echo "
                        <form action='' method='post'>
                            <div class='row m-2 border-bottom'>
                                <div class='col-3 text-center py-5 my-3'>
                                    <img src='data:image;base64,".$cart['ProductImage']."' alt='' class='w-75'>
                                </div>";
                               
                            if($cart['StorageCapacity'] == 0){
                                echo "<div class='col-4 py-5 my-3'>
                                    <h4 class='pt-2 p-name'>".$cart['ProductName']."</h4>
                                    <span>".$cart['Color']."</span>  
                                    <span class='d-block pt-2'>Unit Price:<br>₱ ".number_format($cart['UnitPrice'],2)."</span>
                                    <span class='d-block pt-2 fs-4 fw-bold'>₱ ". number_format($sub_total,2) ."</span>
                                </div>
                                <div class='col-2 py-5 my-3'>
                                    <input class='w-100' type='number' name='quantity' value='".$cart['Quantity']."' min='1' max='10'>
                                    <input class='w-100' type='hidden' name='target_id' value='".$cart['OrderDetailID']."' min='1' max='10'>
                                </div>
                                <div class='col-3 text-center py-5 my-3'>
                                    <button type='submit' class='btn btn-sm btn-danger my-2' name='remove'><i class='fa-solid fa-xmark'></i> Remove</button>
                                    <button type='submit' class='btn btn-sm btn-primary my-2' name='update'><i class='fa-solid fa-square-pen'></i> Update</button>
                                </div>
                            </div>
                        </form>";
                            } else {
                                echo "<div class='col-4 py-5 my-3'>
                                    <h4 class='pt-2 p-name'>".$cart['ProductName']."</h4>
                                    <span>".$cart['Color'].",".$cart['StorageCapacity']." GB</span>  
                                    <span class='d-block pt-2'>Unit Price:<br>₱ ".number_format($cart['UnitPrice'],2)."</span>
                                    <span class='d-block pt-2 fs-4 fw-bold'>₱ ". number_format($sub_total,2) ."</span>
                                </div>
                                <div class='col-2 py-5 my-3'>
                                    <input class='w-100' type='number' name='quantity' value='".$cart['Quantity']."' min='1' max='10'>
                                    <input class='w-100' type='hidden' name='target_id' value='".$cart['OrderDetailID']."' min='1' max='10'>
                                </div>
                                <div class='col-3 text-center py-5 my-3'>
                                    <button type='submit' class='btn btn-sm btn-danger my-2' name='remove'><i class='fa-solid fa-xmark'></i> Remove</button>
                                    <button type='submit' class='btn btn-sm btn-primary my-2' name='update'><i class='fa-solid fa-square-pen'></i> Update</button>
                                </div>
                            </div>
                        </form>
                        ";
                            }
                        } 
                    } else {
                        echo "<div class='empty-cart'>
                                    <span><i class='fa-solid fa-face-sad-cry'></i></span>
                                    <h5>Your Cart is Empty! <a href='http://localhost/ERKY/'>Continue Shopping</a></h5>
                                </div>";
                    }
                        
                ?>
            </div>
            <div class="col-md-4 price-details offset-md-1">
                <span class="price-title m-3 p-2"><i class="fa-solid fa-receipt"></i> Price Details </span>
                <div class="row m-3">
                    <div class="col-6">
                        <?php
                            $count = mysqli_query($conn, "SELECT * FROM `orderdetail` WHERE `CustomerID` = '$user_id'") or die('query failed');
                            $row_count = mysqli_num_rows($count);
                                echo "<b>SubTotal</b> ($row_count item(s))
                                </div>";
                                if($row_count == 0 ){
                                    echo "<div class='col-6'>
                                        ₱ 0.00
                                   </div>";
                                } else {
                                    echo "<div class='col-6'>
                                            ₱ ".@$g_total."
                                    </div>";
                                }
                        ?>
                </div>
                <div class="row m-3">
                    <div class="col-6">
                        <b>Delivery Charges</b>
                    </div>
                    <div class="col-6">
                        <span class="text-success">FREE</span>
                    </div>
                </div>
                <div class="row m-3">
                    <div class="col-6">
                        <b>Grand Total</b>
                    </div>
                    <div class="col-6">
                        <span>₱ 
                            <?php 
                                if(@$sub_total == 0) {
                                    echo "0.00";
                                } else {
                                    echo @$g_total; 
                                } 
                            ?>
                        </span>
                    </div>
                </div>
                <div class="row m-4">
                    <a href="checkout.php" class='btn btn-block btn-warning <?= ($grand_total > 0)?'':'disabled'; ?>'><i class="fa-solid fa-bell-concierge"></i> Checkout</a>
                </div>
            </div>
        </div>
    </div>        
</body>

</html>