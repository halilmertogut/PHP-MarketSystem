<?php
require_once('./header.php');

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $control = $conn->prepare('SELECT * FROM consumers WHERE email = ? AND password = ?');
    $control->execute([$email , $password]);
    $control_result = $control->fetchAll();
    if(count($control_result) > 0){
        $_SESSION['user'] = $control_result[0];
        $messages = '<div class="alert alert-success" role="alert">Login successful !</div>';
        header('location: ./profile.php');
    }else{
        $messages = '<div class="alert alert-danger" role="alert">Incorrect Email or Password, Try Again !</div>';
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
                    <span class="input-group-text input-span" id="basic-addon1">Email</span>
                    <input required name="email" type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">Password</span>
                    <input required name="password" type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                </div>
                <div class="mt-5 text-end">
                    <button type="submit" name='login' class="btn btn-success">Login</button>
                </div>
            </div>
       </form>
    </div>

<?php
require_once('./footer.php');
?>