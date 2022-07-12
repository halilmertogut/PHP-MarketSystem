<?php
require_once('./header.php');
    if (!isset($_SESSION['user'])) {
        header('Location: ./login.php');
        exit;
    }
?>

    <div class="container mt-5">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Title</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;
                        if(isset($_SESSION['shopping-cart'])){
                                foreach ($_SESSION['shopping-cart'] as $key => $value) { 
                                        $query = $conn->prepare('SELECT * FROM product WHERE id = ?');
                                        $query->execute([$value['id']]);
                                        $result = $query->fetch();
                                        $total_price += $result['discounted_price'] * $value['quantity']; 
                                    ?>
                                    <tr>
                                        <td><?=++$key?></td>
                                        <td>
                                            <?=$result['title']?>
                                        </td>
                                        <td><?=$result['discounted_price']?> ₺</td>
                                        <td><?=$value['quantity']?></td>
                                        <td><?=$value['quantity'] * $result['discounted_price']?> ₺</td>
                                        <td>
                                            <button onclick="InCreaseCart('<?=$value['id']?>')" class='btn btn-primary'>+</button>
                                            <button onclick="DeCreaseCart('<?=$value['id']?>')" class='btn btn-warning'>-</button>
                                            <button onclick="deleteCart('<?=$value['id']?>')" class='btn btn-danger'>Delete</button>
                                        </td>
                                    </tr>
                            <?php    
                            }
                        }
                    
                    ?>
                </tbody>
            </table>

            <div class=" mt-5 complete-shopping">
                <h3>Total Price : <?=$total_price?> ₺</h3>
                <?php
                    if(isset($_SESSION['shopping-cart']) && count($_SESSION['shopping-cart']) > 0) { ?>
                        <button onclick="CompleteShopping('<?=$total_price?>')" class='btn btn-success'>Complete the Shopping</button>
                 <?php   }
                ?>
            </div>
        </div>
    </div>

<?php
require_once('./footer.php');
?>