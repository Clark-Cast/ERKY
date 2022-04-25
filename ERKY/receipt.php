<?php
    include_once "php/db-con.php";

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    }

    if(isset($_POST['confirm'])){

    $p_select = mysqli_query($conn, "SELECT * FROM `orderdetail` WHERE `CustomerID` = '$user_id'");

        if(mysqli_num_rows($p_select) > 0){
            while($row = mysqli_fetch_assoc($p_select)){
                $p_delete = mysqli_query($conn, "DELETE FROM `orderdetail` WHERE `CustomerID` = '$user_id'");
                $p_insert = mysqli_query($conn, "INSERT INTO `admin_orderdetail` (ProductID, CustomerID, ProductImage, ProductName, Color, StorageCapacity, Quantity, UnitPrice)
                VALUES ('".$row['ProductID']."','$user_id','".$row['ProductImage']."','".$row['ProductName']."','".$row['Color']."',
                '".$row['StorageCapacity']."','".$row['Quantity']."','".$row['UnitPrice']."');");
                header("location:index.php?success=1");
            }
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ERKY Apple Products | Thank You!</title>

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
    
</head>
<body>
    <form action="" method="POST">
        <div class="main-content">
            <div class="invoice-container">
                <div class="row main">
                <?php
                    $sql = mysqli_query($conn, "SELECT orders.OrderID, orders.CustomerID, customer.CustomerName, orders.Address, orders.City, orders.State, orders.Zip, 
                    orders.Contact, orders.Email, orders.OrderDate, orders.ShippingDate, orders.DeliveryDate, orders.Amount FROM orders INNER JOIN customer ON customer.CustomerID = $user_id;");
                    if(mysqli_num_rows($sql) > 0){
                        $order = mysqli_fetch_assoc($sql);
                        
                echo "
                    <div class='col-5 py-2'>
                        <div class='main-title'>ORDER</div>
                        <div class='order-code'>#".$order['OrderID']."</div>
                    </div>
                    <div class='col-7 lh-lg text-end py-2'>
                        <div class='fw-bold'> Standard Delivery - COD</div>
                        <div class='fst-italic'> Estimated Delivery Time</div>
                        <div class='fst-italic'> ".$order['ShippingDate']."—".$order['DeliveryDate']."</div> 
                    </div>
                </div>
                <div class='row mt-5'>
                    <div class='col-6 py-2'>
                        <div class='fw-bold fs-4'>DELIVER TO</div>
                        <div class='fst-italic addr'>
                            ".$order['CustomerName']." — ".$order['Contact']." (".$order['Address'].",  
                            ".$order['City'].", ".$order['State'].", ".$order['Zip'].")
                        </div>
                    </div>
                    <div class='col-6 py-2 text-end'>
                        <div class='fw-bold'> Total Package Amount: <div class='fs-4'>₱ ".number_format($order['Amount'],2)."</div></div>
                    </div>
                </div>";
                
                ?>
                <table class='table mt-5'>
                    <thead>
                        <tr>
                            <th scope='col' class='prod'>Product</th>
                            <th scope='col' class='prod'>Description</th>
                            <th scope='col' class='prod'>Qty.</th>
                            <th scope='col' class='prod'>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $q = mysqli_query($conn, "SELECT * FROM `orderdetail` WHERE CustomerID = '$user_id'");
                        if(mysqli_num_rows($sql) > 0){
                            while($item = mysqli_fetch_assoc($q)){
                                $total_price = $item['UnitPrice'] * $item['Quantity'];
                                echo "
                                    <tr>

                                        <td class='prod w-25'>".$item['ProductName']."</td>
                                        <td class='prod w-25'>".$item['Color'].", ".$item['StorageCapacity']."</td>
                                        <td class='prod'>".$item['Quantity']."</td>
                                        <td class='prod'>₱ ".number_format($total_price,2)."</td>
                                    </tr>
                                ";
                            }
                        }
                    ?>
                    </tbody> 
                </table>

                <div class='t-amount'>
                    <div class='row'>
                        <div class='col-8 text-end'>
                            <div class='fw-bold'>Subtotal</div>
                            <div class='fw-bold'>Delivery Charges</div>
                            <div class='fw-bold'>Total Amount</div>
                        </div>
                        <div class='col-4'>
                            <div class='text-secondary'>₱ <?php echo number_format($order['Amount'],2);  ?></div>
                            <div class='text-success'>FREE</div>
                            <div class='fw-bold text-secondary'>₱ <?php echo number_format($order['Amount'],2); } ?></div>
                        </div>
                    </div>
                </div>
                <div class='action'>
                    <div class='row'>
                        <div class='col-6 py-1'>
                            <button type='submit' name="confirm">Confirm</button>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </form>
</body>
</html>