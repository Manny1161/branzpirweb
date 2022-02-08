<?php
require_once 'utils.php';
		
$errors = [];

if(isset($_POST) & !empty($_POST) && $_SESSION['loggedin'] == true)
{
    if(isset($_POST['csrf_token']))
    {
        if($_POST['csrf_token'] == $_SESSION['csrf_token'])
        {
            $errors[] = "CSRF Token Validation Success!";
            if($_SESSION['loggedin']==true)
            {
                echo 1;
            }
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
        {}
    }
}
$token = md5(uniqid(rand(), true));
$_SESSION['csrf_token'] = $token;
$_SESSION['csrf_token_time'] = time();
?>

<!DOCTYPE html>
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
    .w3-half img:hover{opacity:0.8}
    h1,h2{color:#a6001a;}
    /*CHECK IF SCREEN IS LESS THAN 992 PIXELS FOR SMALL SCREENS*/ 
    .smallSearch @media all and (max-width:992px){input[type=text]{width:250px;position:absolute;left:210px;top:5px;box-sizing:border-box;border:2px solid #ccc;border-radius:5px;font: size 12px;
    background-color:white;background-position:10px 10px;background-repeat:no-repeat;padding:5px 10px 12px 30px;
    -webkit-transition: width:0.4s ease-in-out;}}
    input[type=text]:focus{width:50%}

    /*CHECK IF SCREEN IS LESS THAN 601 PIXELS FOR LARGER SCREENS*/
    @media all and (max-width:601px){input[type=text]{width:250px;position:absolute;left:200px;top:5px;box-sizing:border-box;border:2px solid #ccc;border-radius:5px;font: size 12px;
    background-color:white;background-position:10px 10px;background-repeat:no-repeat;padding:5px 10px 12px 30px;
    -webkit-transition: width:0.4s ease-in-out;}}
    input[type=text]:focus{width:50%}
</style>
<body>
<nav class="w3-sidebar w3-highway-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
    <div class="w3-container">
        <h3 class="w3-padding-64"><b><br>branzpir</b></h3>
    </div>

    <div class="w3-bar-block">
        <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a>
        <a href='showcase.php' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Showcase</a>
        <a href='services.html' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Services</a>
        <a href='professionals.php' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Professionals</a> 
        <a href='contact.html' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Contact</a>
        <a href='youandbranzpir.html' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">You and Branzpir</a>
        <a href='login.php' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Login</a>
        <a href='registration.php' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Register</a>
        <a href='logout.php' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Logout</a>
    </div>
</nav>

<!--- TOP MENU ON SMALL SCREENS -->
<header class="w3-container w3-top w3-hide-large w3-highway-red w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-highway-red w3-margin-right" onclick="w3_open()">☰</a>
    <span><a href='index.php' style='text-decoration:none'>branzpir</a></span>
</header>

<!--- OVERLAY EFFECT WHEN OPENING SIDEBAR ON SMALL SCREENS -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!--- PAGE CONTENT -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
    <div class="w3-container" style="margin-top:80px" id="showcase">
        <form><input class='smallSearch' type="text" name="search" placeholder="Search"></form>
        <h1 class="w3-jumbo"><b>Be Visually Inspired</b></h1>
        <h1 class="w3-xxxlarge"><b>Showcase.</b></h1>
        <hr style="width:50px;border:5px solid #a6001a" class="w3-round">
    </div>

    <div class="w3-row-padding">
        <div class="w3-half">
            <img src="https://www.w3schools.com/w3images/kitchenconcrete.jpg" style="width:100%" onclick="onClick(this)" alt="Concrete meets bricks">
            <img src="https://www.w3schools.com/w3images/livingroom.jpg" style="width:100%" onclick="onClick(this)" alt="Light, white and tight scandanavian design">
            <img src="https://www.w3schools.com/w3images/diningroom.jpg" style="width:100%" onclick="onClick(this)" alt="White walls with designer chairs"> 
        </div>
        <div class="w3-half">
            <img src="https://www.w3schools.com/w3images/atrium.jpg" style="width:100%" onclick="onClick(this)" alt="Windows for the atrium">
            <img src="https://www.w3schools.com/w3images/bedroom.jpg" style="width:100%" onclick="onClick(this)" alt="Bedroom and office in one space">
            <img src="https://www.w3schools.com/w3images/livingroom2.jpg" style="width:100%" onclick="onClick(this)" alt="Scandanavian design"> 
        </div>
    </div>

    <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
        <span class="w3-button w3-black w3-xxlarge w3-display-topright">x</span>
        <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
            <img id="img01" class="w3-image">
            <p id="caption"></p>    
        </div>
    </div>

    <div class="w3-container" id="services" style="margin-top:75px">
        <h1 class="w3-xxxlarge"><b>Services</b></h1>
        <hr style="width:50px;border:5px solid #a6001a" class="w3-round">
        <p>Branzpir is your connection to brand enpowerment.</p>
        <p>Search for photos, inspiration and professionals. Refine by application, styles or size to find ideas which suit your project.</p>
        <p>Our Catalogue of professionals includes design agencies, architecture firms, construction companies, signage businesses - all Australia-based</p>
    </div>

    <div class="w3-container" id="professionals" style="margin-top:75px">
        <h1 class="w3-xxxlarge"><b>Professionals</b></h1>
        <hr style="width:50px;border:5px solid #a6001a" class="w3-round">
        <p>Branzpir is your connection to brand enpowerment.</p>
        <p>Search for photos, inspiration and professionals. Refine by application, styles or size to find ideas which suit your project.</p>
        <p>Our Catalogue of professionals includes design agencies, architecture firms, construction companies, signage businesses - all Australia-based</p>
    </div>

    <div class="w3-container" id="contact" style="margin-top:75px">
        <h1 class="w3-xxxlarge"><b>Contact</b></h1>
        <hr style="width:50px;border:5px solid #a6001a" class="w3-round">
        <p>Branzpir is your connection to brand enpowerment.</p>
        <p>Search for photos, inspiration and professionals. Refine by application, styles or size to find ideas which suit your project.</p>
        <p>Our Catalogue of professionals includes design agencies, architecture firms, construction companies, signage businesses - all Australia-based</p>
    </div>

    <div class="w3-container" id="youandbranzpir" style="margin-top:75px">
        <h1 class="w3-xxxlarge"><b>You and Branzpir</b></h1>
        <hr style="width:50px;border:5px solid #a6001a" class="w3-round">
        <p>Branzpir is your connection to brand enpowerment.</p>
        <p>Search for photos, inspiration and professionals. Refine by application, styles or size to find ideas which suit your project.</p>
        <p>Our Catalogue of professionals includes design agencies, architecture firms, construction companies, signage businesses - all Australia-based</p>
    </div>

<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px">
<p class="w3-right">Powered by <a href="https://eurotechdisplays.com.au/" title="Eurotech" target="_blank" class="w3-hover-opacity" style='text-decoration:none'>Eurotech</a></p>
</div>
<script>
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
function onClick(element) {
    document.getElementById("img01").src = element.src;
    document.getElementById("modal01").style.display = "block";
    var captionText = document.getElementById("caption");
    captionText.innerHTML = element.alt;
}
</script>
</body>
</html>