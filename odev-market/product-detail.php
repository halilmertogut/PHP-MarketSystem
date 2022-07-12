<?php
require_once('./header.php');
$id = $_GET['id'];
$query = $conn->prepare('SELECT * FROM product WHERE id = ?');
$query->execute([$id]);
$result = $query->fetch();
?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <img width="100%" src="./assets/img/<?=$result['image']?>" />
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <h2><?=$result['title']?></h2>
                <p>
                    <span class="normal-price-product-detail"><?=$result['discounted_price']?> ₺</span>
                    <span class="discounted-price-product-detail"><?=$result['normal_price']?> ₺</span>
                </p>
                
                <p>Expiration Date : <span class="expiration-date"><?=$result['expiration_date']?></span></p>
                <p>Stock : <span class="expiration-date"><?=$result['stock']?></span></p>
                <div class="mb-3">
                    <label>Quantity : </label>
                    <input type='number' id='qty' value="1" />
                </div>
                <?php
                if (isset($_SESSION['user'])) {
                    if($result['stock'] > 0) { ?>
                        <button onclick="addShoppingCart('<?=$result['id']?>')" class="btn btn-dark">Add Shopping Cart</button>
                    <?php } else { ?>
                        <button class="btn btn-dark">Out of Stock</button>
                    <?php }
                } else {
                    echo '<button class="btn btn-dark">
                    You must be logged in to add the product to the cart.</button>';
                }
                    ?>
                
            </div>
        </div>
        
    </div>

<?php
require_once('./footer.php');
?>