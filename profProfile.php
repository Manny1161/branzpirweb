<?php
require_once 'utils.php';
$selected_category = $_GET['category'];
$_SESSION['cat'] = $_GET['category'];

$C = connect();
$res = sqlSelect($C, 'SELECT description, category, number, address1, state, postcode, address2 FROM professionals WHERE username=?', 's', $_SESSION['cat']);
$img = sqlSelect($C, 'SELECT filename FROM images WHERE username=?', 's', $_SESSION['cat']);
if($res && $res->num_rows == 1)
{
    $q = $res->fetch_assoc();
    $_SESSION['profDesc'] = $q['description'];
    $_SESSION['profCat'] = $q['category'];
    $_SESSION['profNum'] = $q['number'];
    $_SESSION['profAddy1'] = $q['address1'];
    $_SESSION['profAddy2'] = $q['address2'];
    $_SESSION['profPost'] = $q['postcode'];
    $_SESSION['profState'] = $q['state'];
}
if($img && $img->num_rows==1)
{
    $i = $img->fetch_assoc();
    $_SESSION['profImg'] = $i['filename'];
}

$directory = "uploads/";
if(is_dir($directory));
{
    if($open = opendir($directory))
    {
        $files = scandir($directory);
        foreach($files as $file)
        {
            if($_SESSION['profImg'] == $file)
            {
                $fileoriginal = $file;
            } 
        }
    }
}
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    body {font-size:16px;}
    .w3-half img{margin-bottom:-6px;margin-top:16px;opactiy:0.8;cursor:pointer}
    .w3-half img:hover{opacity:1}
    table{margin:0 auto;}
    .desc{word-wrap: break-word;}
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

<header class="w3-container w3-top w3-hide-large w3-highway-red w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-highway-red w3-margin-right" onclick="w3_open()">☰</a>
</header>

<!--- OVERLAY EFFECT WHEN OPENING SIDEBAR ON SMALL SCREENS -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<h2 style="text-align:center; margin-top:70px"><?php echo $_SESSION['cat'];?></h2>
<h5 style="text-align:center; color:grey"><?php echo $_SESSION['profCat'];?></h5>
<div class="w3-main" style="margin-right:400px">
    <div class="w3-right">
        <div class="w3-container" style="margin-top:80px">
            <div display="flex"><span><?php echo $_SESSION['profNum'];?></span></div>
            <div display="flex"><span><?php echo $_SESSION['profAddy1'];?>&nbsp;<?php echo $_SESSION['profAddy2'];?></span></div>
            <div display="flex"><span><?php echo $_SESSION['profState'];?>&nbsp;<?php echo $_SESSION['profPost'];?></span></div>
        </div>
    </div>
    <div class="w3-left">
        <div class="w3-container" style="margin-top:80px; width:500px;" >
            <div class="desc"><span><?php echo $_SESSION['profDesc'];?></span></div>
        </div>
    </div>
    <div class="w3-third">
        <?php echo "<img src='uploads/$fileoriginal'>" ?>
        <img src="uploads/">
        <img src="uploads/">
    </div>
</div>

<script src="index.js"></script>
</body>
</html>