<?php
	require_once 'utils.php';
		
	$errors = [];

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

	if(count($errors) === 0) {
		//if(isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
	//CONNECT TO DATABASE
	$C = connect();
	if($C) {
				
		//CHECK IF USER ALREADY EXISTS
		$res = sqlSelect($C, 'SELECT id FROM accounts WHERE email=?', 's', $_POST['email']);
		if($res && $res->num_rows === 0) {
			//CREATE THE ACCOUNT
			$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$id = sqlInsert($C, 'INSERT INTO accounts VALUES (NULL, ?, ?, ?, 0)', 'sss', $_POST['username'], $_POST['email'], '$hash');
			if($id !== -1) {
				$errors[] = 0;
			}
			else {
				//FAILED TO INSERT INTO DATABASE
				$errors[] = 6;
			}
			//$res->free_result();
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
			
		/*}
		else {
			//Invalid CSRF Token
			$errors[] = 9;
		}*/
	}

	echo json_encode($errors);


/*if(isset( ||$_POST['submit']))
{
    //GET FORM DATA
    $usr = $_POST['usr'];
    $pwd = $_POST['pwd'];
    $rpwd = $_POST['rpwd'];
    $eml = $_POST['eml'];

    if(strlen($usr) < 5)
    {
        $err = 'Your username must be atleast 5 characters long';
    }
    elseif($rpwd != $pwd)
    {
        $err .= 'Your passwords do not match';
    }
    else
    {
        //FORM IS VALID

        //CONNECT TO DATABASE
        $mysqli = NEW MySQLi('localhost','root','','branzpir');

        //SANITISE FORM DATA
        $usr = $mysqli->real_escape_string($usr);
        $pwd = $mysqli->real_escape_string($pwd);
        $rpwd = $mysqli->real_escape_string($rpwd);
        $eml = $mysqli->real_escape_string($eml);

        //GENERATE VKEY
        $vkey = password_hash(time().$usr, PASSWORD_DEFAULT);
        
        //INSERT ACCOUNT INTO DATABASE
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $insert = $mysqli->query("INSERT INTO accounts(username, password, email, vkey)
        VALUES('$usr', '$pwd', '$eml', '$vkey')");

        if ($insert)
        {
            //SEND EMAIL
            $to = $eml;
            $subject = 'Email Verification';
            $message = "<a href='http://localhost/registration/verify.php?vkey=$vkey'>Register Account</a>";
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8 \r\n";
            $headers .= 'From: emmanuel.k@eurotech.com.au' . "\r\n";

            ini_set('SMTP', "smtp-relay.sendinblue.com");
            ini_set('smtp_port', "587");
            ini_set('username', "emmanuel.k@eurotech.com.au");
            ini_set('password', "Vap91509");
            ini_set('sendmail_from', "emmanuel.k@eurotech.com.au");
            
            mail($to,$subject,$message,$headers);
            //header('location:thankyou.php');
        }
        else
        {
            echo $mysqli->error;
        }

    }
}*/
?>
<html>
<head>
<meta name="csrf_token" content="<?php echo createToken(); ?>" />
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
        </tr>
    </table>
</form>
<center>
<?php
$err = NULL;
?>
</center>
</body>
</html>
