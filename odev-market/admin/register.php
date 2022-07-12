<?php
require_once('./header.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../assets/plugin/PHPMailer.php';
require '../assets/plugin/SMTP.php';
require '../assets/plugin/Exception.php';

if(isset($_POST['register'])){
    $email = $_POST['email'];
    $control = $conn->prepare('SELECT * FROM market_users WHERE email = ?');
    $control->execute([$email]);
    $control_result = $control->fetchAll();
    if(count($control_result) > 0){
        $messages = '<div class="alert alert-danger" role="alert">Email already exist !</div>';
    }else{

        $rand = rand(100000, 999999);
        $_SESSION['register_market'] = $_POST;
        $_SESSION['register_market']['code'] = $rand;
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'odev.proje.2022@gmail.com';
        $mail->Password = 'odev1234';
        $mail->SetFrom($mail->Username, 'Market Place');
        $mail->AddAddress($_POST['email'], $_POST['fullname']);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Email Verification';
        $content = '<div style="background: #eee; padding: 10px; font-size: 21px">Verification Code : '.$rand.'</div>';
        $mail->MsgHTML($content);
        if($mail->Send()) {
            header('location: register-verify.php');
        } else {
            $messages = '<div class="alert alert-danger" role="alert">An error occurred while sending the email, please try again. !</div>';
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
       <form method="POST" action="">
            <div class="row">
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">Full Name</span>
                    <input required name="fullname" type="text" class="form-control" placeholder="Full Name" aria-label="Full Name" aria-describedby="basic-addon1">
                    
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">Email</span>
                    <input required name="email" type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
                    
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">Password</span>
                    <input required name="password" type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                    
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">City</span>
                    <input required name="city" type="text" class="form-control" placeholder="City" aria-label="City" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text input-span" id="basic-addon1">District</span>
                    <input required name="district" type="text" class="form-control" placeholder="District" aria-label="District" aria-describedby="basic-addon1">
                    
                </div>
                <div class="form-floating">
                    <textarea required name="address" class="form-control" placeholder="Address" id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Address</label>
                </div>
                <div class="mt-5 text-end">
                    <button type="submit" name='register' class="btn btn-success">Register</button>
                </div>
            </div>
       </form>
    </div>

<?php
require_once('./footer.php');
?>