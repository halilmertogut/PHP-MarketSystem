<?php
require_once('./header.php');
    if (!isset($_SESSION['admin'])) {
        header('Location: ./login.php');
        exit;
    }
    $date = date('Y-m-d' , strtotime('+7 day'));
    $query = $conn->prepare('SELECT * FROM product WHERE expiration_date < ?');
    $query->execute([$date]);
    $result = $query->fetchAll();
?>

    <div class="container mt-5">
        <div class="row">
        <div class="mb-3">
            <h3>Products with an expiration date of less than 7 days</h3>
        </div>
        <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Normal Price</th>
                    <th scope="col">Discounted Price</th>
                    <th scope="col">Expiration Date</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($result as $key => $value) { ?>
                            <tr>
                                <td><?=++$key?></td>
                                <td><img width="100" src='../assets/img/<?=$value['image']?>' /></td>
                                <td><?=$value['title']?></td>
                                <td><?=$value['stock']?></td>
                                <td><?=number_format($value['normal_price'] , 2 , ',' , '.')?> ₺</td>
                                <td><?=number_format($value['discounted_price'] , 2 , ',' , '.')?> ₺</td>
                                <td><?=$value['expiration_date']?></td>
                                <td>
                                    <a class='btn btn-info' href="product-edit.php?id=<?=$value['id']?>">Edit</a>
                                    <a class='btn btn-danger' href="product-delete.php?id=<?=$value['id']?>">Delete</a> 
                                </td>
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