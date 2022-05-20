<?php
require_once 'utils.php';
$C = connect();
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
    .list-group {
        max-height:100px;
        overflow:scroll;
        -webkit-overflow-scrolling: touch;
    }
    .vertical-scrollable>.row {
            position: absolute;
            width:300px;
            overflow-y: scroll;
    }
    .col-sm-8 {
        text-align:left;
        background:grey;
        font-size: 16px;
        border-style:solid;
        border-color:grey;
    }
    .col-sm-8:nth-child(2n+1) {
        background: grey;
        border-style:solid;
        border-color:grey;
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
    <div class="col-md-4 mx-auto">
        <!-- Profile widget -->
        <div class="bg-white shadow rounded overflow-hidden">
        <p>Where do you need your project done?</p>
        <div class="vertical-scrollable">
            <div class="row text-center">       
            <?php
            if($loc = sqlSelect($C, 'SELECT postcode, suburb FROM professionals GROUP BY postcode'))
            {
                if($count=$loc->num_rows)
                {
                    while($geo=$loc->fetch_object())
                    {
                        ?>
                            <div class="col-sm-12">
                            <?php echo $geo->postcode?> - <?php echo $geo->suburb?>
                            </div>  
                        <?php
                    }
                }
            }
            ?>      
            </div>
        </div>
        <div class="col">
            
        </div>
    </div>
    </div>
</div>
<script src="index.js"></script>
</body>
</html>