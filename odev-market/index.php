<?php
require_once('./header.php');
if (isset($_GET['search'])) {
    $query = $conn->prepare('SELECT * FROM product WHERE expiration_date > ? AND title LIKE ?');
    $query->execute([date('Y-m-d') , '%' . $_GET['search'] . '%']);
    $result = $query->fetchAll();
}else{
    $query = $conn->prepare('SELECT * FROM product WHERE expiration_date > ?');
    $query->execute([date('Y-m-d')]);
    $result = $query->fetchAll();
}
?>

    <div class="container mt-5">
        <div class="row">
            <?php
                foreach ($result as $key => $value) { ?>
                <div class="card col-lg-3 col-md-4 col-sm-6 col-xs-12 p-2 mb-2">
                    <img src="./assets/img/<?=$value['image']?>" class="card-img-top product-image" alt="<?=$value['title']?>">
                    <div class="card-body">
                        <h5 class="card-title"><?=$value['title']?></h5>
                        <p class="card-text">
                            <span class="normal-price"><?=$value['discounted_price']?> ₺</span>
                            <span class="discounted-price"><?=$value['normal_price']?> ₺</span>
                        </p>
                        <a href="product-detail.php?id=<?=$value['id']?>" class="btn btn-primary">Go Detail</a>
                    </div>
                </div>        
            <?php   
             }
            ?>
        </div>
        
    </div>

<?php
require_once('./footer.php');
?>