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
                <?php
                    if(isset($messages)){
                        echo $messages;
                    }
                ?>
                <form method="POST" action="">
                    <div class="row">
                        <div class="input-group mb-3">
                            <span class="input-group-text input-span" id="basic-addon1">Full Name</span>
                            <input required name="fullname" type="text" class="form-control" placeholder="Full Name" aria-label="Full Name" aria-describedby="basic-addon1" value="<?=$_SESSION['user']['fullname']?>">
                            
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text input-span" id="basic-addon1">Email</span>
                            <input required readonly name="email" type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" value="<?=$_SESSION['user']['email']?>">
                            
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text input-span" id="basic-addon1">Password</span>
                            <input name="password" type='text'  autocomplete="off" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                            
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text input-span" id="basic-addon1">City</span>
                            <input required name="city" type="text" class="form-control" placeholder="City" aria-label="City" aria-describedby="basic-addon1" value="<?=$_SESSION['user']['city']?>">
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text input-span" id="basic-addon1">District</span>
                            <input required name="district" type="text" class="form-control" placeholder="District" aria-label="District" aria-describedby="basic-addon1" value="<?=$_SESSION['user']['district']?>">
                            
                        </div>
                        <div class="form-floating">
                            <textarea required name="address" class="form-control" placeholder="Address" id="floatingTextarea2" style="height: 100px"><?=$_SESSION['user']['address']?></textarea>
                            <label for="floatingTextarea2">Address</label>
                        </div>
                        <div class="mt-5 text-end">
                            <button type="submit" name='update' class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>

<?php
require_once('./footer.php');
?>