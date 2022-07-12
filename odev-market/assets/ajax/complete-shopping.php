<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
    $total_price = $_POST['totalPrice'];
    require_once("../../admin/assets/config.php");
    session_start();
   
    if(isset($_SESSION['shopping-cart']) && isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['id'];
        $payment_number = time();
        $payment_query = $conn->prepare('INSERT INTO payments (user_id, payment_number , total_price) VALUES (?,?,?)');
        $payment_query->execute([$user_id, $payment_number, $total_price]);

        foreach ($_SESSION['shopping-cart'] as $key => $value) {
            $order_query = $conn->prepare('INSERT INTO orders (qty , product_id  , payment_number) VALUES (?,?,?)');
            $order_query->execute([$value['quantity'], $value['id'], $payment_number]);

            $product_query = $conn->prepare('UPDATE product SET stock = stock - ? WHERE id = ?');
            $product_query->execute([$value['quantity'], $value['id']]);
        }
        unset($_SESSION['shopping-cart']);
        echo 'ok';
       
    }
?>