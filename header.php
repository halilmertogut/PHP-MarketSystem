<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
    require_once("./admin/assets/config.php");
    session_start();
    ob_start();

    if (!isset($_SESSION['shopping-cart']) || count($_SESSION['shopping-cart']) == 0) {
        $shopping_cart_count = 0;
    }else{
        $shopping_cart_count = count($_SESSION['shopping-cart']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="./assets/css/main.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Market</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <?php
            if(!isset($_SESSION['user'])){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php" tabindex="-1" aria-disabled="true">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php" tabindex="-1" aria-disabled="true">Register</a>
                </li>
         <?php   } else{ ?>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php" tabindex="-1" aria-disabled="true">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shopping-cart.php" tabindex="-1" aria-disabled="true">Shopping Cart (<?=$shopping_cart_count?>)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" tabindex="-1" aria-disabled="true">Logout</a>
                </li>
        <?php }
        ?>
      </ul>
      <form class="d-flex" method='GET' action='index.php'>
        <input class="form-control me-2" type="search" name='search' placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

