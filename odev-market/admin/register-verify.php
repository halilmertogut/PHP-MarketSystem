<?php
require_once('./header.php');

if(!isset($_SESSION['register_market']) && !isset($_SESSION['register_market']['code'])){
    header('location: register.php');
}

if(isset($_POST['verify'])){
    if($_POST['code'] == $_SESSION['register_market']['code']){
        $query = $conn->prepare('INSERT INTO market_users (name, email, password, city, address, district) VALUES (?, ?, ?, ?, ?, ?)');
        $query->execute([$_SESSION['register_market']['fullname'], $_SESSION['register_market']['email'], md5($_SESSION['register_market']['password']), $_SESSION['register_market']['city'], $_SESSION['register_market']['address'], $_SESSION['register_market']['district']]);
        unset($_SESSION['register_market']);
        unset($_SESSION['register_market']['code']);
        $messages = '<div class="alert alert-success" role="alert">Registration completed successfully !</div>';
    }else{
        $messages = '<div class="alert alert-danger" role="alert">Verification code is wrong !</div>';
    }
}

?>

    <div class="container mt-5">
        <?php
            if(isset($messages)){
                echo $messages;
            }
        ?>
       <form method="POST" action="">
            <div class="row">
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">Verify Code</span>
                    <input required name="code" type="text" class="form-control" placeholder="Verify Code" aria-label="Verify Code" aria-describedby="basic-addon1">
                    
                </div>
               
                <div class="mt-5 text-end">
                    <button type="submit" name='verify' class="btn btn-success">Register</button>
                </div>
            </div>
       </form>
    </div>

<?php
require_once('./footer.php');
?>