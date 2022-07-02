
<style>
  .message{color:red}
</style>

<?php
require_once 'utils.php';
error_reporting(0);
$C = connect();
$_SESSION['home'] = $_GET['index'];
$is_page_refreshed = (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0' ||  $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>branzpir</title>
    <link rel='branzpir icon' href='branzpir_favicon.png' type='image/x-icon'>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    .p1{font-size:14px; color:#000000}
    body {font-size:16px;}
    .w3-half img{margin-bottom:-6px;margin-top:16px;opactiy:0.8;cursor:pointer}
    .w3-half img:hover{opacity:0.8}
    h1,h2{color:#a6001a;}
    .logIn{float:right; margin-top:-5px; border-radius:20px; margin-right:5px; border:none; color:black; background-color:white;}
    .profReg{float:right; margin-top:11px; border-radius:20px; margin-right:5px; border:none; color:black; background-color:white;}
    .nlog{width:3%;float:right; margin-top:-5px; cursor:pointer;}
    .nprof{width:3%;float:right;margin-top:-5px;;cursor:pointer;}
    
    .profUpld{float:right; margin-top:-50px; border-radius:20px; margin-right:5px; border:none; color:black; background-color:white;}
    .uploadbtn{float:right; margin-top:-30px;}
    .button{float:right; margin-top:-30px;}
    .fileinpt{float:right; margin-top:-30px;}
    .nfile{float:right; margin-top:-25px; border-radius:20px; border:none; color:black; background-color:white; cursor:pointer}
    .fileUpld{width:4%;float:right; margin-top:-25px; cursor:pointer}
    .submit{height:40px}
    @media all and (min-width:992px){
    .dropdown-menu-sw {
        left:75%;
    }
    .dropdown-menu {
        position:absolute;
        top:30px;
        right:10;
        width:160px;
    }}
    @media all and (max-width:992px){
    .dropdown-menu-sw {
        left:60%;
    }
    .dropdown-menu {
        position:absolute;
        top:100px;
        right:10;
        width:160px;

    }}
    @media all and (min-width:992px){
    .dropdown-menu-uw {
        left:65%;
    }
    .dropdown-menu {
        position:absolute;
        top:30px;
        right:10;
        width:160px;
    }}
    @media all and (max-width:992px){
    .dropdown-menu-uw {
        /*right: -10;*/
        left:50%;
    }
    .dropdown-menu {
        position:absolute;
        right:10;
        top:15px;
        width:160px;

    }}
</style>
<body>

<!--- PAGE CONTENT -->
<div class="container">
<div class="w3-container" style="margin-top:14px">
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) : ?>
<form method='POST' action=''><input class='profReg' type='button' value='PROVIDERS'/></form>
    <div class="dropdown">
        <a href="#" id="imageDropdown" data-toggle="dropdown">
        <img class="nprof" src="pros.png">
        </a>
        <div class="dropdown-menu pull-right my-2">
            <li><a href="professionalsLogin.php">Log In</a></li>
            <li><a href="professionalsRegistration.php">Join As a Provider</a></li>
            <?php if(isset($_SESSION['profID'])) : ?>
            <li><a href="logout.php">Log Out</a></li>
            <li><?php echo "<a href='newUserProfile?category=$pro'>Edit Profile</a>"?></li>
            <?php endif ?>
        </div>
    </div>
    <form method='POST' action=''><input class='logIn' type='button' value='USERS'/></form>
    <div class="dropdown">
        <a href="#" id="imageDropdown" data-toggle="dropdown">
        <img class="nlog" src="users.png">
        </a>
        <div class="dropdown-menu dropdown-menu-sw">
            <li><a href="login.php">Log In</a></li>
            <li><a href="registration.php">Register</a></li>
            <?php if(isset($_SESSION['userID'])) : ?>
            <li><a href="logout.php">Log Out</a></li>
            <?php endif ?>
        </div>
    </div>
    <?php endif ?>
    <!-- IF USER IS LOGGED IN DISPLAY THIS -->
    <?php if(isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true) : ?>
        <!-- IF USER IS PROVIDER DISPLAY THIS -->
        <?php if(isset($_SESSION['profID'])) : ?>
            <form method='POST' action=''><input class='profReg' type='button' value='<?php echo $_SESSION['profName']?>'/></form>
            <div class="dropdown">
                <a href="#" id="imageDropdown" data-toggle="dropdown">
                <img class="nprof" src="pros.png">
                </a>
                <div class="dropdown-menu pull-right my-2">
                    <?php if(!isset($_SESSION['profID'])) : ?>
                        <li><a href="professionalsLogin.php">Log In</a></li>
                        <li><a href="professionalsRegistration.php">Join As a Provider</a></li>
                    <?php endif ?>
                    <?php if(isset($_SESSION['profID'])) : ?>
                        <li><a href="dashboard.php">My Dashboard</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                    <?php endif ?>
                </div>
            </div>
        <?php endif ?>
        <!-- IF USER IS PRIVATE USER DISPLAY THIS -->
        <?php if(isset($_SESSION['userID'])) : ?>
            <form method='POST' action=''><input class='logIn' type='button' value='<?php echo $_SESSION['userName']?>'/></form>
            <div class="dropdown">
                <a href="#" id="imageDropdown" data-toggle="dropdown">
                <img class="nlog" src="users.png">
                </a>
                <div class="dropdown-menu pull-right my-2">
                    <?php if(!isset($_SESSION['userID'])) : ?>
                        <li><a href="login.php">Log In</a></li>
                        <li><a href="registration.php">Register</a></li>
                    <?php endif ?>
                    <?php if(isset($_SESSION['userID'])) : ?>
                        <li><a href="dashboard.php?uname=<?php echo $_SESSION['userName']?>">My Dashboard</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                    <?php endif ?>
                </div>
            </div>
        <?php endif ?>
    <?php endif ?>
        <form action='' method='POST'>
            <img src='branzpir logo idea 3 with text (002).png' style='width:25%; cursor:pointer' onclick="window.location.href='index.php';">  
            <div class="input-group"> 
            <input class="search form-control rounded" style="width:70%" type="text" name="search" placeholder="Search for inspiration..." />  
            </div>
        </form>
    
    </div>        

<div class="w3-bar w3-highway-red w3-card mb-2" style="margin-top:-1px">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i>☰</a>    
    <div class="container">
    <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Home</a>
    <a href='showcase.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Showcase</a>
    <a href='findProfessionals.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Find Providers</a> 
    <a href='contact.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Contact</a>
    </div>
</div>
        
<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium" style="margin-top:46px">
    <a href="index.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Home</a>
    <a href="showcase.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Showcase</a>
    <a href="findProfessionals.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Find Providers</a>
    <a href="contact.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Contact</a>
    <a href="youandbranzpir.html" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">You and Branzpir</a>
</div>
<div class="container">   
            
<div class="row">
    <div class="col-3">
        <img src="uploads/pexels-tim-mossholder-942317.jpg" style="width:100px;height:100px;object-fit:cover">
        <a href="indoors.php" style="text-decoration:none"><p1><b>Indoors</b></p1></a>
    </div>
    <div class="col-3">
        <img src="uploads/np_Old hotel sign, Seattle, Washington_4OdjLb_full.jpg" style="width:100px;height:100px;object-fit:cover">
        <a href="building.php" style="text-decoration:none"><h2><b>Building</b></h2></a>
    </div>
    <div class="col-3">
        <img src="uploads/pexels-vlad-alexandru-popa-1486222.jpg" style="width:100px;height:100px;object-fit:cover">
        <a href="outdoors.php" style="text-decoration:none"><h2><b>Outdoors</b></h2></a>
    </div>
    <div class="col-3">
        <img src="uploads/pexels-karol-d-331788.jpg" style="width:100px;height:100px;object-fit:cover">
        <a href="digital.php" style="text-decoration:none"><h2><b>Digital</b></h2></a>
    </div>
<?php

if(isset($_POST['search']))
{
    $search = $_POST['search'];
    if($pro1=sqlSelect($C, "SELECT filename, project, username FROM images WHERE description LIKE '%$search%'"));
    {
        if($count1=$pro1->num_rows)
        {
            while(($prow1=$pro1->fetch_object()))
            {                                   
                ?>
                    <div class="col-md-4">
                    <?php echo "<a href='showGallery?show=$prow1->project&uid=$prow1->username'><img src='uploads/$prow1->filename' class='img-fluid rounded shadow-sm' style='height:300px; width:550px; object-fit:cover;'></a>
                    <span><a class='small' style='color:black'; href='newUserProfile.php?category=$prow1->username'>$prow1->username</a>"?>
                </div><?php
            } 
        }
        else
        {
            echo "<p class='message'>No results for this search entered</p>";
        }
    $pro1->free();  
    }
}

if(isset($_SESSION['home']) && !$is_page_refreshed)
{
    $search = $_SESSION['home'];
    if($pro1=sqlSelect($C, "SELECT filename, username, project, description FROM images WHERE description LIKE '%$search%'"));
    {
        if($count1=$pro1->num_rows)
        {
            while(($prow1=$pro1->fetch_object()))
            {                                   
                ?>
                    <div class="col-md-4">
                    <?php echo "<a href='showGallery?show=$prow1->project&uid=$prow1->username'><img src='uploads/$prow1->filename' class='img-fluid rounded shadow-sm' style='height:300px; width:550px; object-fit:cover;'></a>
                    <span><a class='small' style='color:black'; href='newUserProfile.php?category=$prow1->username'>$prow1->username</a>"?>
                </div><?php
            } 
        }
        else
        {
            echo "<p class='message'>No results for this search entered</p>";
        }
    $pro1->free();  
    }
}
    
?>
</div>
<div class="row">
	<?php if(!isset($_POST['search']))
	{
		if($res=sqlSelect($C, 'SELECT filename, project, description, username from images'))
		{
			if($count=$res->num_rows)
			{
				while($row=$res->fetch_object())
				{
		?>      
					<div class="col-md-4">
					<?php echo "<a href='showGallery?show=$row->project&uid=$row->username'><img src='uploads/$row->filename' class='img-fluid rounded shadow-sm' style='height:300px; width:550px; object-fit:cover;'></a>
						<p class='p1'>$row->project</p><a class='small' style='color:#5b5b5b'; href='newUserProfile.php?category=$row->username'>$row->username</a>"?>
					</div>
		<?php
				}
			$res->free();
			}
		}
		?>
		
	}
	</div>
</div>
<footer class="w3-container w3-highway-red w3-padding-48" style="margin-top:75px">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <div class="w3-left"><img src='branzpir logo idea 3 with text (002).png' style='width:50%'></div>
            <a href="https://www.facebook.com/eurotechaustralia/"><img src='facebookicon1.png' style='width:10%'></a>&nbsp;
            <a href="https://www.linkedin.com/company/eurotech-australia/"><img src='linkedin1.png' style='width:10%'></a>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
            <h4>WHO WE ARE</h4>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="#" class="text-muted">About us</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Conditions of use</a></li>
                <li class="mb-2"><a href="#" class="text-muted">How does it work</a></li>
            </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
            <h4>CONTACT</h4>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="#" class="text-muted">Contact us</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Terms & privacy</a></li>
            </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
            <h4>YOU & BRANZPIR</h4>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="#" class="text-muted">For Brands</a></li>
                <li class="mb-2"><a href="#" class="text-muted">For Providers</a></li>
                <li class="mb-2"><a href="#" class="text-muted">For You in Business</a></li>
            </ul>
            </div>
        </div>
        <span class="w3-left my-5">&copy; Copyright 2022 Branzpir</span><span class="w3-right my-5">Powered by <a href="https://eurotechdisplays.com.au/" title="Eurotech" target="_blank" class="w3-hover-opacity" style='color: #ffffff;'>Eurotech</a></span>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src='index.js'></script>
<script>
$('.message').delay(3000).fadeOut('slow', function() { $(this).remove(); });
if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>
