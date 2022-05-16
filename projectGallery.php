<?php
require_once 'utils.php';
//error_reporting(0);
$_SESSION['proj'] = $_GET['project'];

$C = connect();
$res = sqlSelect($C, 'SELECT description, category, number, address1, state, postcode, address2, facebook, linkedin, website FROM professionals WHERE username=?', 's', $_SESSION['cat']);
$img = sqlSelect($C, 'SELECT filename, description, project FROM images WHERE username=? AND project=?', 'ss', $_SESSION['cat'], $_SESSION['proj']);
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
if($img && $img->num_rows)
{
    $i = $img->fetch_assoc();
    $_SESSION['profImg'] = $i['filename'];
    $_SESSION['imgDesc'] = $i['description'];
    $_SESSION['profProj'] = $i['project'];
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
                    </div>
                    <div class="media-body mb-5 text-white">
                        <h4 class="mt-0 mb-0"><?php echo $_SESSION['cat']?></h4>
                        <p class="small mb-4"> <i class="fas fa-map-marker-alt mr-2"></i><?php echo $_SESSION['profAddy1']?>&nbsp;<?php echo $_SESSION['profAddy2']?></p>
                    </div>
                </div>
            </div>

            

            

            
            <div class="py-4 px-4" id="ProjectForm">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 style='text-align:left; margin-top:25px'><?php echo $_SESSION['proj']?><h4>
                        <br><br>    
                </div>
                <p><?php echo $_SESSION['imgDesc']?></p>
                <p><?php echo $_SESSION['imgTime']?></p>
                <p><?php echo $_SESSION['imgLoc']?></p>
                <p><?php echo $_SESSION['imgCost']?></p>
                <!---div class="container-fluid">
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
                </div--->
                <div class="row">
                <?php
                    if($proImg=sqlSelect($C, 'SELECT filename, description, project FROM images WHERE username=? AND project=?', 'ss', $_SESSION['cat'], $_SESSION['proj']))
                    {
                        if($count=$proImg->num_rows)
                        {
                            while($imgRow=$proImg->fetch_object())
                            {
                                
                                ?> 
                                
                                <div class="col-lg-6 pr-lg-1 mb-2">
                                    
                                    <?php echo "<img style='height:300px; width:550px; object-fit:cover;' onclick='openImages()' class='img-fluid rounded shadow-sm' src='uploads/$imgRow->filename'/></a>";
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
            <div id="openImageCard" class="ecommerce-gallery px-4" style="display:none">
                <div class="row py-3">
                    <div class="col-6 mb-1">
                        <div class="lightbox">
                        <?php
                    if($proImg=sqlSelect($C, 'SELECT filename FROM images WHERE username=? GROUP BY project LIMIT 1', 's', $_SESSION['cat']))
                    {
                        if($count=$proImg->num_rows)
                        {
                            while($imgRow=$proImg->fetch_object())
                            {
                                ?>
                                 
                            <?php
                                
                                
                                
                                echo "<img src='uploads/$imgRow->filename' class='ecommerce-gallery-main-img active w-100 img-fluid rounded shadow-sm' style='height:300px;object-fit:cover'/>"?>
                            <?php
                            }
                        }
                        $proImg->free();
                    }    
                ?>
                        </div>
                </div>
                
                
                
               <div class="col-lg-6 pr-lg-1 mb-2 " style="width:50;%height:50%;display:flex;flex-flow:row wrap;justify-content:between">
                
                <?php
               

                            if($proImg=sqlSelect($C, 'SELECT filename FROM images WHERE username=? AND project=?', 'ss', $_SESSION['cat'], $iname))
                            {
                                if($count=$proImg->num_rows)
                                {
                                    while($imgRow=$proImg->fetch_object())
                                    {
                                        
                                        ?>

                                        
                                            <div class="row" style=";width:200px;height:150px;flex-grow:0;flex-shrink:0;flex-basis:calc(50%-10px); margin-top:1px;">
                                                
                                                    <div class="row row-cols-2 px-3">
                                                    
                                                        <?php echo "<img style='width:150px;height:148px;object-fit:cover;' class='img-fluid rounded shadow-sm' src='uploads/$imgRow->filename'>"?>
                                                        
                                                    </div>
                                                
                                                
                                            </div>
                                
                            

                                
                                    
                
                <?php
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