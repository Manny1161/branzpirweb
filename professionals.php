<?php
    require_once 'utils.php';

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
                if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $C = connect();
                    if($C)
                    {
                        $hourAgo = time() - 60*60;
                        $res = sqlSelect($C, 'SELECT accounts.id,accounts.password,COUNT(loginattempts.id) FROM accounts LEFT JOIN loginattempts ON accounts.id = user AND timestamp>? WHERE email=? GROUP BY accounts.id', 'is', $hourAgo, $email);
                        if($res && $res->num_rows == 1)
                        {
                            $user = $res->fetch_assoc();
                            //if($user['verified'])
                            if($user['COUNT(loginattempts.id)'] <= MAX_LOGIN_ATTEMPTS_PER_HOUR)
                            {
                                if(password_verify($password, $user['password']))
                                {
                                    $_SESSION['loggedin'] = true;
                                    $_SESSION['userID'] = $user['id'];
                                    sqlUpdate($C, 'DELETE FROM loginattempts WHERE user = ?', 'i', $user['id']);
                                    header('location:index.php');
                                }
                                else
                                {
                                    $id = sqlInsert($C, 'INSERT INTO loginattempts VALUES (NULL, ?, ?, ?)', 'isi', $user['id'], $_SERVER['REMOTE_ADDR'], time());
                                    if($id != -1)
                                    {
                                        echo 1;
                                    }
                                    else
                                    {
                                        echo 2;
                                    }
                                }

                            }
                            else
                            {
                                echo 3;
                            }
                        }
                        else
                        {
                            echo 4;
                        }
                        $res->free_result();
                    }
                    else
                    {
                        echo 1;
                    }
                    $C->close();
                }
                else
                {
                    echo 2;
                }
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
<html lang="en">
<head>
<title>branzpir</title>
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
    table{margin:0 auto;}
</style>
<body>
<header class="w3-container w3-top w3-hide-small w3-highway-red w3-xlarge w3-padding">
    <b><span><a href='index.php' style='text-decoration:none'>branzpir</a></span></b>
</header>

<form id="loginForm" method='POST' action='' style="margin-top:80px">
    <table border='0' align='center' cellpadding='8'>
        <tr>
            <td align='right'>Email:</td>
            <td><input type='text' placeholder="Enter Email" name='email' style="width:250px;" required/></td>
        </tr>
        <tr>    
            <td align='right'>Password:</td>
            <td><input type='text' placeholder="Enter Password" name='password' style='width:250px;' required/></td>
        </tr>
        <tr>
            <td colspan='2' align='center'><input type='SUBMIT' name='submit' value='Login' required/></td>
            <td><input type="hidden" name="csrf_token" value="<?php echo $token; ?>"></td>
        </tr>
        <!--<tr>
            <td align='center'><p><a href='registration.php'>Don't have an account? Click here to register.</a></p></td>
        </tr>-->
    </table>
</form>

<form id='newAccount' method='POST' action='' style='margin-top:100px'>
    <table border='0' align='center' cellpadding='8'>
        <tr>
            <td align='center'>
                <p><a href='registration.php' style='text-decoration:none'>Don't have an account? Click here to register.</a></p>
            </td>
        </tr>
    </table>
</form>
</body>
</html>

<!--DOCTYPE html>
<html>
<title>branzpir</title>    
<head>   
</head>
<body>
    <p>Click on the 'Choose File' button to upload a file:</p>
    <form>
        <input type='file' id='myFile' name='filename'>
        <input type='submit'>
    </form>    
</body>
</html-->
