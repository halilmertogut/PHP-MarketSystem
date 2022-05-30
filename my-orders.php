<?php
require_once('./header.php');
if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}

if(isset($_POST['update'])){
    $control = $conn->prepare('SELECT * FROM consumers WHERE id = ?');
    $control->execute([$_SESSION['user']['id']]);
    $control_result = $control->fetchAll();

    if(isset($_POST['password']) && $_POST['password'] != ''){
        $password = md5($_POST['password']);
    }else {
        $password = $control_result[0]['password'];
    }

    $fullname = $_POST['fullname'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $district = $_POST['district'];

    
    $insert = $conn->prepare('UPDATE consumers SET fullname = ?, password = ?, city = ?, address = ?, district = ? WHERE id = ?');
    $insert->execute([$fullname, $password, $city, $address, $district , $_SESSION['user']['id']]);
    if($insert){
        $control = $conn->prepare('SELECT * FROM consumers WHERE id = ?');
        $control->execute([$_SESSION['user']['id']]);
        $control_result = $control->fetchAll();
        $_SESSION['user'] = $control_result[0];
        $messages = '<div class="alert alert-success" role="alert">Profile update successful !</div>';
    }else{
        $messages = '<div class="alert alert-danger" role="alert">
        Error occurred while updating profile !</div>';
    }
}
?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <?php
                    include_once('./profile-sidebar.php');
                ?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Payment Number</th>
                    <th scope="col">Product</th>
                    <th scope="col">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $conn->prepare('SELECT * FROM payments WHERE user_id = ? ORDER BY id DESC');
                    $query->execute([$_SESSION['user']['id']]);
                    $result = $query->fetchAll();
                        foreach ($result as $key => $value) { 
                                $query_orders = $conn->prepare('SELECT * FROM orders WHERE payment_number = ?');
                                $query_orders->execute([$value['payment_number']]);
                                $result_orders = $query_orders->fetchAll();
                            ?>
                            <tr>
                                <td><?=++$key?></td>
                                <td>
                                    <?=$value['payment_number']?>
                                </td>
                                <td>
                                    <?php
                                        foreach ($result_orders as $order) {
                                            $product_query = $conn->prepare('SELECT * FROM product WHERE id = ?');
                                            $product_query->execute([$order['product_id']]);
                                            $product_result = $product_query->fetch();
                                            ?>
                                            <div class='order-table-div'>
                                                <p>Product Title : <?=$product_result['title']?></p>
                                                <p>Unit Price : <?=$product_result['discounted_price']?> ₺</p>
                                                <p>Quantity : <?=$order['qty']?></p>
                                                <p>Total Price : <?=$order['qty'] * $product_result['discounted_price']?> ₺</p>
                                            </div>

                                     <?php   }
                                    ?>

                                    
                                </td>
                                <td><?=$value['total_price']?> ₺</td>
                                
                            </tr>
                    <?php    
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
        
    </div>

<?php
require_once('./footer.php');
?>