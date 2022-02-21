<?php
	
	require_once 'utils.php';
		
	$errors = [];
		
	if(!isset($_POST['username']) || strlen($_POST['username']) > 45 || !preg_match('/^[a-zA-Z- ]+$/', $_POST['username'])) {
		$errors[] = 1;
		echo "1";
	}
	if(!isset($_POST['email']) || strlen($_POST['email']) > 45 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errors[] = 2;
		echo "2";
	}
	else if(!checkdnsrr(substr($_POST['email'], strpos($_POST['email'], '@') + 1), 'MX')) {
		$errors[] = 3;
		echo "3";
	}
	if(!isset($_POST['password']) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $_POST['password'])) {
		$errors[] = 4;
		echo "4";
	}
	else if(!isset($_POST['confirm-password']) || $_POST['confirm-password'] !== $_POST['password']) {
		$errors[] = 5;
		echo "5";
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
			if(($token_time + $max_time) >= time())
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
				$id = sqlInsert($C, 'INSERT INTO accounts VALUES (NULL, ?, ?, ?, 0)', 'sss', $_POST['username'], $_POST['email'], $hash);
				if($id !== -1) {
					$errors[] = 0;
					header('location:login.php');
				}
				else {
					//FAILED TO INSERT INTO DATABASE
					$errors[] = 6;
				}
				$res->free_result();
			}
			else {
				//EMAIL ALREADY EXISTS
				$errors[] = 7;
			}
		}
		else {
			//FAILED TO CONNECT TO DATABASE
			$errors[] = 8;
		}
	}		
	echo json_encode($errors);
			

?>
<html lang="en">
<head>
	<title>branzpir</title>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    body {font-size:16px;}
    .w3-half img{margin-bottom:-6px;margin-top:16px;opactiy:0.8;cursor:pointer}
    .w3-half img:hover{opacity:1}
</style>
<body>
<header class="w3-container w3-top w3-hide-small w3-highway-red w3-xlarge w3-padding">
    <b><span><a href='index.php' style='text-decoration:none'>branzpir</a></span></b>
</header>
<form id="registerForm" method='POST' action='' style="margin-top:80px">
    <table border='0' align='center' cellpadding='8'>
        <tr>
            <td align='right'>Username:</td>
            <td><input type='text' placeholder="Enter Username" name='username' required/></td>
        </tr>
        <tr>    
            <td align='right'>Password:</td>
            <td><input type='text' placeholder="Enter Password" name='password' required/></td>
        </tr>
        <tr>    
            <td align='right'>Confirm Password:</td>
            <td><input type='text' placeholder="Confirm Password" name='confirm-password' required/></td>
        </tr>
        <tr>
            <td align='right'>Email Address:</td>
            <td><input type='text' placeholder="Enter Email" name='email' required/></td>
        </tr>
        <tr>
            <td colspan='2' align='center'><input type='SUBMIT' name='submit' value='Register' required/></td>
			<td><input type="hidden" name="csrf_token" value="<?php echo $token; ?>"></td>
        </tr>
    </table>
</form>

<form id='oldAccount' method='POST' action='' style='margin-top:80px'>
    <table border='0' align='center' cellpadding='8'>
        <tr>
            <td align='center'>
                <p><a href='login.php' style='text-decoration:none'>Already have an account? Click here to login.</a></p>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
