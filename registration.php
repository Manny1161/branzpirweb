<?php
	
	require_once 'utils.php';
		
	$errors = [];

	if(isset($_POST) & !empty($_POST))
	{
		if(isset($_POST['csrf_token']))
		{
			if($_POST['csrf_token'] == $_SESSION['csrf_token'])
			{
				$errors[] = "CSRF Token Validation Success!";
			}
			else
			{
				$errors[] = "Problem with CSRF Token Validation!";
			}
		}
		$max_time = 60*60*24;
		if(isset($_SESSION['csrf_token_time']))
		{
			$token_time = $_SESSION['csrf_token_time'];
			if($token_time + $max_time >= time())
			{	
				if(!isset($_POST['username']) || strlen($_POST['username']) > 45 || !preg_match('/^[a-zA-Z- ]+$/', $_POST['username'])) {
					$errors[] = 1;
				}
				if(!isset($_POST['email']) || strlen($_POST['email']) > 45 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
					$errors[] = 2;
				}
				else if(!checkdnsrr(substr($_POST['email'], strpos($_POST['email'], '@') + 1), 'MX')) {
					$errors[] = 3;
				}
				if(!isset($_POST['password']) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $_POST['password'])) {
					$errors[] = 4;
				}
				else if(!isset($_POST['confirm-password']) || $_POST['confirm-password'] !== $_POST['password']) {
					$errors[] = 5;
				}
			
				//if($errors == 0) {
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
		
			echo json_encode($errors);
			}
			else
			{
				unset($_SESSION['csrf_token']);
				unset($_SESSION['csrf_token_time']);
				$errors[] = "CSRF Token Expired... :( Please reload the page.";
			}
		}
	}
	$token = md5(uniqid(rand(), true));
	$_SESSION['csrf_token'] = $token;
	$_SESSION['csrf_token_time'] = time();

?>
<html>
<head>
<meta charset="utf-8"/>
</head>
<body>
<form id="registerForm" method='POST' action=''>
    <table border='0' align='center' cellpadding='5'>
        <tr>
            <td align='right'>Username:</td>
            <td><input type='text' name='username' required/></td>
        </tr>
        <tr>    
            <td align='right'>Password:</td>
            <td><input type='text' name='password' required/></td>
        </tr>
        <tr>    
            <td align='right'>Confirm Password:</td>
            <td><input type='text' name='confirm-password' required/></td>
        </tr>
        <tr>
            <td align='right'>Email Address:</td>
            <td><input type='text' name='email' required/></td>
        </tr>
        <tr>
            <td colspan='2' align='center'><input type='SUBMIT' name='submit' value='Register' required/></td>
			<td><input type="hidden" name="csrf_token" value="<?php echo $token; ?>"></td>
        </tr>
    </table>
</form>
<center>
</center>
</body>
</html>
