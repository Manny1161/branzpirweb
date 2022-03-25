<style>
  .message{color:red}
</style>

<?php
require_once 'utils.php';
error_reporting(0);

$search=$_POST['search'];
$searchoriginal=$search;
$search=strtolower($search);
$search=trim($search);
$search=explode(' ', $search);
$countsearchterms=count($search);
$submitbutton=$_POST['submit'];
$C = connect();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>branzpir</title>
    <link rel='branzpir icon' href='branzpir_favicon.png' type='image/x-icon'>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    body {font-size:16px;}
    .w3-half img{margin-bottom:-6px;margin-top:16px;opactiy:0.8;cursor:pointer}
    .w3-half img:hover{opacity:0.8}
    h1,h2{color:#a6001a;}
    /*CHECK IF SCREEN IS LESS THAN 992 PIXELS FOR SMALL SCREENS*/ 
    .smallSearch @media all and (max-width:992px){input[type=text]{width:250px;position:absolute;left:210px;top:5px;box-sizing:border-box;border:2px solid #ccc;border-radius:30px;font: size 12px;
    background-color:white;background-position:10px 10px;background-repeat:no-repeat;padding:5px 10px 12px 30px;
    -webkit-transition: width:0.4s ease-in-out;}}
    input[type=text]:focus{width:50%}

    /*CHECK IF SCREEN IS LESS THAN 601 PIXELS FOR LARGER SCREENS*/
    @media all and (max-width:601px){input[type=text]{width:250px;position:absolute;left:200px;top:5px;box-sizing:border-box;border:2px solid #ccc;border-radius:30px;font: size 12px;
    background-color:white;background-position:10px 10px;background-repeat:no-repeat;padding:5px 10px 12px 30px;
    -webkit-transition: width:0.4s ease-in-out;}}
    input[type=text]:focus{width:50%}

    .profUpld{float:right; margin-top:-50px; border-radius:20px; margin-right:5px; border:none; color:black; background-color:white;}
    .uploadbtn{float:right; margin-top:-30px;}
    .button{float:right; margin-top:-30px;}
    .fileinpt{float:right; margin-top:-30px;}
    .nfile{float:right; margin-top:-25px; border-radius:20px; border:none; color:black; background-color:white; cursor:pointer}
    .fileUpld{width:4%;float:right; margin-top:-25px; cursor:pointer}
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

<!--- PAGE CONTENT -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
    <div class="w3-container" style="margin-top:80px" id="showcase">
        <img src='branzpir logo idea 3 with text (002).png' style='width:25%; cursor:pointer;' onclick="window.location.href='index.php';">
        <form action='' method='POST'>
        <input class='smallSearch' type="text" name="search" placeholder="Search"/>
        <input type="submit" name="submit" value="Search"/></form>
        <?php if (($_SESSION['loggedin'] == true) && isset($_SESSION['profID']) /*&&if($_SESSION['verified'] == 1)*/) : ?>
        <form method='POST' action=''><input class='nfile' type='button' value='Upload'></form>
        <img class='fileUpld' src='568717.png' onclick="location.href='uploadSpaces.php';">
        <?php endif ?>
        
        <!--hr style="width:50px;border:5px solid #a6001a" class="w3-round"-->
    </div>
 
<?php
$directory = "uploads/";
$C = connect();


if ($submitbutton){
if (!empty($searchoriginal)) 
{
if (is_dir($directory)){

  if ($open = opendir($directory)){
if ($countsearchterms == 1)
{
    while (($file = readdir($open)) !== false){
	$fileoriginal= $file;
	$file= strtolower($file);
	$position= strpos("$file", ".");
	$fileextension= substr($file, $position + 1);
	$fileextension= strtolower($fileextension);
      if ((strpos("$file",  "$search[0]") !== false) && (($fileextension == "jpg") || ($fileextension == "jpeg") || ($fileextension == "png") || ($fileextension == "bmp")))
	{
	$array[] += "$file";
    $res = sqlSelect($C, 'SELECT description FROM images WHERE filename=?', 's', $fileoriginal);
    $alt = $res->fetch_assoc();
    $_SESSION['alt'] = $alt['description'];
    $imgtxt = $_SESSION['alt'];
	echo "<img style='width: 48%; height:533px; margin:8px; cursor:pointer;'  src='/uploads/$fileoriginal' onclick='onClick(this)' alt='$imgtxt'>";
}
    }
}
else if ($countsearchterms == 2) {
while (($file = readdir($open)) !== false){
	$fileoriginal= $file;
	$file= strtolower($file);
	$position= strpos("$file", ".");
	$fileextension= substr($file, $position + 1);
	$fileextension= strtolower($fileextension);
      if (((strpos("$file",  "$search[0]") !== false) && (strpos("$file",  "$search[1]") !== false)) && (($fileextension == "jpg") 
|| ($fileextension == "jpeg") || ($fileextension == "png") || ($fileextension == "bmp"))) {
	$array[] += "$file";
	 echo "<img style='width: 200px;' src='/images/$fileoriginal'>". "<br><br><hr>";
}
    }
}
else if ($countsearchterms == 3) {
while (($file = readdir($open)) !== false){
	$fileoriginal= $file;
	$file= strtolower($file);
	$position= strpos("$file", ".");
	$fileextension= substr($file, $position + 1);
	$fileextension= strtolower($fileextension);
      if (((strpos("$file",  "$search[0]") !== false) && (strpos("$file",  "$search[1]") !== false) && (strpos("$file",  "$search[2]") !== false)) 
&& (($fileextension == "jpg") || ($fileextension == "jpeg") || ($fileextension == "png") || ($fileextension == "bmp")))
	{
	$array[] += "$file";
	 echo "<img style='width: 200px;' src='/images/$fileoriginal'>". "<br><br><hr>";
}
    }
}
else if ($countsearchterms == 4) {
while (($file = readdir($open)) !== false){
	$fileoriginal= $file;
	$file= strtolower($file);
	$position= strpos("$file", ".");
	$fileextension= substr($file, $position + 1);
	$fileextension= strtolower($fileextension);
      if (((strpos("$file",  "$search[0]") !== false) && (strpos("$file",  "$search[1]") !== false) && (strpos("$file",  "$search[2]") !== false)&& (strpos("$file",  "$search[3]") !== false))
&& (($fileextension == "jpg") || ($fileextension == "jpeg") || ($fileextension == "png") || ($fileextension == "bmp")))
	{
	$array[] += "$file";
	echo "<img style='width: 200px;' src='/uploads/$fileoriginal'>". "<br><br><hr>";
}
    }
}
else if ($countsearchterms == 5) {
while (($file = readdir($open)) !== false){
	$fileoriginal= $file;
	$file= strtolower($file);
	$position= strpos("$file", ".");
	$fileextension= substr($file, $position + 1);
	$fileextension= strtolower($fileextension);
      if (((strpos("$file",  "$search[0]") !== false) && (strpos("$file",  "$search[1]") !== false) && (strpos("$file",  "$search[2]") !== false)&& (strpos("$file",  "$search[3]") !== false)
&& (strpos("$file",  "$search[4]") !== false)) && (($fileextension == "jpg") || ($fileextension == "jpeg") || ($fileextension == "png") || ($fileextension == "bmp")))
	{
	$array[] += "$file";
	echo "<img style='width: 200px;' src='/uploads/$fileoriginal'>". "<br><br><hr>";
}
}  
}
else if ($countsearchterms == 6) {
while (($file = readdir($open)) !== false){
	$fileoriginal= $file;
	$file= strtolower($file);
	$position= strpos("$file", ".");
	$fileextension= substr($file, $position + 1);
	$fileextension= strtolower($fileextension);
      if (((strpos("$file",  "$search[0]") !== false) && (strpos("$file",  "$search[1]") !== false) && (strpos("$file",  "$search[2]") !== false)&& (strpos("$file",  "$search[3]") !== false)
&& (strpos("$file",  "$search[4]") !== false) && (strpos("$file",  "$search[5]") !== false)) && (($fileextension == "jpg") || ($fileextension == "jpeg") 
|| ($fileextension == "png") || ($fileextension == "bmp")))
	{
	$array[] += "$file";
	echo "<img style='width: 200px;' src='/uploads/$fileoriginal'>". "<br><br><hr>";
}
}  
}
else if ($countsearchterms == 7) {
while (($file = readdir($open)) !== false){
	$fileoriginal= $file;
	$file= strtolower($file);
	$position= strpos("$file", ".");
	$fileextension= substr($file, $position + 1);
	$fileextension= strtolower($fileextension);

      if (((strpos("$file",  "$search[0]") !== false) && (strpos("$file",  "$search[1]") !== false) && (strpos("$file",  "$search[2]") !== false)&& (strpos("$file",  "$search[3]") !== false)
&& (strpos("$file",  "$search[4]") !== false) && (strpos("$file",  "$search[5]") !== false) && (strpos("$file",  "$search[6]") !== false))
&& (($fileextension == "jpg") || ($fileextension == "jpeg") || ($fileextension == "png") || ($fileextension == "bmp")))
	{
	$array[] += "$file";
	echo "<img style='width: 200px;' src='/uploads/$fileoriginal'>". "<br><br><hr>";
}
}  
}
closedir($open);
    }

  }//while loop

$arraycount= count($array);

if ($arraycount == 0)
{
echo "<p class='message'>No results for this search entered</p>";
}
}
}
?>
    <div class="w3-row-padding">
        <img src="uploads/home.png" style="width:100%">
        <?php
        if($res=sqlSelect($C, 'SELECT filename from images'))
        {
            if($count=$res->num_rows)
            {
                while($row=$res->fetch_object())
                {
        ?>      
                    <div class="w3-half">
                        <?php echo "<img src='uploads/$row->filename' style=width:100% onclick='onClick(this)'>" ?>
                    </div>
        <?php
                }
            $res->free();
            }
        }
        ?>
        <!--div class="w3-half">
            <img src="uploads/a-frame-signs-2.jpg" style="width:100%" onclick="onClick(this)" title="A Frame Sign" alt="Concrete meets bricks<br><-?php echo $_SESSION['profName'] ?>">
            <span><p><-?php echo $_SESSION['profName']?><br>some other text</p></span>
            <img src="uploads/bar-lightbox-signage-letters-retail-restaurant.jpg" style="width:100%" onclick="onClick(this)" alt="Kitchen">
            <img src="uploads/large-lightbox-signage-commercial.jpeg" style="width:100%"  onclick="onClick(this)" alt="0">
            <img src="uploads/Outdoor-Signage-Foundation-Academy-Orlando-Fl.jpg" style="width:100%" onclick="onClick(this)" alt="2">
            <img src="uploads/overhead-signage-aluminium-letter-engraving.jpg" style="width:100%" onclick="onClick(this)" alt="Light, white and tight scandanavian design">
            <img src="uploads/signage-lightbox-overhead.jpg" style="width:100%" onclick="onClick(this)" alt="White walls with designer chairs">
            <img src="uploads/small-signage-pvc-sheet-directions.jpeg" style="width:100%" onclick="onClick(this)" alt="LED lightbox letter sign">
        </div>
        <div class="w3-half">
            <--img src="uploads/unique-wood-glass-standoff-engraving.jpg" style="width:100%" onclick="onClick(this)" alt="Windows for the atrium">
            <img src="uploads/LED-Backlit-Signs-4.jpg" style="width:100%" onclick="onClick(this)" alt="Twin Peaks">
            <img src="uploads/visirite-function-sign-outdoor-aluminium.jpg" style="width:100%" onclick="onClick(this)" alt="1">
            <img src="uploads/car-sign-design-graphic.jpg" style="width:100%" onclick="onClick(this)" alt="3">
            <img src="uploads/car-sign-design-graphic-design.jpg" style="width:100%" onclick="onClick(this)" alt="Bedroom and office in one space">
            <img src="uploads/ecoflex-base-aluminium-sheet-outdoor-function.jpg" style="width:100%" onclick="onClick(this)" alt="Scandanavian design">
            <img src ="uploads/3d-restaurant-signage-1.jpg" style="width:100%" onclick="onClick(this)" alt="Letter mount sign">
            <img src="uploads/outdoor-sign-wire-stake-estate-directions.jpg" style="width:100%" onclick="onClick(this)" alt="aluminium sheet sign"> 
            <img src="uploads/Stud-Mount-Sign-standoffs.jpg" style="width:100%" onclick="onClick(this)" alt="Overhead graphic sign"> 
          </div-->
    </div>
    <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
        <span class="w3-button w3-black w3-xxlarge w3-display-topright">x</span>
        <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
            <img id="img01" class="w3-image">
            <p id="caption"></p>    
        </div>
    </div>
    <div class="w3-container w3-padding-32" style="margin-top:75px;padding-right:18px; width:100%; margin-left:0px;">
        <span class="w3-left">&copy; Copyright 2022 Branzpir</span><span class="w3-right">Powered by <a href="https://eurotechdisplays.com.au/" class="foot-link" title="Eurotech" target="_blank" class="w3-hover-opacity" style='text-decoration:none'>Eurotech</a></span>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src='index.js'></script>
<script>
$('.message').delay(3000).fadeOut('slow', function() { $(this).remove(); });
</script>
</body>
</html>
