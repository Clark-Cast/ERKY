<?php
include_once "php/db-con.php";

$user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    }

if(isset($_POST['addcart'])){
    $p_id = $_GET['id'];
    $p_name = $_POST['name'];
    $p_img = $_POST['img'];
    $p_color = $_POST['color'];
    $p_storage = $_POST['storage'];
    $p_quantity = $_POST['quantity'];
    $p_price = $_POST['price'];

    $p_select = mysqli_query($conn, "SELECT * FROM `orderdetail` WHERE `ProductID` = '$p_id' AND `CustomerID` = '$user_id'");

    if(mysqli_num_rows($p_select) > 0){
        header("location:index.php?already=1");
    } else {
        $p_insert = mysqli_query($conn, "INSERT INTO `orderdetail` (ProductID, CustomerID, ProductImage, ProductName, Color, StorageCapacity, Quantity, UnitPrice)
        VALUES ('$p_id','$user_id','$p_img','$p_name','$p_color','$p_storage','$p_quantity','$p_price');");
        header("location:index.php?inserted=1");
    }
}

        if(isset($_GET['inserted'])){
            echo "<div class='msg msg-success'>Product added to cart successfully! 
                    <span class='close-btn' onclick=this.parentElement.style.display='none';><i class='fa-solid fa-circle-xmark'></i></span> 
                </div>"; 
        }
        if(isset($_GET['already'])){
            echo "<div class='msg msg-warning'>Product already in the cart! 
                    <span class='close-btn' onclick=this.parentElement.style.display='none';>
                        <i class='fa-solid fa-circle-xmark'></i>
                    </span> 
                </div>";
        }
?>