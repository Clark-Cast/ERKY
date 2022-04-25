<?php
  include_once "php/db-con.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>ERKY Apple Products | Getting Started</title>

  <!-- Website Icon -->
  <link rel="icon" href="img/logo.png" type="image/png" sizes="20x20">
  <!-- Stylesheet -->
  <link rel="stylesheet" href="css/form.css">
  <!-- FontAwesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap"
    rel="stylesheet">
</head>

<body>
    <span><a href="help.html" data-toggle="tooltip" data-placement="right" title="Help"><i class="fa-solid fa-circle-question"></i></a>Help</span>
    <div class="container">
        <div class="form-container">
            <form action="" method="post">
                <h2 class="title">Sign up</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="fullname" placeholder="Fullname">
                </div>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="user" placeholder="Username">
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email">
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="pass" placeholder="Password">
                </div>
                <div class="input-field">
                    <i class="fa-solid fa-star-of-life"></i>
                    <input type="password" name="cpass" placeholder="Confirm Password">
                </div>
                <?php
                    if(isset($_POST['register'])) {
                    $fullname = $_POST['fullname'];
                    $username = $_POST['user'];
                    $email = $_POST['email'];
                    $password = md5($_POST['pass']);
                    $cpassword = md5($_POST['cpass']);

                    if ($password == $cpassword) {
                        $sql = "SELECT * FROM `customer` WHERE `Username`='$username' OR `Email`='$email'";
                        $result = mysqli_query($conn, $sql);
                        if (!mysqli_num_rows($result) > 0) {
                        $sql = "INSERT INTO `customer` (`CustomerName`, `Username`, `Email`, `Password`)
                            VALUES ('$fullname', '$username', '$email', '$password')";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            echo "<div class='msg msg-success'>Yey! Let's Go.</div>";
                        } else {
                            echo "<div class='msg msg-warning'>Woops! Empty Field.</div>";
                        }
                        } else if(empty($fullname) || empty($username) || empty($email) || empty($password) || empty($cpassword)){
                        echo "<div class='msg msg-warning'>Woops! Empty Field.</div>";
                        } else {
                            echo "<div class='msg msg-warning'>Woops! Username/Email Already Exists.</div>";
                        }
                    } else {
                        echo "<div class='msg msg-danger'>Password Does Not Matched.</div>";
                    }
                    }
                ?>
                <button type="submit" name="register">Register</button>
            </form>
            <div class="content">
                <img src="img/logo.png" alt="">
                <h3>Already have an account?</h3>
                <p>
                    Sign in with your account.
                </p>
                <button onclick='location.href="login.php"'>Sign in</button>
            </div>  
        </div>
    </div>

</body>

</html>