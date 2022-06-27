<?php
    error_reporting(0);
    require_once 'utils.php';
    if(isset($_SESSION['profName']))
    {
        $pro = $_SESSION['profName'];
    }
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4..0/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<style>
    body,h1,h2,h3,h4 {font-family: "Poppins", san-serif}
    h5 {text-align:center; font-family: "Poppins", san-serif}
    body {font-size:16px;}
    .w3-half img{margin-bottom:-6px;margin-top:16px;opactiy:0.8;cursor:pointer}
    .w3-half img:hover{opacity:0.8}
    h1,h2{color:#a6001a;}
    .logIn{float:right; margin-top:-5px; border-radius:20px; margin-right:5px; border:none; color:black; background-color:white;}
    .profReg{float:right; margin-top:-5px; border-radius:20px; margin-right:5px; border:none; color:black; background-color:white;}
    .brandReg{float:right; margin-top:-5px; border-radius:20px; border:none; color:black; background-color:white;}
    .searchBar{width:300px; margin-top:-20px; color:#bfbfbf; background-color:white; text-align:left; border-radius:15px;}
    .nextRound{background-color:red; color:white; border-radius:50%; margin-left:-42px; font-size:10px; padding: 8px 16px;}
    .lft{margin-left:80px; padding-top:-50px; font-size:13px; text-align:left;}
    .nlog{width:3%;float:right; margin-top:-5px; cursor:pointer;}
    .nprof{width:3%;float:right;margin-top:-5px;;cursor:pointer;}
    .nbrand{width:3%; float:right; margin-top:-5px; cursor:pointer;}
    .nbrandMenu{float:right;margin-top:-10px}
    .mainImg{width:100%}
    .content{
        position:relative;
    }
    .pros-content {
        position:absolute;
        float:right;margin-right:5px;
    }

    /* Dropdown Button */
	.dropbtn {
	  background-color: white;
	  color: white;
	  font-size: 16px;
	  border: none;
	}
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
    <div class="w3-container" style="margin-top:30px" id="showcase">
    <!-- IF USER IS NOT LOGGED IN DISPLAY THIS -->
    <?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) : ?>
    <form method='POST' action=''><input class='brandReg' type='button' value='BRANDS'/></form>
        <div class="dropdown">
            <a href="#" id="imageDropdown" data-toggle="dropdown">
            <img class="nbrand" src="brands.png">
            </a>
            <div class="dropdown-menu pull-right my-2">
                <li><a href="login.php">Log In</a></li>
                <li><a href="registration.php">Join As a Brand</a></li>
                <?php if(isset($_SESSION['brandID'])) : ?>
                <li><a href="logout.php">Log Out</a></li>
                <?php endif ?>
            </div>
        </div>
        <form method='POST' action=''><input class='profReg' type='button' value='PROVIDERS'/></form>
        <div class="dropdown">
            <a href="#" id="imageDropdown" data-toggle="dropdown">
            <img class="nprof" src="pros.png">
            </a>
            <div class="dropdown-menu dropdown-menu-sw">
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
            <div class="dropdown-menu dropdown-menu-uw">
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
                        <li><a href="professionalsLogin.php">Log In</a></li>
                        <li><a href="professionalsRegistration.php">Join As a Provider</a></li>
                        <?php if(isset($_SESSION['profID'])) : ?>
                        <li><a href="logout.php">Log Out</a></li>
                        <li><?php echo "<a href='newUserProfile?category=$pro'>Edit Profile</a>"?></li>
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
                        <li><a href="login.php">Log In</a></li>
                        <li><a href="registration.php">Register</a></li>
                        <?php if(isset($_SESSION['userID'])) : ?>
                        <li><a href="logout.php">Log Out</a></li>
                        <?php endif ?>
                    </div>
                </div>
            <?php endif ?>
        <?php endif ?>
        <img src='branzpir logo idea 3 with text (002).png' style='width:25%; cursor:pointer' onclick="window.location.href='index.php';">
        <form method='GET' action='showcase.php'>
            <div class="input-group">
                <input class="search form-control rounded" style="width:70%" type="text" name="index" placeholder="Search for inspiration..." />  
            </div>
        </form>
    </div>
</div>
        
<div class="w3-bar w3-highway-red w3-card my-2" >
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i>☰</a>    
    <div class="container">
    <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Home</a>
    <a href='showcase.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Showcase</a>
    <a href='findProfessionals.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Find Providers</a> 
    <a href='contact.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Contact</a>
    <a href='youandbranzpir.html' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">You and Branzpir</a>
    </div>
</div>


<!-- Navbar on small screens (remove the onclick attribute if you want the navbar to always show on top of the content when clicking on the links) -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium" style="margin-top:46px">
    <a href="index.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Home</a>
    <a href="showcase.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Showcase</a>
    <a href="findProfessionals.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Find Providers</a>
    <a href="contact.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Contact</a>
    <a href="youandbranzpir.html" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">You and Branzpir</a>
</div>
    
<div class="container">
    <div class="w3-row-padding">
        <img src="uploads/index.png" class="mainImg" style="padding-top:15px">
    </div>

    <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
        <span class="w3-button w3-black w3-xxlarge w3-display-topright">x</span>
        <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
            <img id="img01" class="w3-image">
            <p id="caption"></p>    
        </div>
    </div>

    <div class="w3-container" id="services" style="margin-top:75px">
        <h1 class="w3-xxxlarge"><b>Welcome To Branzpir</b></h1>
        <hr style="width:50px;border:5px solid #a6001a" class="w3-round">
        <p>Branzpir is your connection to brand enpowerment.</p>
        <p>Search for photos, inspiration and professionals. Refine by application, styles or size to find ideas which suit your project.</p>
        <p>Our Catalogue of professionals includes design agencies, architecture firms, construction companies, signage businesses - all Australia-based.</p>
        <p>Have instant access to inspirational ideas through input of your own search term.</p>
        <p>Register and you will have an even more comprehensive list of provider and manufacturer details.</p>
    </div>

    <div class="w3-row" style="margin-top:75px">
        <h1 class="w3-xxxlarge"><b>Browse For Inspiration</b></h1>
        <hr style="width:50px;border:5px solid #a6001a" class="w3-round">
            <div class="w3-container w3-quarter">
                <img src="uploads/pexels-tim-mossholder-942317.jpg" style="width:100%;height:230px;object-fit:cover">
                <a href="indoors.php" style="text-decoration:none"><h2><b>Indoors</b></h2></a>
            </div>
            <div class="w3-container w3-quarter">
                <img src="uploads/np_Old hotel sign, Seattle, Washington_4OdjLb_full.jpg" style="width:100%;height:230px;object-fit:cover">
                <a href="building.php" style="text-decoration:none"><h2><b>Building</b></h2></a>
            </div>
            <div class="w3-container w3-quarter">
                <img src="uploads/pexels-vlad-alexandru-popa-1486222.jpg" style="width:100%;height:230px;object-fit:cover">
                <a href="outdoors.php" style="text-decoration:none"><h2><b>Outdoors</b></h2></a>
            </div>
            <div class="w3-container w3-quarter">
                <img src="uploads/pexels-karol-d-331788.jpg" style="width:100%;height:230px;object-fit:cover">
                <a href="digital.php" style="text-decoration:none"><h2><b>Digital</b></h2></a>
            </div>
    </div>

</div>
<footer class="w3-container w3-highway-red w3-padding-48" style="margin-top:75px">
    <div class="container py-5">
	<div class="row">
		<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
		   <img src='branzpir logo idea 3 with text (002).png' style='width:15%'>
		   <a href="https://www.facebook.com/eurotechaustralia/"><img src='facebookicon1.png' style='width:3%'></a>&nbsp;
		   <a href="https://www.linkedin.com/company/eurotech-australia/"><img src='linkedin1.png' style='width:3%'></a>
		</div>
		<div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
		   <h4>WHO WE ARE</h4>
		   <ul class="list-unstyled mb-0">
		       <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
			   <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
			   <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
		   </ul>
		</div>
		<div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
		   <h4>WHO WE ARE</h4>
		   <ul class="list-unstyled mb-0">
		       <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
			   <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
			   <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
		   </ul>
		</div>
		<div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
		   <h4>WHO WE ARE</h4>
		   <ul class="list-unstyled mb-0">
		       <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
			   <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
			   <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
		   </ul>
		</div>
	</div>
	<span class="w3-left my-5">&copy; Copyright 2022 Branzpir</span><span class="w3-right my-5">Powered by <a href="https://eurotechdisplays.com.au/" title="Eurotech" target="_blank" class="w3-hover-opacity" style='color: #ffffff;'>Eurotech</a></span>
    </div>
	
</footer>
<script src='index.js'></script>
</body>
</html>
