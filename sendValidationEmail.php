<?php
    require_once 'utils.php';

    use PHPMailer\PHPMailer\PHPMailer;

    require_once 'PHPMailer-master/src/Exception.php';
    require_once 'PHPMailer-master/src/PHPMailer.php';
    require_once 'PHPMailer-master/src/SMTP.php';

    $mail = new PHPMailer(true);

    $alert = '';

    if(isset($_POST['submit'])){
        $secret = "35onoi2=-7#%g03kl";
    $Email = urlencode($_POST['email']);
    $hash = MD5($_POST['email'].$secret);
    $link = "localhost/login.php?email=$Email&hash=$hash";
    $email = $_POST['email'];
    $message = '<a href="localhost/login.php">Click this link to verify your account</a>';

    try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'emmanuelkapela2@gmail.com'; // Gmail address which you want to use as SMTP server
        $mail->Password = 'OutrunOdin65'; // Gmail address Password
        $mail->SMTPSecure = "ssl";
        $mail->Port = '465';

        $mail->setFrom('emmanuelkapela2@gmail.com'); // Gmail address which you used as SMTP server
        $mail->addAddress($email); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
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
    

    /*function sendValidationEmail($email)
    {
        $C = connect();
        if($C)
        {
            $oneDay = time() - 60 * 60 * 24;
            $res = sqlSelect($C, 'SELECT accounts.id, username, verified, COUNT(requests.id) FROM accounts LEFT JOIN requests ON accounts.id = requests.user AND type=0 AND timestamp>? WHERE email=? GROUP BY accounts.id', 'is', $oneDay, $email);
            if($res && $res->num_rows == 1)
            {
                $user = $res->fetch_assoc();
                if($user['verified'] == 0)
                {
                    if($user['COUNT(requests.id)'] <=MAX_EMAIL_VERIFICATION_REQUESTS_PER_DAY)
                    {
                        $verifyCode = random_bytes(32);
                        $hash = password_hash($verifyCode, PASSWORD_DEFAULT);
                        $requestID = sqlInsert($C, 'INSERT INTO requests VALUES (NULL, ?, ?, ?, 0)', 'isi', $user['id'], $hash, time());
                        if($requestID != -1)
                        {
                            if(sendEmail($email, $user['username'], 'Email Verification', '<a href="' . VALIDATE_EMAIL_ENDPOINT . '/' . $requestID . '/' . urlSafeEncode($verifyCode). '" />Click this link to verify your email</a>'))
                            {
                               return 0; 
                            }
                            else
                            {
                                //FAILED TO SEND EMAIL
                                return 1;
                            }
                        }
                        else
                        {
                            //FAILED TO INSERT REQUEST
                            return 2;
                        }
                    }
                    else {
                        return 3;
                    }
                    
                }
                else
                {
                    return 4;
                }
                $res->free_result();
                    
            }
            else
            {
                return 5;
            }
            $C->close();
        }
        else
        {
            echo "Failed to connect to database";
        }
        return -1;
    }*/
?>