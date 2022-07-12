<?php
    session_start();
    $id = $_POST['id'];
    $qty = 1;

    $i = 0;
    foreach ($_SESSION['shopping-cart'] as $key => $value) {
        if($id == $value['id']) {
            $old_qty = $value['quantity'];
            $new_qty = $old_qty - $qty;
            if($new_qty == 0) {
                unset($_SESSION['shopping-cart'][$key]);
                echo 'ok';
                exit;
            }else{
                $_SESSION['shopping-cart'][$key]['quantity'] = $new_qty;
                echo 'ok';
                exit;
            }
            $i++;
        } 
    }
?>