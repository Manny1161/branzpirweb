<style>.message{color:red}</style>
<?php
	
	require_once 'utils.php';

    use PHPMailer\PHPMailer\PHPMailer;

    require_once 'PHPMailer-master/src/Exception.php';
    require_once 'PHPMailer-master/src/PHPMailer.php';
    require_once 'PHPMailer-master/src/SMTP.php';

    $mail = new PHPMailer(true);

    $alert = '';
		
	$errors = [];
		
	if(!isset($_POST['username']) || strlen($_POST['username']) > 45 || !preg_match('/^[a-zA-Z- ]+$/', $_POST['username'])) {
		$errors[] = 1;
		$alert = '<div class="alert-error" style="text-align:center;margin-top:50px">
                    <span class="message">Please enter a username with atleast one capital letter and no greater than 45 characters long.</span>
                    </div>';
                    echo $alert;
	}
	if(!isset($_POST['email']) || strlen($_POST['email']) > 45 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errors[] = 2;
		$alert = '<div class="alert-error" style="text-align:center;margin-top:50px">
                    <span class="message">Invalid email entered.</span>
                    </div>';
                    echo $alert;
	}
	else if(!checkdnsrr(substr($_POST['email'], strpos($_POST['email'], '@') + 1), 'MX')) {
		$errors[] = 3;
		$alert = '<div class="alert-error" style="text-align:center;margin-top:50px">
                    <span class="message">Invalid email entered.</span>
                    </div>';
                    echo $alert;
	}
	if(!isset($_POST['password']) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $_POST['password'])) {
		$errors[] = 4;
		$alert = '<div class="alert-error" style="text-align:center;margin-top:50px">
                    <span class="message">Password must contain one uppercase letter, 1 lowercase letter, contain atleast one number, have atleast one special character [@#$!\~?%] and be atleast 8 characters long.</span>
                    </div>';
                    echo $alert;
	}
	else if(!isset($_POST['confirm-password']) || $_POST['confirm-password'] !== $_POST['password']) {
		$errors[] = 5;
		$alert = '<div class="alert-error" style="text-align:center;margin-top:50px">
                    <span class="message">Passwords do not match.</span>
                    </div>';
                    echo $alert;
	}
	$token = md5(uniqid(rand(), true));
	$_SESSION['csrf_token'] = $token;
	$_SESSION['csrf_token_time'] = time();
	if(isset($_POST) & !empty($_POST))
	{
		if(isset($_POST['csrf_token']))
		{
			if($_POST['csrf_token'] == $_SESSION['csrf_token'])
			{
				$errors[] = "9";
			}
		}
		$max_time = 60*60*24;
		if(isset($_SESSION['csrf_token_time']))
		{
			$token_time = $_SESSION['csrf_token_time'];
			if($token_time + $max_time >= time())
			{}
			else
			{
				unset($_SESSION['csrf_token']);
				unset($_SESSION['csrf_token_time']);
				$errors[] = "11";
			}
		}
	}
	
	if(count($errors) == 0) {
		//if($_POST['csrf_token'] == $_SESSION['csrf_token']) {
		//CONNECT TO DATABASE
		$C = connect();
		if($C) {
			//CHECK IF USER ALREADY EXISTS
			$res = sqlSelect($C, 'SELECT id FROM accounts WHERE email=?', 's', $_POST['email']);
			if($res && $res->num_rows === 0) {
				//CREATE THE ACCOUNT
				$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$vkey = md5(time().$_POST['username']);
				$id = sqlInsert($C, 'INSERT INTO accounts VALUES (NULL, ?, ?, ?, ?, 0)', 'ssss', $_POST['username'], $_POST['email'], $hash, $vkey);
				if($id != -1) {
					/*$err = sendValidationEmail($_POST['email']);*/
					if($err == 0)
					{
						$errors[] = 0;
						
						$vkey = md5(time().$_POST['username']);
						$email = $_POST['email'];
						$message = "<a href='localhost/verify.php?vkey=$vkey'>Click this link to verify your account</a>";

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
						
						header('location:thankyou.php');
					}
					else
					{
						$errors[] = 20;
						$alert = '<div class="alert-error" style="text-align:center;margin-top:50px">
                                    <span class="message">Unresolved error, contact us for support.</span>
                                    </div>';
                                    echo $alert;
					}
				}
				else {
					//FAILED TO INSERT INTO DATABASE
					$errors[] = 6;
					$alert = '<div class="alert-error" style="text-align:center;margin-top:50px">
                                <span class="message">Incorrect Email or Password.</span>
                                </div>';
                                echo $alert;
				}
				$res->free_result();
			}
			else {
				//EMAIL ALREADY EXISTS
				$errors[] = 7;
				$alert = '<div class="alert-error" style="text-align:center;margin-top:50px">
                            <span class="message">Email already exists try logging in instead.</span>
                            </div>';
                            echo $alert;
			}
		}
		else {
			//FAILED TO CONNECT TO DATABASE
			$errors[] = 8;
			$alert = '<div class="alert-error" style="text-align:center;margin-top:50px">
                        <span class="message">Failed to connect to database.</span>
                        </div>';
                        echo $alert;
		}
	}		
	//echo json_encode($errors);
			

?>
<html lang="en">
<head>
	<title>branzpir</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    body {font-size:16px;}
    .w3-half img{margin-bottom:-6px;margin-top:16px;opactiy:0.8;cursor:pointer}
    .w3-half img:hover{opacity:1}
</style>
<body>
<header class="w3-container w3-top w3-hide-small w3-highway-red w3-xlarge w3-padding">
    <b><span><a href='index.php' style='color:#ffffff'>branzpir</a></span></b>
</header>

<div class="container">
<form class="row g-3" method="POST" enctype='multipart/form-data' style='margin-top:80px'>
  <div class="col-md-6">
    <label class="form-label">Username</label>
    <input type="text" class="form-control" name='username' placeholder="Enter Username">
  </div>
  <div class="col-md-6">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" name='email' placeholder="Enter Email">
  </div>
  <div class="col-md-6">
    <label class="form-label">Password</label>
    <input type="password" class="form-control" name='password' placeholder="Enter Password">
  </div>
  <div class="col-md-6">
    <label class="form-label">Confirm Password</label>
    <input type="password" class="form-control" name='confirm-password' placeholder="Confirm Password">
  </div>
  <div class="col-12">
	<br>
    <button type="submit" class="btn btn-danger" name='submit'>Register</button>
	<input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
  </div>
</form>
</div>

<form id='oldAccount' method='POST' action='' style='margin-top:80px'>
    <table border='0' align='center' cellpadding='8'>
        <tr>
            <td align='center'>
                <p><a href='login.php' style='color:#000000'>Already have an account? Click here to login.</a></p>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
