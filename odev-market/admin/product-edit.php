<?php
require_once('./header.php');
if (!isset($_SESSION['admin'])) {
    header('Location: ./login.php');
    exit;
}
$control = $conn->prepare('SELECT * FROM product WHERE id = ?');
$control->execute([$_GET['id']]);
$result = $control->fetchAll()[0];

if(isset($_POST['save'])){
    $title = $_POST['title'];
    $stock = $_POST['stock'];
    $normal_price = $_POST['normal_price'];
    $discounted_price = $_POST['discounted_price'];
    $expiration_date = $_POST['expiration_date'];

    if($_FILES['image']['error'] == 0){
        $image = time().'_'.$_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_move = move_uploaded_file($image_tmp, '../assets/img/'.$image);
        if($image_move){
            $update = $conn->prepare('UPDATE product SET title=? , stock=? , normal_price=? , discounted_price=? , expiration_date=? , image=? WHERE id=?');
            $update->execute([
                $title,
                $stock,
                $normal_price,
                $discounted_price,
                $expiration_date,
                $image,
                $_GET['id']
            ]);
            if($update){
                $control = $conn->prepare('SELECT * FROM product WHERE id = ?');
                $control->execute([$_GET['id']]);
                $result = $control->fetchAll()[0];
                $messages = '<div class="alert alert-success" role="alert">Update product completed successfully</div>';
            }else{
                $messages = '<div class="alert alert-danger" role="alert">An error occurred while update a product !</div>';
            }
        }
    }else{
        $update = $conn->prepare('UPDATE product SET title=? , stock=? , normal_price=? , discounted_price=? , expiration_date=? WHERE id=?');
            $update->execute([
                $title,
                $stock,
                $normal_price,
                $discounted_price,
                $expiration_date,
                $_GET['id']
            ]);
            if($update){
                $control = $conn->prepare('SELECT * FROM product WHERE id = ?');
                $control->execute([$_GET['id']]);
                $result = $control->fetchAll()[0];
                $messages = '<div class="alert alert-success" role="alert">Update product completed successfully</div>';
            }else{
                $messages = '<div class="alert alert-danger" role="alert">An error occurred while update a product !</div>';
            }
    }
}
?>

    <div class="container mt-5">
        <?php
            if(isset($messages)){
                echo $messages;
            }
        ?>
       <form method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">Title</span>
                    <input required name="title" type="text" class="form-control" placeholder="Title" aria-label="Title" aria-describedby="basic-addon1" value="<?=$result['title']?>">
                    
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">Stock</span>
                    <input required name="stock" type="number" class="form-control" placeholder="Stock" aria-label="Stock" aria-describedby="basic-addon1" value="<?=$result['stock']?>">
                    
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">Normal Price</span>
                    <input required name="normal_price" type="text" class="form-control" placeholder="Normal Price" aria-label="PasNormal Pricesword" aria-describedby="basic-addon1" value="<?=$result['normal_price']?>">
                    
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">Discounted Price</span>
                    <input required name="discounted_price" type="text" class="form-control" placeholder="Discounted Price" aria-label="Discounted Price" aria-describedby="basic-addon1" value="<?=$result['discounted_price']?>">
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">Expiration Date</span>
                    <input required name="expiration_date" type="date" class="form-control" placeholder="Expiration Date" aria-label="Expiration Date" aria-describedby="basic-addon1" value="<?=$result['expiration_date']?>">
                </div>
                <img width="100" class='mb-3' src='../assets/img/<?=$result['image']?>' />
                
                <div class="input-group mb-3">
                    
                    <span class="input-group-text input-span" id="basic-addon1">Image</span>
                    <input name="image" type="file" class="form-control" placeholder="Image" aria-label="Image" aria-describedby="basic-addon1">
                </div>
                <div class="mt-5 text-end">
                    <button type="submit" name='save' class="btn btn-success">Update Product</button>
                </div>
            </div>
       </form>
    </div>

<?php
require_once('./footer.php');
?>