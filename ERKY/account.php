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

    <title>Account</title>

    <!-- Website Icon -->
    <link rel="icon" href="img/logo.png" type="image/png" sizes="20x20">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/account.css">
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
    <div class="container" id="profile">
        <div class="main-body">
            <br><br><br>
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card pb-1">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="https://media.istockphoto.com/vectors/user-member-vector-icon-for-ui-user-interface-or-profile-face-avatar-vector-id1130884625?k=20&m=1130884625&s=612x612&w=0&h=OITK5Otm_lRj7Cx8mBhm7NtLTEHvp6v3XnZFLZmuB9o=" alt="Admin"
                                    class="rounded-circle" width="150">
                                <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM `customer` WHERE `CustomerID` ='$user_id'");
                                    if(mysqli_num_rows($sql) > 0){
                                        while($user = mysqli_fetch_assoc($sql)){
                                            echo "
                                            <div class='mt-2'>
                                    <h4>".$user['CustomerName']."</h4>
                                    <p class='text-secondary mb-1'>Hi I'm ".$user['Username']."</p>
                                    <p class='text-muted font-size-sm'>".$user['Email']."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-8'>
                    <div class='card px-3 py-2 mb-2'>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-12'><h5 class='mb-4'>Profile</h5></div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-sm-3'>
                                    <h6 class='mb-0'>Full Name</h6>
                                </div>
                                <div class='col-sm-9 text-secondary'>
                                    ".$user['CustomerName']."
                                </div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-sm-3'>
                                    <h6 class='mb-0'>Username</h6>
                                </div>
                                <div class='col-sm-9 text-secondary'>
                                    ".$user['Username']."
                                </div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-sm-3'>
                                    <h6 class='mb-0'>Email</h6>
                                </div>
                                <div class='col-sm-9 text-secondary'>
                                    ".$user['Email']."
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                            ";
                                        }
                                    }
                                ?>
    <br><br><br>
    <?php
    if(isset($_POST['changepass'])){
        $oldpass=md5($_POST['old_password']);
        $newpassword=md5($_POST['new_password']);
        $sql=mysqli_query($conn,"SELECT Password FROM `customer` where Password='$oldpass' && CustomerID='$user_id'");
        $num=mysqli_fetch_array($sql);
        if($num>0){
            $con=mysqli_query($conn,"UPDATE `customer` SET Password='$newpassword' WHERE CustomerID='$user_id'");
            echo "<div class='text-success container'>Password Changed Successfully</div>";
        } else {
            echo "<div class='text-danger container'>Old Password not match</div>";
    }
    }
    ?>
    <div class="container" id="settings">
        <div class="card mx-2">
            <div class="card-header">
                <h4 class="">Change your password</h4>
                </div>
                <div class="card-body">
                <div style="width:500px; margin:0px auto">
                <form class="" action="" method="POST">
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input type="password" name="old_password"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password"  class="form-control">
                    </div>
                    <div class="form-group mt-1">
                        <button type="submit" name="changepass" class="btn btn-success">Change password</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <div class="container mb-5" id="orders">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-12 mb-3">
                    <div class='card pb-1'>
                        <div class='row'>
                            <div class='col-12'><h5 class='m-4'>My Orders</h5></div>
                        </div>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='row p-1 m-1 text-center fw-bold border-bottom'>
                                    <div class='col-md-1'>
                                        OrderID
                                    </div>
                                    <div class='col-md-3'>
                                        Address
                                    </div>
                                    <div class='col-md-3'>
                                        Contact
                                    </div>
                                    <div class='col-md-3'>
                                        Est. Delivery Date
                                    </div>
                                    <div class='col-md-2'>
                                        Amount
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        $o_table = mysqli_query($conn, "SELECT * FROM `orders` WHERE `CustomerID` ='$user_id'");
                        $count = mysqli_query($conn, "SELECT * FROM `admin_orderdetail` WHERE CustomerID = '$user_id'");
                        $row_count = mysqli_num_rows($count);
                        if(mysqli_num_rows($o_table) > 0){
                            while($orders = mysqli_fetch_assoc($o_table)){
                                echo"
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='row p-1 m-1 text-center border-bottom'>
                                    <div class='col-md-1'>
                                        ".$orders['OrderID']."
                                    </div>
                                    <div class='col-md-3'>
                                        ".$orders['Address'].",".$orders['City'].",".$orders['State'].",".$orders['Zip']."
                                    </div>
                                    <div class='col-md-3'>
                                        ".$orders['Contact']."
                                    </div>
                                    <div class='col-md-3'>
                                        ".$orders['ShippingDate']." to ".$orders['DeliveryDate']."
                                    </div>
                                    <div class='col-md-2'>
                                        ".$orders['Amount']."
                                    </div>
                                </div>
                            </div>
                        </div>
                    
               
        
    
                                ";
                            }
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                
</body>

</html>