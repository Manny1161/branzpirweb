<?php
    require_once 'utils.php';
    $C = connect();
    $name = 'branzpir';
    $name1 = 'Digital Impressions';
    $name2 = 'MK Designs';
    // FIX THIS
    $desc = sqlSelect($C, 'SELECT description FROM professionals WHERE username=?','s', $name);
    $desc1 = sqlSelect($C, 'SELECT description FROM professionals WHERE username=?','s', $name1);
    $desc2 = sqlSelect($C, 'SELECT description FROM professionals WHERE username=?','s', $name2);
    if($desc->num_rows==1 || $desc1->num_rows==1 || $desc2->num_rows==1) 
    {
        $q = $desc->fetch_assoc();
        $_SESSION['profDesc'] = $q['description'];

        $q1 = $desc1->fetch_assoc();
        $_SESSION['profDesc1'] = $q1['description'];

        $q2 = $desc2->fetch_assoc();
        $_SESSION['profDesc2'] = $q2['description'];
    }

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
                        $res = sqlSelect($C, 'SELECT professionals.id,professionals.password,COUNT(loginattempts.id) FROM professionals LEFT JOIN loginattempts ON professionals.id = user AND timestamp>? WHERE email=? GROUP BY professionals.id', 'is', $hourAgo, $email);
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
    <link rel='branzpir icon' href='branzpir_favicon.png' type='image/x-icon'>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"-->
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
    
    .br-img{width:342; height:192; padding:5px}
    .br-img-txt {display:inline-block;vertical-align:top}
    .br-img-desc{display:inline;vertical-align:top}
    .box{display:flex; align-items:flex-start}
</style>
<body>
<nav class="w3-sidebar w3-highway-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
    <div class="w3-container">
        <h3 class="w3-padding-64"><b><br>branzpir</b></h3>
    </div>
    <div class="w3-bar-block">
        <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a>
        <a href='showcase.php' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Showcase</a>
        <a href="services.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Services</a>
        <a href="professionals.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Professionals</a> 
        <a href="contact.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Contact</a>
        <a href="youandbranzpir.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">You and Branzpir</a>
    </div>
</nav>

<!--- TOP MENU ON SMALL SCREENS -->
<header class="w3-container w3-top w3-hide-large w3-highway-red w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-highway-red w3-margin-right" onclick="w3_open()">☰</a>
</header>

<!--- OVERLAY EFFECT WHEN OPENING SIDEBAR ON SMALL SCREENS -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!---main-content--->
<h2 style="text-align:center; margin-top:70px">Find the right pro for your project</h2>

<div class="w3-main" style="margin-left:340px;margin-right:40px">
    <div class="box">
        <img class="br-img" src="uploads/large-lightbox-signage-commercial.jpeg">
        <span><b>branzpir</b><br><q><?php echo $_SESSION['profDesc']?></q></span>
    </div>
    <div class="box">
    <img class="br-img" src="uploads/visirite-function-sign-outdoor-aluminium.jpg">
        <span><b>Digital Impressions</b><br><q><?php echo $_SESSION['profDesc1']?></q></span>
    </div>
    <div class="box">
    <img class="br-img" src="uploads/digital-sign-design.jpg">
        <span><b>MK Designs</b><br><q><?php echo $_SESSION['profDesc2']?></q></span>
    </div>
    <div class="w3-container w3-padding-32" style="margin-top:75px;padding-right:18px; width:100%; margin-left:0px;">
        <span class="w3-left">&copy; Copyright 2022 Branzpir</span><span class="w3-right">Powered by <a href="https://eurotechdisplays.com.au/" class="foot-link" title="Eurotech" target="_blank" class="w3-hover-opacity" style='text-decoration:none'>Eurotech</a></span>
    </div>
</div>
<script src='index.js'></script>
</body>

</html>

