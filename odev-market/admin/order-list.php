<?php
require_once('./header.php');
if (!isset($_SESSION['admin'])) {
    header('Location: ./login.php');
    exit;
}

    $query = $conn->prepare('SELECT * FROM market_users');
    $query->execute();
    $result = $query->fetchAll();
?>

<div class="container mt-5">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Payment Number</th>
                    <th scope="col">User</th>
                    <th scope="col">Product</th>
                    <th scope="col">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $conn->prepare('SELECT * FROM payments ORDER BY id DESC');
                    $query->execute();
                    $result = $query->fetchAll();
                        foreach ($result as $key => $value) { 
                                $query_orders = $conn->prepare('SELECT * FROM orders WHERE payment_number = ?');
                                $query_orders->execute([$value['payment_number']]);
                                $result_orders = $query_orders->fetchAll();

                                $query_user = $conn->prepare('SELECT * FROM consumers WHERE id = ?');
                                $query_user->execute([$value['user_id']]);
                                $result_user = $query_user->fetch();
                            ?>
                            <tr>
                                <td><?=++$key?></td>
                                <td>
                                    <?=$value['payment_number']?>
                                </td>
                                <td>
                                <a target="_blank" href='consumer-edit.php?id=<?=$result_user['id']?>'><?=$result_user['fullname']?></a>
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

<?php
require_once('./footer.php');
?>