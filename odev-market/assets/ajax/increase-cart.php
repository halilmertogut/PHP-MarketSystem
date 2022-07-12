<?php
    require_once("../../admin/assets/config.php");
    session_start();
    $id = $_POST['id'];
    $qty = 1;
    $query = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $query->execute([$id]);
    $result = $query->fetch();

    $i = 0;
    foreach ($_SESSION['shopping-cart'] as $key => $value) {
        if($id == $value['id']) {
            $old_qty = $value['quantity'];
            $new_qty = $old_qty + $qty;
            if($result['stock'] >= $new_qty) {
                $_SESSION['shopping-cart'][$key]['quantity'] = $new_qty;
                echo 'ok';
                exit;
            }else{
                echo "error";
                exit;
            }
            $i++;
        } 
    }
?>