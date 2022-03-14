<style>
  .message{position:relative; left:360px; color:red; margin-top:50px;}
</style>

<?php
error_reporting(0);
require_once 'utils.php';

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$C = connect();

// Check if image file is a actual image or fake image
if(isset($_POST["upload"])) {
  $check = getimagesize($_FILES["image"]["tmp_name"]);
  $imagedetails = getimagesize($_FILES["image"]["tmp_name"]);
  $width = $imagedetails[0];
  $height = $imagedetails[1];
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo '<p class="message">File is not an image</p>';
    $uploadOk = 0;
  }
  // Check if file already exists
  if (file_exists($target_file)) {
    echo '<p class="message">Sorry, file already exists</p>';
    $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["image"]["size"] > 500000) {
    echo '<p class="message">Sorry, your file is too large</p>';
    $uploadOk = 0;
  }
  /*if ($width > 580 || $height > 580){
    echo '<p class="message">Sorry, your file is too large</p>';
    $uploadOk = 0;
  }*/
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo '<p class="message">Sorry, only JPG, JPEG & PNG files are allowed.</p>';
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo '<p class="message">Sorry, your file was not uploaded</p>';
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $fname = $_FILES['image']['name'];
      $desc = $_POST['desc'];
      $user = $_SESSION['profName'];
      $res = sqlInsert($C, "INSERT INTO images (filename, description, username) VALUES ('$fname', '$desc', '$user')");
      echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
      
    } else {
      echo '<p class="message">Sorry, there was an error uploading your file.';
    }
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

<html lang="en">
<head>
    <title>Branzpir</title>
    <link rel='branzpir icon' href='branzpir_favicon.png' type='image/x-icon'>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    body {font-size:16px;}
    table{margin:0 auto;}
    .button{margin-top:70px}
    .buttontxt{margin-top:70px}
</style>
<body>
<header class="w3-container w3-top w3-hide-small w3-highway-red w3-xlarge w3-padding">
    <b><span><a href='index.php' style='text-decoration:none'>branzpir</a></span></b>
</header>

<form method='POST' action='' enctype='multipart/form-data' style='margin-top:80px'>
    <table border='0' align='center' cellpadding='8'>
        <tr>
            <td align='right'>Choose File:</td>
            <td><input type='file' name='image' value='' accept='image/*'/></td>
        </tr>
        <tr>    
            <td align='right'>Description:</td>
            <td><input type='text' name='desc' placeholder="Enter Detailed Description Of Image" style='width:300px;' required/></td>
        </tr>
        <tr>
            <td colspan='2' align='center'><input type='submit' name='upload' value='Upload' required/></td> 
        </tr>
    </table>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$('.message').delay(3000).fadeOut('slow', function() { $(this).remove(); });
</script>
</body>

</html>
