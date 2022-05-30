<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once 'PHPMailer-master/src/Exception.php';
require_once 'PHPMailer-master/src/PHPMailer.php';
require_once 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

$alert = '';

if(isset($_POST['submit'])){
  $email = $_POST['userEmail'];
  $message = $_POST['contactForm'];

  try{
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'emmanuelkapela2@gmail.com'; // Gmail address which you want to use as SMTP server
    $mail->Password = 'OutrunOdin65'; // Gmail address Password
    $mail->SMTPSecure = "ssl";
    $mail->Port = '465';

    $mail->setFrom($email); // Gmail address which you used as SMTP server
    $mail->addAddress('emmanuelkapela2@gmail.com'); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

    $mail->isHTML(true);
    $mail->Subject = 'Message Received (Contact Page)';
    $mail->Body = "<h3>Email: $email <br>Message : $message</h3>";

    $mail->send();
    $alert = '<div class="alert-success" style="text-align:center">
                 <span>Message Sent! Thank you for contacting us.</span>
                </div>';
  } catch (Exception $e){
    $alert = '<div class="alert-error" style="text-align:center">
                <span>'.$e->getMessage().'</span>
              </div>';
  }
}
?>
      