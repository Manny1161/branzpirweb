<?php
require_once 'utils.php';
error_reporting(0);
$selected_category = $_GET['category'];
$_SESSION['cat'] = $_GET['category'];
$pro = $_SESSION['cat'];
// Program to display URL of current page.
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
$link = "https";
else $link = "http";

// Here append the common URL characters.
$link .= "://";

// Append the host(domain name, ip) to the URL.
$link .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$link .= $_SERVER['REQUEST_URI'];

// Print the link
//echo $link;

$C = connect();
$res = sqlSelect($C, 'SELECT description, category, number, address1, state, postcode, address2, facebook, linkedin, website FROM professionals WHERE username=?', 's', $_SESSION['cat']);
$img = sqlSelect($C, "SELECT filename, description, project FROM images WHERE username=?", 's', $_SESSION['cat']);
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
if($img && $img->num_rows == 1)
{
    $i = $img->fetch_assoc();
    $_SESSION['profImg'] = $i['filename'];
    $_SESSION['imgDesc'] = $i['description'];
    $_SESSION['profProj'] = $i['project'];
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
    if(!empty($_POST['image'])) {
        sqlUpdate($C, "UPDATE profileavatar SET filename=? WHERE username=?", 'ss', $_POST['image'], $_SESSION['cat']);
    }
}

$target_dir = "profileavatars/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["subBtn"])) {
  $check = getimagesize($_FILES["image"]["tmp_name"]);
  $imagedetails = getimagesize($_FILES["image"]["tmp_name"]);
  $width = $imagedetails[0];
  $height = $imagedetails[1];
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    //echo '<p class="message">File is not an image</p>';
    $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    //echo '<p class="message">Sorry, only JPG, JPEG & PNG files are allowed.</p>';
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    //echo '<p class="message">Sorry, your file was not uploaded</p>';
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $fname = $_FILES['image']['name'];
      $user = $_SESSION['cat'];
      sqlUpdate($C, "UPDATE profileavatar SET filename=? WHERE username=?", 'ss', $fname, $user);
      
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
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    .profile-head {
        transform: translateY(5rem)
    }
    .cover {
        background-image: url('uploads/home.png');
        background-size: cover;
        background-repeat: no-repeat;
    }
    .profImg{height:130px;width:130px;object-fit:cover};
    .dispImg{height:300px;width:300px;object-fit:cover};
    .brCon{display:none !important; cursor:pointer};
    .ficon{width:50px;height:5px};
    .licon{width:50px;height:5px};
    .wicon{width:50px;height:5px};
    .imgr{width:10px;height:10px};
    body {
        
        background-color: #f7f7f7;
        min-height: 100vh;
        overflow-x: hidden;
    }
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
<!--- TOP MENU ON SMALL SCREENS -->
<header class="w3-container w3-top w3-hide-large w3-highway-red w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-highway-red w3-margin-right" onclick="w3_open()">☰</a>
</header>
<!--- OVERLAY EFFECT WHEN OPENING SIDEBAR ON SMALL SCREENS -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
<div class="row py-5 px-4">
    <div class="col-md-5 mx-auto">
        <!-- Profile widget -->
        <div class="bg-white shadow rounded overflow-hidden">
            <div class="px-4 pt-0 pb-4 cover">
                <div class="media align-items-end profile-head">
        <?php
        if($pf=sqlSelect($C, 'SELECT filename FROM profileavatar WHERE username=?', 's', $_SESSION['cat']))
        {
            if($count=$pf->num_rows)
            {
                while($irow=$pf->fetch_object())
                {
        ?>
                    <div class="profile mr-3"><?php echo "<img class='profImg rounded mb-2 img-thumbnail' src='profileavatars/$irow->filename'>"?>
        <?php
                }
            }
            $pf->free();
        }
        ?>
                    <?php if($_SESSION['loggedin'] && $_SESSION['profName'] == $_SESSION['cat']) : ?>
                        <button type="button" id="editBtn" onclick="openEditProfile()" class="btn btn-outline-dark btn-sm btn-block">Edit profile</button>    
                    <?php endif?>
                    </div>
                    <div class="media-body mb-5 text-white">
                        <h4 class="mt-0 mb-0"><?php echo $_SESSION['cat']?></h4>
                        <p class="small mb-4"> <i class="fas fa-map-marker-alt mr-2"></i><?php echo $_SESSION['profAddy1']?>&nbsp;<?php echo $_SESSION['profAddy2']?></p>
                    </div>
                </div>
            </div>

            <div id="openEditProfileForm" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                    <div class="w3-center"><br>
                        <span onclick="closeEditProfile()" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Form">&times;</span>
                    </div>
                    <form action='' method='POST' enctype='multipart/form-data'>
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
                                <td align='right'>Profile Picture:</td>
                                <td><input type='file' name='image' value='' accept='image/*'/></td>
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

            <div class="bg-light p-4 d-flex justify-content-end text-center">
                <ul class="list-inline mb-0">
					<nav class="navbar navbar-expand-lg navbar-light bg-light">
					  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					  </button>
					  <div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav">
						  <li class="nav-item active">
							<a class="nav-link" onclick="openOverview()">Overview <span class="sr-only">(current)</span></a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" onclick="openReview()">Reviews</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" onclick="openContact()">Contact</a>
						  </li>
						  
						</ul>
					  </div>
					</nav>
                </ul>
            </div>

            <a href="<?php echo $_SESSION['profFacebook']?>"><img style="margin-top:5px;width:30px;height:30px" src="facebookicon.png"/></a>
            <a href="<?php echo $_SESSION['profLinkedin']?>"><img style="margin-top:5px;width:30px;height:30px" src="linkedincon.png"/></a>
            <a href="<?php echo $_SESSION['profWebsite']?>"><img style="margin-top:5px;width:30px;height:30px" src="websiteicon.png"/></a>
            
            <div id="openOverviewForm" class="px-4 py-3">
                <h5 class="mb-0">About</h5>
                <div class="p-4 rounded shadow-sm bg-light">
                    <p class="font-italic mb-0"><?php echo $_SESSION['profDesc']?></p>
                </div>
            </div>
			 <div id="openReviewForm" class="brCon px-4 py-3 " style="display:none">
                <h5 class="mb-0">Reviews</h5>
                <div class="p-4 rounded shadow-sm bg-light">
                    <p class="font-italic mb-0">Branzpir Reviews</p>
                </div>
            </div>
			 <div id="openContactForm" class="w3-modal brCon px-4 py-3" style="margin-auto">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                    <div class="w3-center"><br>
                        <span onclick="closeContact()" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Form">&times;</span>
                    </div>
                    <form method='POST' action=''>
                        <table border='0' align='center' cellpadding='8'>
                            <tr>
                                <td align='right'>Email:</td>
                                <td><input style="width:400px" type='text' placeholder="Enter your email" name='userEmail'/></td>
                            </tr>
                            <tr>
                                <td align='right'>Message:</td>
                                <td><textarea type='text' rows='7' cols='50' placeholder='Tell this pro what you have in mind for your project...' name='contactForm'></textarea></td>
                            </tr>
                        </table>
                    </form>
                    <div class="w3-container w3-border-top w3-padding-16">
                        <button onclick="closeContact()" type="button" class="w3-button w3-red">Cancel</button>
                    </div>
                    <div class="w3-container w3-border-top w3-padding-16 w3-display-bottomright">
                        <button onclick="closeContact()" type="submit" class="w3-button w3-green">Send</button>
                    </div>
                </div>
            </div>
            <div class="py-4 px-4" id="ProjectForm">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0">Projects</h5><a href="#" class="btn btn-link text-muted">Show all</a>
                </div>
                <div class="row">
                <?php
                    if($proImg=sqlSelect($C, 'SELECT filename, description, project FROM images WHERE username=?', 's', $_SESSION['cat']))
                    {
                        if($count=$proImg->num_rows)
                        {
                            while($imgRow=$proImg->fetch_object())
                            {
                                
                                ?> 
                                
                                <div class="col-lg-6 pr-lg-1 mb-2">
                                    <?php echo "<a href='#$imgRow->project'><img style='height:300px; width:550px; object-fit:cover;' onclick='openImage(this)' class='img-fluid rounded shadow-sm' src='uploads/$imgRow->filename' alt='$imgRow->project'/></a>";
                                      ?>
                                      <div id="openImageForm" class="w3-modal " style="padding-top:0" onclick="this.style.display='none'">
                                        <!--span class="w3-button w3-black w3-xxlarge w3-display-topright">x</span-->
                                        <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
                                            <img id="profImg"  style="object-fit:cover;height:50%;width:50%;float:left">
                                            <?php
                                            
                                                if($pf=sqlSelect($C, 'SELECT filename FROM images WHERE username=? AND project=?', 'ss', $_SESSION['cat'], $imgRow->project))
                                                {
                                                    if($count=$pf->num_rows)
                                                    {
                                                        while($irow=$pf->fetch_object())
                                                        {
                                                            ?>
                                                            <div class="container w3-white" style="width:50%;height:50%;float:left">
                                                                <div class="row">
                                                                    <div class="col-6 col-sm-4">
                                                                    
                                                                        <?php echo "<img style='width:150px;height:150px' src='uploads/$irow->filename'>"?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <?php
                                                        }
                                                    }
                                                    $pf->free();
                                                }
                                            ?>
                                        </div>
                                            </div>
                        
                                </div>
                            
                            
                            
                                <?php
                            }
                        }
                        $proImg->free();
                    }    
                ?>
                </div>
            </div>
            <!--div id="openImageCard" class="ecommerce-gallery px-4" style="display:none">
                <div class="row py-3">
                    <div class="col-6 mb-1">
                        <div class="lightbox">
                        <-?php
                    if($proImg=sqlSelect($C, 'SELECT filename FROM images WHERE username=? GROUP BY project LIMIT 1', 's', $_SESSION['cat']))
                    {
                        if($count=$proImg->num_rows)
                        {
                            while($imgRow=$proImg->fetch_object())
                            {
                                ?>
                                 
                            <-?php
                                
                                
                                
                                echo "<img src='uploads/$imgRow->filename' class='ecommerce-gallery-main-img active w-100 img-fluid rounded shadow-sm' style='height:300px;object-fit:cover'/>"?>
                            <-?php
                            }
                        }
                        $proImg->free();
                    }    
                ?>
                        </div>
                </div>
                
                
                
               <div class="col-lg-6 pr-lg-1 mb-2 " style="width:50;%height:50%;display:flex;flex-flow:row wrap;justify-content:between">
                
                <-?php
               

                            if($proImg=sqlSelect($C, 'SELECT filename FROM images WHERE username=? AND project=?', 'ss', $_SESSION['cat'], $iname))
                            {
                                if($count=$proImg->num_rows)
                                {
                                    while($imgRow=$proImg->fetch_object())
                                    {
                                        
                                        ?>

                                        
                                            <div class="row" style=";width:200px;height:150px;flex-grow:0;flex-shrink:0;flex-basis:calc(50%-10px); margin-top:1px;">
                                                
                                                    <div class="row row-cols-2 px-3">
                                                    
                                                        <-?php echo "<img style='width:150px;height:148px;object-fit:cover;' class='img-fluid rounded shadow-sm' src='uploads/$imgRow->filename'>"?>
                                                        
                                                    </div>
                                                
                                                
                                            </div>
                                
                            

                                
                                    
                
                <-?php
                                    }
                                }
                            $proImg->free();
                            }
                        
                ?>
                </div>
                
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Location</h4>
                            <p>Welshpool WA</p>
                            <br><br><br><h4>Description</h4>
                            <p><-?php echo $ff;?></p>
                        </div>
                        <div class="col-lg-6">
                            <h4>Budget</h4>
                            <p>$1,000,000 or contact for more info</p>
                            <br><br><br><h4>Time To Completion</h4>
                            <p>4 Weeks <-?php echo $iname?></p>
                        </div>
                    </div>
                </div>
            </div-->
            <div id="openImageForm" class="w3-modal " style="padding-top:0" onclick="this.style.display='none'">
                <!--span class="w3-button w3-black w3-xxlarge w3-display-topright">x</span-->
                <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
                    <img id="profImg"  style="object-fit:cover;height:50%;width:50%;float:left">
                    <?php
                    
                        if($pf=sqlSelect($C, 'SELECT filename, project FROM images WHERE username=?', 's', $_SESSION['cat']))
                        {
                            if($count=$pf->num_rows)
                            {
                                while($irow=$pf->fetch_object())
                                {
                                    ?>
                                    <div class="container w3-white" style="width:50%;height:50%;float:left">
                                        <div class="row">
                                            <div class="col-6 col-sm-4">
                                            
                                                <?php echo "<img style='width:150px;height:150px' src='uploads/$irow->filename'>"?>
                                            </div>
                                        </div>
                                    
                                    
                                    <?php
                                }
                            }
                            $pf->free();
                        }
                    ?>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script src="index.js"></script>
</body>
</html>
