<!--?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
  echo "Sorry, only JPG, JPEG & PNG files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>-->

<?php
require_once 'utils.php';
$msg = '';
if(isset($_POST['upload']))
{
  $fname = $_FILES['image']['name'];
  $tempname = $_FILES['image']['tmp_name'];
  $folder = 'uploads/'.($fname);
  if($C = connect())
  {
    move_uploaded_file($tempname, $folder);
    $res = sqlInsert($C, "INSERT INTO images (filename) VALUES ('$fname')");
    move_uploaded_file($tempname, 'uploads/'.$filename);
    mysqli_query($C, $res);
   
  }
  else
  {
    echo 'fail';
  }
}

$search=$_POST['search'];
$searchoriginal=$search;
$search=strtolower($search);
$search=trim($search);
$search=explode(' ', $search);
$countsearchterms=count($search);
$submitbutton=$_POST['submit'];
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
    .smallSearch @media all and (max-width:992px){input[type=text]{width:250px;position:absolute;left:210px;top:5px;box-sizing:border-box;border:2px solid #ccc;border-radius:30px;font: size 12px;
    background-color:white;background-position:10px 10px;background-repeat:no-repeat;padding:5px 10px 12px 30px;
    -webkit-transition: width:0.4s ease-in-out;}}
    input[type=text]:focus{width:50%}

    /*CHECK IF SCREEN IS LESS THAN 601 PIXELS FOR LARGER SCREENS*/
    @media all and (max-width:601px){input[type=text]{width:250px;position:absolute;left:200px;top:5px;box-sizing:border-box;border:2px solid #ccc;border-radius:30px;font: size 12px;
    background-color:white;background-position:10px 10px;background-repeat:no-repeat;padding:5px 10px 12px 30px;
    -webkit-transition: width:0.4s ease-in-out;}}
    input[type=text]:focus{width:50%}

    .uploadbtn{float:right; margin-top:-30px;}
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
        <a href='login.php' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Login</a>
        <a href='registration.php' onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Register</a>
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
        <form action='' method='POST'>
        <input class='smallSearch' type="text" name="search" value="<?php echo $searchoriginal;?>" placeholder="Search"/><?php if($submitbutton){
		if(empty($searchoriginal)) { echo "<redtext>A search query must be entered</redtext>";}} ?><br><br>
        <input type="submit" name="submit" value="Search"/></form>
        <form method='POST' action='showcase.php' enctype='multipart/form-data'>
        <input type='file' name='image' value='' accept='image/*'/>
        <input type='submit' name='upload' value='Upload'/></form>
        <h1 class="w3-jumbo"><b>Be Visually Inspired</b></h1>
        <h1 class="w3-xxxlarge"><b>Showcase.</b></h1>
        <hr style="width:50px;border:5px solid #a6001a" class="w3-round">
    </div>
 
<?php
error_reporting(0);
$directory = "uploads/";


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
	 echo "<img style='width: 200px;' src='/uploads/$fileoriginal'>". "<br><br><hr>";
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
echo "No results for this search entered";
}
}
}
?>

    <div class="w3-row-padding">
        <div class="w3-half">
            <img src="https://www.w3schools.com/w3images/kitchenconcrete.jpg" style="width:100%" onclick="onClick(this)" alt="Concrete meets bricks">
            <img src="https://st.hzcdn.com/simgs/ff51b784006e2c1e_8-4597/contemporary-bathroom.jpg" style="width:100%" onclick="onClick(this)" alt="Kitchen">
            <img src="https://st.hzcdn.com/simgs/pictures/living-rooms/kiln-lane-perth-megan-prentice-design-img~50517ef40cced9a9_8-6243-1-8915fc6.jpg" style="width:100%"  onclick="onClick(this)" alt="0">
            <img src="https://st.hzcdn.com/simgs/3c51a9e2006e2bf0_8-4988/contemporary-kitchen.jpg" style="width:100%" onclick="onClick(this)" alt="2">
            <img src="https://www.w3schools.com/w3images/livingroom.jpg" style="width:100%" onclick="onClick(this)" alt="Light, white and tight scandanavian design">
            <img src="https://www.w3schools.com/w3images/diningroom.jpg" style="width:100%" onclick="onClick(this)" alt="White walls with designer chairs">
            <img src="uploads/2a96ebdf2f58bf503d162f494a34746d.png" style="width:100%" onclick="onClick(this)" alt="LED lightbox letter sign">
            <img src="uploads/ngolol.PNG" style="width:100%" onclick="onClick(this)" alt="Overhead graphic sign"> 
        </div>
        <div class="w3-half">
            <img src="https://www.w3schools.com/w3images/atrium.jpg" style="width:100%" onclick="onClick(this)" alt="Windows for the atrium">
            <img src="https://st.hzcdn.com/simgs/pictures/kitchens/twin-peaks-jbs-building-and-development-img~bdd136370f0aa48d_8-3009-1-1a30da0.jpg" style="width:100%" onclick="onClick(this)" alt="Twin Peaks">
            <img src="https://st.hzcdn.com/simgs/pictures/kitchens/south-perth-chararcter-home-trager-kitchens-and-interiors-img~7df10cd806b83295_8-9491-1-4123f6a.jpg" style="width:100%" onclick="onClick(this)" alt="1">
            <img src="https://st.hzcdn.com/simgs/d6016ea5012b31ac_8-0794/victorian-patio.jpg" style="width:100%" onclick="onClick(this)" alt="3">
            <img src="https://www.w3schools.com/w3images/bedroom.jpg" style="width:100%" onclick="onClick(this)" alt="Bedroom and office in one space">
            <img src="https://www.w3schools.com/w3images/livingroom2.jpg" style="width:100%" onclick="onClick(this)" alt="Scandanavian design">
            <img src ="uploads/956b176cfc94af7bff1e6ecb6535337c.jpg" style="width:100%" onclick="onClick(this)" alt="Letter mount sign">
            <img src="uploads/sasuke.jpg" style="width:100%" onclick="onClick(this)" alt="aluminium sheet sign"> 
        </div>
    </div>

    <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
        <span class="w3-button w3-black w3-xxlarge w3-display-topright">x</span>
        <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
            <img id="img01" class="w3-image">
            <p id="caption"></p>    
        </div>
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
