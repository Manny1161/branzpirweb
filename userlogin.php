<style>.message{color:red}</style>
<?php
    require_once 'utils.php';
    $alert = '';
    $user = $_GET['uname'];

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
                        $res = sqlSelect($C, 'SELECT accounts.username,accounts.id,accounts.password,accounts.verified,COUNT(loginattempts.id) FROM accounts LEFT JOIN loginattempts ON accounts.id = user AND timestamp>? WHERE email=? GROUP BY accounts.id', 'is', $hourAgo, $email);
                        if($res && $res->num_rows == 1)
                        {
                            $user = $res->fetch_assoc();
                            if($user['COUNT(loginattempts.id)'] <= MAX_LOGIN_ATTEMPTS_PER_HOUR)
                            {
        
                                if(password_verify($password, $user['password']) && $user['verified']==1)
                                {
                                    $_SESSION['loggedin'] = true;
                                    $_SESSION['userID'] = $user['id'];
                                    $_SESSION['userName'] = $user['username'];
                                    sqlUpdate($C, 'DELETE FROM loginattempts WHERE user = ?', 'i', $user['id']);
                                    header('location:passwordreset.php');
                                }
                                else
                                {
                                    $id = sqlInsert($C, 'INSERT INTO loginattempts VALUES (NULL, ?, ?, ?)', 'isi', $user['id'], $_SERVER['REMOTE_ADDR'], time());
                                    if($id != -1)
                                    {
                                        $alert = '<div class="alert-error" style="text-align:center">
                                                    <span class="message">Incorrect Email or Password.</span>
                                                    </div>';
                                                    echo $alert;                                       
                                    }
                                    else
                                    {
                                        echo 2;
                                    }
                                }
                            }
                            else
                            {
                                $alert = '<div class="alert-error" style="text-align:center">
                                                    <span class="message">Max login attempts wait 30 minutes to login again.</span>
                                                    </div>';
                                                    echo $alert;
                            }
                        }
                        else
                        {
                            $alert = '<div class="alert-error" style="text-align:center">
                                        <span class="message">No account matches credentials entered.</span>
                                        </div>';
                                        echo $alert;
                        }
                        $res->free_result();
                    }
                    else
                    {
                        $alert = '<div class="alert-error" style="text-align:center">
                        <span class="message">Failed to connect to database.</span>
                        </div>';
                        echo $alert;
                    }
                    $C->close();
                }
                else
                {
                    $alert = '<div class="alert-error" style="text-align:center">
                                <span class="message">Please enter email and password to login.</span>
                                </div>';
                                echo $alert;
                }
            }
            else
            {
                    unset($_SESSION['csrf_token']);
                    unset($_SESSION['csrf_token_time']);
                    $alert = '<div class="alert-error" style="text-align:center">
                                <span class="message">Please reload the page to resubmit this form.</span>
                                </div>';
                                echo $alert;
            }
        }
    }
    $token = md5(uniqid(rand(), true));
	$_SESSION['csrf_token'] = $token;
	$_SESSION['csrf_token_time'] = time();
        
?>
<html lang="en">
<head>
    <title>Branzpir</title>
    <link rel='branzpir icon' href='branzpir_favicon.png' type='image/x-icon'>
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
    table{margin:0 auto;}
</style>
<body>
<header class="w3-container w3-top w3-hide-small w3-highway-red w3-xlarge w3-padding">
    <b><span><a href='index.php' style='color:#ffffff'>branzpir</a></span></b>
</header>

<div class="container">
    
    <form class="row g-3" method="POST" style="margin-top:80px">
    <p style="color:red">For your security, please sign-in again.</p>
        <div class="col-12">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name='email' placeholder="Enter Email">
        </div>
        <div class="col-12">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name='password' placeholder="Enter Password">
        </div>
        <div class="col-12">
            <br>
            <button type="submit" class="btn btn-danger" name='submit'>Sign In</button>
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
        </div>
    </form>
</div>


</body>
</html>