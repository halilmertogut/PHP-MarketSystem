<?php
    session_start();
    $id = $_POST['id'];

    $i = 0;
    foreach ($_SESSION['shopping-cart'] as $key => $value) {
        if($id == $value['id']) {
            unset($_SESSION['shopping-cart'][$key]);
            echo 'ok';
            exit;
        } 
    }
?>