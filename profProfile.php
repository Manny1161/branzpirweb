

<?php
require_once 'utils.php';
error_reporting(0);
$selected_category = $_GET['category'];
$_SESSION['cat'] = $_GET['category'];
$pro = $_SESSION['cat'];
$C = connect();
$res = sqlSelect($C, 'SELECT description, category, number, address1, state, postcode, address2, facebook, linkedin, website FROM professionals WHERE username=?', 's', $_SESSION['cat']);
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
    $_SESSION['profFacebook'] = $q['facebook'];
    $_SESSION['profLinkedin'] = $q['linkedin'];
    $_SESSION['profWebsite'] = $q['website'];
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
if(isset($_POST['subBtn'])){
    if(!empty($_POST['category'])) {
        sqlUpdate($C, "UPDATE professionals SET category=? WHERE username=?", 'ss', $_POST['category'], $_SESSION['cat']);
    }
    if(!empty($_POST['addy1'])) {
        sqlUpdate($C, "UPDATE professionals SET address1=? WHERE username=?", 'ss', $_POST['addy1'], $_SESSION['cat']);
    }
    if(!empty($_POST['addy2'])) {
        sqlUpdate($C, "UPDATE professionals SET address2=? WHERE username=?", 'ss', $_POST['addy2'], $_SESSION['cat']);
    }
    if(!empty($_POST['state'])) {
        sqlUpdate($C, "UPDATE professionals SET state=? WHERE username=?", 'ss', $_POST['state'], $_SESSION['cat']);
    }
    if(!empty($_POST['post-code'])) { 
        sqlUpdate($C, "UPDATE professionals SET postcode=? WHERE username=?", 'ss', $_POST['post-code'], $_SESSION['cat']);
    }
    if(!empty($_POST['business-desc'])) {
        sqlUpdate($C, "UPDATE professionals SET description=? WHERE username=?", 'ss', $_POST['business-desc'], $_SESSION['cat']);
    } 
    if(!empty($_POST['number'])) {
        sqlUpdate($C, "UPDATE professionals SET number=? WHERE username=?", 'ss', $_POST['number'], $_SESSION['cat']);
    }  
    if(!empty($_POST['facebook'])) {
        sqlUpdate($C, "UPDATE professionals SET facebook=? WHERE username=?", 'ss', $_POST['facebook'], $_SESSION['cat']);
    }
    if(!empty($_POST['linkedin'])) {
        sqlUpdate($C, "UPDATE professionals SET linkedin=? WHERE username=?", 'ss', $_POST['linkedin'], $_SESSION['cat']);
    }
    if(!empty($_POST['weburl'])) {
        sqlUpdate($C, "UPDATE professionals SET website=? WHERE username=?", 'ss', $_POST['weburl'], $_SESSION['cat']);
    }
}

$target_dir = "profileavatars/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

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
      $user = $_SESSION['cat'];
      $res = sqlInsert($C, "INSERT INTO profileavatar (filename, username) VALUES ('$fname', '$user')");
      
    } else {
      echo '<p class="message">Sorry, there was an error uploading your file.';
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
    #textBox{display:none;}
    #subBtn{display:none;}
    .mainImg{width:100%; height: 490px;padding-top:15px}
    .centered{position:absolute;top:350px;margin-left:155px;width:100%}
    .profImg{ position:absolute;margin-top:-152px;}
    .camera1{position:absolute; margin-left:115px; width:20%; cursor:pointer}
    .bannerImg{position:relative;}
    .ficon{width:2%}
    .licon{width:2%}
    .wicon{width:2%}
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



<?php
    if($proImg=sqlSelect($C, 'SELECT filename FROM profileavatar WHERE username=?', $_SESSION['cat']))
    {
        if($count=$proImg->num_rows)
        {
            while($imgRow=$proImg->fetch_object())
            {
            }
        }
        $proImg->free();
    }    

?>
<div class="w3-main" style="margin-left:340px;margin-right:40px">
    <div class="w3-row-padding">
        <div class="bannerImg"><img src="uploads/home.png" class="mainImg"></div>
        <?php
            //sqlUpdate($C, 'DELETE FROM profileavatar WHERE username=?', 's', $_SESSION['cat']);
            if($pf=sqlSelect($C, 'SELECT p1.filename FROM profileavatar p1 INNER JOIN profileavatar p2 ON p1.username=p2.username AND p1.id > p2.id WHERE p2.username=?', 's', $_SESSION['cat']))
            {
                if($count=$pf->num_rows)
                {
                    while($irow=$pf->fetch_object())

                    {
        ?>
                        <div class="profImg">
                            <?php if($_SESSION['loggedin'] && $_SESSION['profName'] == $_SESSION['cat']) : ?>
                            <img src="camera.png" class="camera1" onclick="openProfilePicture()">
                            <div id="openProfilePictureForm" class="w3-modal">
                                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                                    <div class="w3-center"><br>
                                        <span onclick="closeProfilePicture()" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Form">&times;</span>
                                    </div>
                                    <form method='POST' action='' enctype='multipart/form-data' style='margin-top:80px'>
                                        <table border='0' align='center' cellpadding='8'>
                                            <tr>
                                                <td align='right'>Choose File:</td>
                                                <td><input type='file' name='image' value='' accept='image/*'/></td>
                                            </tr>
                                            <tr>
                                                <td colspan='2' align='center'><input type='submit' name='upload' value='Upload' required/></td> 
                                            </tr>
                                        </table>
                                    </form>
                                    <div class="w3-container w3-border-top w3-padding-16">
                                        <button onclick="closeProfilePicture()" type="button" class="w3-button w3-red">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <?php endif?>
                            <?php echo "<img style='width:150px; height:150px;'src='profileavatars/$irow->filename'>" ?>
                        </div>
<?php
                    }
                }
                $pf->free();
            }    

?>
        <!--div class="profImg">
            <-?php echo "<img style='width:150px; height:150px;'src='uploads/$fileoriginal'>" ?>
        </div-->
        <div class="centered">
            <h2 style="color:white"><b><?php echo $_SESSION['cat']?></b></h2>
            <div display="flex"><span style="color:white"><?php echo $_SESSION['profAddy1'];?>&nbsp;<?php echo $_SESSION['profAddy2'];?></span></div>
            <div display="flex"><span style="color:white"><?php echo $_SESSION['profState'];?>&nbsp;<?php echo $_SESSION['profPost'];?></span></div>
            <div display="flex"><span style="color:white"><?php echo $_SESSION['profNum'];?>
        </div>
    </div>

    

    <div class="w3-left">
        <div class="w3-container">
            <h5><span style="color:grey"><?php echo $_SESSION['profCat'];?></span></h5>
            <a href="<?php echo $_SESSION['profFacebook']?>"><img class="ficon" src="facebookicon.png"/></a>
            <a href="<?php echo $_SESSION['profLinkedin']?>"><img class="licon" src="linkedincon.png"/></a>
            <a href="<?php echo $_SESSION['profWebsite']?>"><img class="wicon" src="websiteicon.png"/></a>
        </div>
    </div>
        
    <div class="w3-left">
        <div class="w3-container" style="width:400px">
            <div class="desc"><?php echo $_SESSION['profDesc'];?></span></div>
        </div>
    </div>

    

    <div class="w3-right">
        <div class="w3-container">
        <?php
            if($_SESSION['loggedin'] && $_SESSION['profName'] == $_SESSION['cat']) : ?>
            <button type="button" id="editBtn" style="margin-top:-60px" onclick="openEditProfile()">Edit Profile</button>
            <div id="openEditProfileForm" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                    <div class="w3-center"><br>
                        <span onclick="closeEditProfile()" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Form">&times;</span>
                    </div>
                    <form action='' method='POST'>
                        <table border='0' align='center' cellpadding='8'>
                            <tr>
                                <td align='right'>Business Name:</td>
                                <td><input class='inpt' type='text' placeholder="Enter Username" name='username'/></td>
                            </tr>
                            <tr>
                                <td align='right'>Professional Category:</td>
                                <td><input class='inpt' type='text' placeholder="e.g. Sign Printing" name='category'/></td>
                            </tr>
                            <tr>
                                <td align='right'>Phone Number:</td>
                                <td><input class='inpt' type='text' placeholder="For potential clients to reach you" name='number'/></td>
                            </tr>
                            <tr>
                                <td align='right'>Address Line 1:</td>
                                <td><input class='inpt' type='text'  placeholder='Enter business address' name='addy1'/></td>
                            </tr>
                            <tr>
                                <td align='right'>Address Line 2:</td>
                                <td><input class='inpt' type='text' name='addy2'/></td>
                            </tr>
                            <tr>
                                <td align='right'>Postcode:</td>
                                <td><input class='inpt' type='text' placeholder='Enter postcode' name='post-code'/></td>
                            </tr>
                            <tr>
                                <td align='right'>State:</td>
                                <td required>
                                    <select name="state">
                                        <option value="NULL">Select State</option>
                                        <option value="ACT">Australian Capital Territory</option>
                                        <option value="NSW">New South Wales</option>
                                        <option value="NT">Northern Territory</option>
                                        <option value="QLD">Queensland</option>
                                        <option value="SA">South Australia</option>
                                        <option value="TAS">Tasmania</option>
                                        <option value="VIC">Victoria</option>
                                        <option value="WA">Western Australia</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align='right'>Business Description:</td>
                                <td><textarea type='text' rows='3' cols='50' placeholder='Give a brief description of your business, services you offer etc. ' name='business-desc'></textarea></td>
                            </tr>
                            <tr>
                                <td align='right'>Website URL:</td>
                                <td><input class='inpt' type='text' placeholder='Add website URL' name='weburl'/></td>
                            </tr>
                            <tr>
                                <td align='right'>LinkedIn:</td>
                                <td><input class='inpt' type='text' placeholder='Add LinkedIn Profile URL' name='linkedin'/></td>
                            </tr>
                            <tr>
                                <td align='right'>Facebook:</td>
                                <td><input class='inpt' type='text' placeholder='Add Facebook profile URL' name='facebook'/></td>
                            </tr>
                            <tr>
                                <td colspan='2' align='center'><input type='SUBMIT' name='subBtn' value='Save'/></td>
                            </tr>
                        </table>
                    </form>
                    <div class="w3-container w3-border-top w3-padding-16">
                        <button onclick="closeEditProfile()" type="button" class="w3-button w3-red">Cancel</button>
                    </div>
                </div>
                
            </div>
            <script src="index.js"></script>
        <?php endif?>
        </div>
    </div>


    <div class="w3-container">
        <div class="w3-row-padding">
            <br><h5><span style="color:grey">Projects</span></h5>
        </div>
    </div>

    <!--- SORT THIS OUT, SOMETHING TO DO WITH THE FOR LOOP WHEN SEARCHING FOR THE IMAGES IN THE DIRECTORY, CHANGE IT TO HOW IVE DONE FOR THE PROFESSIOANLS PAGE --->
    <div class="w3-row">
<?php
    if($proImg=sqlSelect($C, 'SELECT filename, description FROM images WHERE username=?', 's', $_SESSION['cat']))
    {
        if($count=$proImg->num_rows)
        {
            while($imgRow=$proImg->fetch_object())
            {
?>
                
                <div class="w3-third">
                    <?php echo "<img src='uploads/$imgRow->filename' style='width:100%; height:50%; padding:5px'> " ?>
                </div>
            
<?php
            }
        }
        $proImg->free();
    }    

?>
    </div>

<script src="index.js"></script>
</body>
</html>
