<style>.message{color:red}</style>
<?php
	require_once 'utils.php';	
	$errors = [];
	$alert = '';
	if(!isset($_POST['username']) || strlen($_POST['username']) > 45 || !preg_match('/^[a-zA-Z- ]+$/', $_POST['username'])) {
		$errors[] = 1;
		$alert = '<div class="alert-error" style="text-align:center;margin-top:50px">
                    <span class="message">Please enter a username no greater than 45 characters long.</span>
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
			//FIX THIS ISSUE ALSO IN REGISTRATION>PHP
			if($_POST['csrf_token'] == $_SESSION['csrf_token'])
			{
				$errors[] = "CSRF Token Validation Failure!";
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
				$errors[] = "CSRF Token Expired... :( Please reload the page.";
			}
		}
	}
				

			
	if(count($errors) == 0) {
		//if($_POST['csrf_token'] == $_SESSION['csrf_token']) {
		//CONNECT TO DATABASE
		$C = connect();
		if($C) {
			//CHECK IF USER ALREADY EXISTS
			$res = sqlSelect($C, 'SELECT id FROM professionals WHERE email=?', 's', $_POST['email']);
			if($res && $res->num_rows === 0) {
				//CREATE THE ACCOUNT
				$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
				//$id = sqlInsert($C, 'INSERT INTO professionals VALUES (NULL, ?, ?, ?, 0)', 'sss', $_POST['username'], $_POST['email'], $hash);
				$id = sqlInsert($C, 'INSERT INTO professionals VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 'ssssssssss', $_POST['username'], $_POST['category'], $_POST['number'], $hash, $_POST['email'], $_POST['addy1'], $_POST['addy2'], $_POST['post-code'], $_POST['state'], $_POST['business-desc']);
				if($id !== -1) {
					$errors[] = 0;
					header('location:professionalsLogin.php');
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
	//remove this line
	echo json_encode($errors);
			
	

?>
<html lang="en">
<head>
	<title>branzpir</title>
	<link rel='branzpir icon' href='branzpir_favicon.png' type='image/x-icon'>
	<meta charset="utf-8"/>
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
	.inpt{width:350px; height:40px}
</style>
<body>
<header class="w3-container w3-top w3-hide-small w3-highway-red w3-xlarge w3-padding">
    <b><span><a href='index.php' style='text-decoration:none'>branzpir</a></span></b>
</header>
<form id="registerForm" method='POST' action='' style="margin-top:80px">
    <table border='0' align='center' cellpadding='8'>
        <tr>
            <td align='right'>Business Name *:</td>
            <td><input class='inpt' type='text' placeholder="Enter Username" name='username' required/></td>
        </tr>
		<tr>
            <td align='right'>Professional Category *:</td>
            <td><input class='inpt' type='text' placeholder="e.g. Sign Printing" name='category' required/></td>
		</tr>
		<tr>
            <td align='right'>Phone Number *:</td>
            <td><input class='inpt' type='text' placeholder="For potential clients to reach you" name='number' required/></td>
		</tr>
        <tr>    
            <td align='right'>Password:</td>
            <td><input class='inpt' type='text' placeholder="Enter Password" name='password' required/></td>
        </tr>
        <tr>    
            <td align='right'>Confirm Password:</td>
            <td><input class='inpt' type='text' placeholder="Confirm Password" name='confirm-password' required/></td>
        </tr>
        <tr>
            <td align='right'>Email Address:</td>
            <td><input class='inpt' type='text' placeholder="Enter Email" name='email' required/></td>
        </tr>
		<tr>
            <td align='right'>Address Line 1 *:</td>
            <td><input class='inpt' type='text'  name='addy1' required/></td>
		</tr>
		<tr>
            <td align='right'>Address Line 2:</td>
            <td><input class='inpt' type='text' name='addy2'/></td>
		</tr>
		<tr>
            <td align='right'>Postcode *:</td>
            <td><input class='inpt' type='text' name='post-code' required/></td>
		</tr>
		<tr>
			<td align='right'>State *:</td>
			<td required>
				<select name="state">
					<option value="NULL">Select State</option>
					<option value="ACT">Australian Capital Territory</option>
					<option value="NSW">New South Wales</option>
					<option value="NT">Northern Territory</option>
					<option value="QLD">Queensland</option>
					<option value="SA">South Australia</option>
					<option value="TAS">Tasmania</option>
					<option value="VIC">Victoria</option>
					<option value="WA">Western Australia</option>
				</select>
			</td>
		</tr>
		<tr>
            <td align='right'>Business Description:</td>
            <td><textarea type='text' rows='3' cols='50' placeholder='Give a brief description of your business,services you offer etc. ' name='business-desc' required></textarea></td>
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
                <p><a href='professionalsLogin.php' style='text-decoration:none'>Already have an account? Click here to login.</a></p>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
