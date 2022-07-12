<?php
    require_once("../../admin/assets/config.php");
    session_start();
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    $query = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $query->execute([$id]);
    $result = $query->fetch();
    if(!isset($_SESSION['shopping-cart'])) {
       

        if($result['stock'] >= $qty) {
            $_SESSION['shopping-cart'] = array();
            $_SESSION['shopping-cart'][0] = [
                'id' => $id,
                'quantity' => $qty
            ];
            echo 'ok';
            exit;
        }else {
            echo "error";
            exit;
        }
       
    } else {

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

        if($i == 0){
            if($result['stock'] >= $qty) {
                array_push($_SESSION['shopping-cart'], [
                    'id' => $id,
                    'quantity' => $qty
                ]);
                echo 'ok';
                exit;
            }else {
                echo "error";
                exit;
            }
        }
    }
?>