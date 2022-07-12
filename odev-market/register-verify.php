<?php
require_once('./header.php');

if(!isset($_SESSION['register']) && !isset($_SESSION['register']['code'])){
    header('location: register.php');
}

if(isset($_POST['verify'])){
    if($_POST['code'] == $_SESSION['register']['code']){
        $query = $conn->prepare('INSERT INTO consumers (fullname, email, password, city, address, district) VALUES (?, ?, ?, ?, ?, ?)');
        $query->execute([$_SESSION['register']['fullname'], $_SESSION['register']['email'], md5($_SESSION['register']['password']), $_SESSION['register']['city'], $_SESSION['register']['address'], $_SESSION['register']['district']]);
        unset($_SESSION['register']);
        unset($_SESSION['register']['code']);
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