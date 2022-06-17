<?php
require_once 'utils.php';
include 'sendEmail.php';
include 'uploadSpaces.php';
//error_reporting(0);
$selected_category = $_GET['category'];
$_SESSION['cat'] = $_GET['category'];
$pro = $_SESSION['cat'];


$C = connect();
$res = sqlSelect($C, 'SELECT email, description, category, number, address1, state, postcode, address2, facebook, linkedin, website FROM professionals WHERE username=?', 's', $_SESSION['cat']);
$img = sqlSelect($C, "SELECT filename, description, project FROM images WHERE username=?", 's', $_SESSION['cat']);
if($res && $res->num_rows == 1)
{
    $q = $res->fetch_assoc();
    $_SESSION['profEmail'] = $q['email'];
    $_SESSION['profDesc'] = $q['description'];
    $_SESSION['profCat'] = $q['category'];
    $_SESSION['profNum'] = $q['number'];
    $_SESSION['profAddy1'] = $q['address1'];
    $_SESSION['profAddy2'] = $q['address2'];
    $_SESSION['profSuburb'] = $q['suburb'];
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
    if(!empty($_POST['suburb'])) {
        sqlUpdate($C, "UPDATE professionals SET suburb=? WHERE username=?", 'ss', $_POST['suburb'], $_SESSION['cat']);
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
    if(!empty($_POST['bimage'])) {
        sqlUpdate($C, "UPDATE profilebanner SET filename=? WHERE username=?", 'ss', $_POST['bimage'], $_SESSION['cat']);
    }
}


$target_dir = "profileavatars/";
$target_dir2 = "profilebanners/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$target_file2 = $target_dir2 . basename($_FILES["bimage"]["name"]);
$uploadOk = [];
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["subBtn"]) && !empty($_POST['image'])) {
  $check = getimagesize($_FILES["image"]["tmp_name"]);
  $imagedetails = getimagesize($_FILES["image"]["tmp_name"]);
  $width = $imagedetails[0];
  $height = $imagedetails[1];
  if($check == false || $check2 == false) {
    //echo '<p class="message">File is not an image</p>';
    $uploadOk[] = 1;
    } 
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    //echo '<p class="message">Sorry, only JPG, JPEG & PNG files are allowed.</p>';
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if (count($uploadOk) != 0) {
    //echo '<p class="message">Sorry, your file was not uploaded</p>';
    // if everything is ok, try to upload file
} elseif(count($uploadOk==0)) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $fname = $_FILES['image']['name'];
      $user = $_SESSION['cat'];

      sqlUpdate($C, "UPDATE profileavatar SET filename=? WHERE username=?", 'ss', $fname, $user);
      
    } else {
      //echo '<p class="message">Sorry, there was an error uploading your file.';
    }
  }
}

if(isset($_POST["subBtn"])) {
    $check = getimagesize($_FILES["bimage"]["tmp_name"]);
    $imagedetails = getimagesize($_FILES["bimage"]["tmp_name"]);
    $width = $imagedetails[0];
    $height = $imagedetails[1];
    if($check == false) {
      ///echo '<p class="message">File is not an image</p>';
      $uploadOk[] = 1;
      } 
    // Allow certain file formats
    if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg") {
      //echo '<p class="message">Sorry, only JPG, JPEG & PNG files are allowed.</p>';
      $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if (count($uploadOk) != 0) {
      //echo '<p class="message">Sorry, your file was not uploaded</p>';
      // if everything is ok, try to upload file
  } elseif(count($uploadOk==0)) {
      if (move_uploaded_file($_FILES["bimage"]["tmp_name"], $target_file2)) {
        $fname = $_FILES['bimage']['name'];
        $user = $_SESSION['cat'];
  
        sqlUpdate($C, "UPDATE profilebanner SET filename=? WHERE username=?", 'ss', $fname, $user);
        
      } else {
        //echo '<p class="message">Sorry, there was an error uploading your file.';
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
    
    
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    .profile-head {
        transform: translateY(5rem)
    }
    pre{font-family: "Poppins", san-serif; white-space: pre-line}
    .cover {
        <?php
        if($bf=sqlSelect($C, 'SELECT filename FROM profilebanner WHERE username=?', 's', $_SESSION['cat']))
        {
            if($count=$bf->num_rows)
            {
                while($irow=$bf->fetch_object())
                {
        ?>
                    background-image: url('profilebanners/<?php echo $irow->filename?>');
        <?php
                }
            }
            $bf->free();
        }
        ?>
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
        <a href="findProfessionals.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Find Professionals</a> 
        <a href="contact.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Contact</a>
        <a href="youandbranzpir.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">You and Branzpir</a>
    </div>
</nav>
<!--- TOP MENU ON SMALL SCREENS -->
<header class="w3-container w3-top w3-hide-large w3-highway-red w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-highway-red w3-margin-right" onclick="w3_open()">☰</a>
</header>
<?php echo $alert;?>
<!--- OVERLAY EFFECT WHEN OPENING SIDEBAR ON SMALL SCREENS -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
<div class="row py-5 px-4">
    <div class="col-lg-5 mx-auto">
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
                        <p class="small mb-4"> <i class="fas fa-map-marker-alt mr-2"></i><?php echo $_SESSION['profAddy1']?>&nbsp;<?php echo $_SESSION['profAddy2']?>&nbsp;<?php echo $_SESSION['profSuburb']?></p>
                    </div>
                </div>
            </div>
            <div id="openUploadForm" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:1000px;margin-top:-10px">
                    <div class="w3-center"><br>
                        <span onclick="closeUpload()" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Form">&times;</span>
                    </div>
                    <div class="container" style="margin:5px;padding:5px">
                        <form class="row g-3" method='POST' action='' enctype='multipart/form-data'>
                            <div class="col-md-4">
                                <label class="form-label">Project Name</label>
                                <input type="text" class="form-control" name='projName' placeholder="Enter Name of Project" required>
                            </div>
                            <div class="col-4">
                                <br>
                                <label class="form-label">Duration of Project</label>
                                <select name="time">
                                    <option value="1 Week">1 Week</option>
                                    <option value="2-4 Weeks">2-4 Weeks</option>
                                    <option value="4+ Weeks">4 Weeks+</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <br>
                                <label class="form-label">Category</label>
                                <select name="category">
                                    <option value="indoors">Indoors</option>
                                    <option value="outdoors">Outdoors</option>
                                    <option value="building">Building</option>
                                    <option value="digital">Digital</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Choose File</label>
                                <input type="file" class="form-control" name='images[]' accept="image/*" multiple>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name='loc' required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Cost</label>
                                <input type="text" class="form-control" name='cost' placeholder="Enter Cost of Project, e.g. $1000" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Project Description</label>
                                <textarea class="form-control" type='text' rows='3' cols='50' placeholder='Give a brief description of your business, services you offer etc. ' name='desc' required></textarea>
                            </div>
                            <div class="col-12">
                                <br>
                                <button type="submit" class="btn btn-danger" name='upload'>Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>                      

            <div id="openEditProfileForm" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px;margin-top:-10px">
                    <div class="w3-center"><br>
                        <span onclick="closeEditProfile()" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Form">&times;</span>
                    </div>
                    <form action='' method='POST' enctype='multipart/form-data'>
                    <div class="container" style="margin:5px;padding:5px">
                        <form class="row g-3" method='POST' action='' enctype='multipart/form-data'>
                            <div class="col-md-12">
                                <label class="form-label">Business Name</label>
                                <input type="text" class="form-control" name='username' placeholder="Enter Username">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name='number' placeholder="For potential clients to reach you">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Address Line 1</label>
                                <input class='form-control' type='text'  placeholder='Enter business address' name='addy1'>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Address Line 2</label>
                                <input class='form-control' type='text' name='addy2'>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Suburb</label>
                                <input class='form-control' type='text'  placeholder='Enter suburb' name='suburb'>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Postcode</label>
                                <input class='form-control' type='text'  placeholder='Enter postcode' name='post-code'>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <label class="form-label">State</label>
                                <select name="state">
                                    <option value="ACT">Australian Capital Territory</option>
                                    <option value="NSW">New South Wales</option>
                                    <option value="NT">Northern Territory</option>
                                    <option value="QLD">Queensland</option>
                                    <option value="SA">South Australia</option>
                                    <option value="TAS">Tasmania</option>
                                    <option value="VIC">Victoria</option>
                                    <option value="WA">Western Australia</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Business Description</label>
                                <textarea class="form-control" type='text' rows='3' cols='50' placeholder='Give a brief description of your business, services you offer etc. ' name='business-desc'></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Website URL</label>
                                <input class='form-control' type='text'  placeholder='Add your website URL' name='weburl'>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">LinkedIn</label>
                                <input class='form-control' type='text'  placeholder='Add your LinkedIn Profile URL' name='linkedin'>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Facebook</label>
                                <input class='form-control' type='text'  placeholder='Add your Facebook URL' name='facebook'>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" name='image' accept="image/*">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Banner Picture</label>
                                <input type="file" class="form-control" name='bimage' accept="image/*">
                            </div>       
                            <div class="col-md-12">
                                <br>
                                <button type="submit" class="btn btn-danger" name='subBtn'>Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="w3-container w3-border-top w3-padding-16">
                        <button onclick="closeEditProfile()" type="button" class="w3-button w3-red">Cancel</button>
                    </div>
                </div>          
            </div>
            <script src="index.js"></script>

            <div class="bg-light p-4 d-flex justify-content-end text-center">
                <ul class="list-inline mb-0">
					<nav class="navbar navbar-expand-lg navbar-light bg-light">
					  <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					  </button>
					  <div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav">
						  <li class="nav-item">
							<a class="nav-link" href="#OverviewForm" onclick="openOverview()">Overview <span class="sr-only">(current)</span></a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="#ProjectForm">Projects</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="#ContactForm" onclick="openContact()">Contact</a>
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
                    <pre class="font-italic mb-0"><?php echo $_SESSION['profDesc']?></pre>
                </div>
            </div>
			 <div id="openReviewForm" class="brCon px-4 py-3 " style="display:none">
                <h5 class="mb-0">Reviews</h5>
                <div class="p-4 rounded shadow-sm bg-light">
                    <p class="font-italic mb-0">Branzpir Reviews</p>
                </div>
            </div>
			 <div id="openContactForm" class="px-4 py-3" style="display:none">
                <h5 class="mb-0">About</h5>
                    <div class="p-4 rounded shadow-sm bg-light">
                    <form class="row g-3" method="POST">
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control shadow-sm bg-light" name='userEmail' placeholder="Enter your Email">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Message</label>
                            <textarea class="form-control shadow-sm bg-light" type="text" rows='7' cols='50'  name='contactForm' placeholder="Tell this pro what you have in mind for your project..."></textarea>
                        </div>
                        <div class="col-12">
                            <br>
                            <button type="submit" class="btn btn-success" name='submit'>Send</button>
                        </div>
                    </form>
                    </div>
            </div>              
            <div class="py-4 px-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0">Projects</h5>
                    <?php if($_SESSION['loggedin'] && $_SESSION['profName'] == $_SESSION['cat']) : ?>
                        <button class="btn btn-outline-dark btn-sm" onclick="openUpload()">Upload File(s)</button>
                    <?php endif?>
                        
                </div>
                <div class="row" id="ProjectForm">
                <?php
                    if($proImg=sqlSelect($C, 'SELECT filename, description, project FROM images WHERE username=? GROUP BY project', 's', $_SESSION['cat']))
                    {
                        if($count=$proImg->num_rows)
                        {
                            while($imgRow=$proImg->fetch_object())
                            {                               
                                ?>                                
                                <div class="col-lg-6 pr-lg-1 mb-2">
                                    <?php echo "<a href='projectGallery.php?project=$imgRow->project'><img style='height:300px; width:550px; object-fit:cover;' onclick='openImages()' class='img-fluid rounded shadow-sm' src='uploads/$imgRow->filename'/></a>";
                                      ?>
                                </div>
                                <?php
                            }
                        }
                        $proImg->free();
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
