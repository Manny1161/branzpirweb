<!DOCTYPE html>
<html lang="en">
<head>
    <title>Branzpir</title>
    <meta charset="UTF-8"/>
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    body {font-size:16px;}
    .br-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
    .br-half img:hover{opacity:1}
</style>
<body>
<p align='right'> <a href="main.php">Login</a></p>
<p align='right'> <a href="registration.php">Register</a></p>
<nav class="br-sidebar br-red br-collapse br-top br-large br-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
    <a href="javascript:void(0)" onclick="br_close()" class="br-button br-hide-large br-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
    <div class="br-container">
        <h3 class="br-padding-64"><b><br>Branzpir</b></h3>
    </div>
    <div class="br-bar-block">
        <a href="#" onclick="br_close()" class="br-bar-item br-button br-hover-white">Home</a>
        <a href="#showcase" onclick="br_close()" class="br-bar-item br-button br-hover-white">Showcase</a>
        <a href="#services" onclick="br_close()" class="br-bar-item br-button br-hover-white">Services</a>
        <a href="#professionals" onclick="br_close()" class="br-bar-item br-button br-hover-white">Professionals</a> 
        <a href="#contact" onclick="br_close()" class="br-bar-item br-button br-hover-white">Contact</a>
        <a href="#youandbranzpir" onclick="br_close()" class="br-bar-item br-button br-hover-white">You and Branzpir</a>
    </div>
</nav>

<!--- TOP MENU ON SMALL SCREENS -->
<header class="br-container br-top br-hide-large br-red br-xlarge br-padding">
    <a href="javascript:void(0)" class="br-button br-red br-margin-right" onclick="br_open()">☰</a>
    <span>Branzpir</span>
</header>

<!--- OVERLAY EFFECT WHEN OPENING SIDEBAR ON SMALL SCREENS -->
<div class="br-overlay br-hide-large" onclick="br_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!--- PAGE CONTENT -->
<div class="br-main" style="margin-left:340px;margin-right:40px">

    <div class="br-container" style="margin-top:80px" id="showcase">
        <h1 class="br-jumbo"><b>Indoors</b></h1>
        <h1 class="br-xxxlarge br-text-red"><b>Showcase.</b></h1>
        <hr style="width:50px;border:5px solid red" class="br-round">
    </div>

    <div class="br-row-padding">
        <div class="br-half">
            <img src="https://www.w3schools.com/w3images/kitchenconcrete.jpg" style="width:100%" onclick="onClick(this)" alt="Concrete meets bricks">
            <img src="https://www.w3schools.com/w3images/livingroom.jpg" style="width:100%" onclick="onClick(this)" alt="Light, white and tight scandanavian design">
            <img src="https://www.w3schools.com/w3images/diningroom.jpg" style="width:100%" onclick="onClick(this)" alt="White walls with designer chairs"> 
        </div>
        <div class="br-half">
            <img src="https://www.w3schools.com/w3images/atrium.jpg" style="width:100%" onclick="onClick(this)" alt="Windows for the atrium">
            <img src="https://www.w3schools.com/w3images/bedroom.jpg" style="width:100%" onclick="onClick(this)" alt="Bedroom and office in one space">
            <img src="https://www.w3schools.com/w3images/livingroom2.jpg" style="width:100%" onclick="onClick(this)" alt="Scandanavian design"> 
        </div>
    </div>

    <div id="modal01" class="br-modal br-black" style="padding-top:0" onclick="this.style.display='none'">
        <span class="br-button br-black br-xxlarge br-display-topright">x</span>
        <div class="br-modal-content br-animate-zoom br-center br-transparent br-padding-64">
            <img id="img01" class="br-image">
            <p id="caption"></p>    
        </div>
    </div>

    <div class="br-container" id="services" style="margin-top:75px">
        <h1 class="br-xxxlarge br-text-red"><b>Services</b></h1>
        <hr style="width:50px;border:5px solid red" class="br-round">
        <p>Branzpir is your connection to brand enpowerment.</p>
        <p>Search for photos, inspiration and professionals. Refine by application, styles or size to find ideas which suit your project.</p>
        <p>Our Catalogue of professionals includes design agencies, architecture firms, construction companies, signage businesses - all Australia-based</p>
    </div>

    <div class="br-container" id="professionals" style="margin-top:75px">
        <h1 class="br-xxxlarge br-text-red"><b>Professionals</b></h1>
        <hr style="width:50px;border:5px solid red" class="br-round">
        <p>Branzpir is your connection to brand enpowerment.</p>
        <p>Search for photos, inspiration and professionals. Refine by application, styles or size to find ideas which suit your project.</p>
        <p>Our Catalogue of professionals includes design agencies, architecture firms, construction companies, signage businesses - all Australia-based</p>
    </div>

    <div class="br-container" id="contact" style="margin-top:75px">
        <h1 class="br-xxxlarge br-text-red"><b>Contact</b></h1>
        <hr style="width:50px;border:5px solid red" class="br-round">
        <p>Branzpir is your connection to brand enpowerment.</p>
        <p>Search for photos, inspiration and professionals. Refine by application, styles or size to find ideas which suit your project.</p>
        <p>Our Catalogue of professionals includes design agencies, architecture firms, construction companies, signage businesses - all Australia-based</p>
    </div>

    <div class="br-container" id="youandbranzpir" style="margin-top:75px">
        <h1 class="br-xxxlarge br-text-red"><b>You and Branzpir</b></h1>
        <hr style="width:50px;border:5px solid red" class="br-round">
        <p>Branzpir is your connection to brand enpowerment.</p>
        <p>Search for photos, inspiration and professionals. Refine by application, styles or size to find ideas which suit your project.</p>
        <p>Our Catalogue of professionals includes design agencies, architecture firms, construction companies, signage businesses - all Australia-based</p>
    </div>

    <div class="br-row-padding br-grayscale">
        <div class="br-col m4 br-margin-bottom">
            <div class="br-light-grey">
                <img src="https://eurotechdisplays.com.au/wp-content/uploads/2020/04/AngelRacer-____2437_0.jpg.webp" alt="AngelRacer" style="width:100%">
                <div class="br-container">
                    <h3>AngelRacer</h3>
                    <p class="br-opacity">German Manufacturer</p>
                    <p>AngelRacers are a popular product developed by YelloTools.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="br-row-padding br-grayscale">
        <div class="br-col m4 br-margin-bottom">
            <div class="br-light-grey">
                <img src="https://eurotechdisplays.com.au/wp-content/uploads/2015/02/Adhesives.jpg.webp" alt="RiteTack" style="width:100%">
                <div class="br-container">
                    <h3>RitTack</h3>
                    <p class="br-opacity">Rite Adhesives</p>
                    <p>RiteTack is a popular construction adhesive.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="br-row-padding br-grayscale">
        <div class="br-col m4 br-margin-bottom">
            <div class="br-light-grey">
                <img src="https://eurotechdisplays.com.au/wp-content/uploads/2015/02/Letter-box-number-fix-stuck-on-with-adhesive-ritetack.jpg.webp" alt="Invisifix" style="width:100%">
                <div class="br-container">
                    <h3>Invisifix</h3>
                    <p class="br-opacity">Rite Adhesives</p>
                    <p>Invisifix is a popular construction adhesive.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="br-light-grey br-container br-padding-32" style="margin-top:75px;padding-right:58px">
<p class="br-right">Powered by<a href="https://eurotechdisplays.com.au/" title=" Eurotech" target="_blank" class="br-hover-opacity"> Eurotech</a></p></div>
<script>
function br_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
function br_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay".style.display = "none");
}
function Onclick(element) {
    document.getElementById("img01").src = element.src;
    document.getElementById("modal01").style.display = "block";
    var captionText = document.getElementById("caption");
    captionText.innerHTML = element.alt;
}
</script>
</body>
</html>
