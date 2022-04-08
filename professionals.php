<?php
    <?php
    require_once 'utils.php';
    //error_reporting(0);
    $C = connect();
    
?>
<html lang="en">
<head>
<title>branzpir</title>
    <link rel='branzpir icon' href='branzpir_favicon.png' type='image/x-icon'>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    body {font-size:16px;}
    .w3-half img{margin-bottom:-6px;margin-top:16px;opactiy:0.8;cursor:pointer}
    .w3-half img:hover{opacity:1}
    table{margin:0 auto;}
    
    .br-img{width:342; height:192; padding:5px}
    .br-img-txt {display:inline-block;vertical-align:top}
    .br-img-desc{display:inline;vertical-align:top}
    .box{display:flex; align-items:flex-start}
    .search{width:400px; height:40px; text-align:center}
    .sub{height:40px;}
    .main-container{
        float: left;
        position:relative;
        left: 50%;
    }
    .fixer-container{
        float:left;
        position: relative;
        left: -50%;
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

<!---main-content--->
<h2 style="text-align:center; margin-top:70px ">Find the right pro for your project</h2>

<div class="main-container">
    <div class="fixer-container">
        <form action='' method='POST'>
            <input class="search" type="text" name="search" placeholder="What service do you need?"/>
            <input class="sub" type="submit" name="submit" value="Search"/>
        </form>
    </div>
</div>
        <?php
        if(isset($_POST['submit']))
        {
            $search = $_POST['search'];
            if($pro1=sqlSelect($C, "SELECT p.username, p.category, p.description, p.number, p.address1, p.address2, p.postcode, p.state FROM professionals p INNER JOIN images i ON p.username=i.username WHERE p.category LIKE '%$search%' OR p.username LIKE '%$search%' AND i.username LIKE '%$search%'"));
            {
                if($img1=sqlSelect($C, "SELECT i.filename FROM images i INNER JOIN professionals p WHERE i.username=p.username AND p.category LIKE '%$search%' OR i.username LIKE '%$search%'"))
                {
                    if($count1=$pro1->num_rows)
                    {
                        if($count1=$img1->num_rows)
                        {
                            while(($prow1=$pro1->fetch_object()) && ($irow1=$img1->fetch_object()))
                            {
        ?>
                            
                            <div class="w3-main" style="margin-left:340px;margin-right:40px;margin-top:80px">
                                <div class="box">
                                    <?php echo "<img class='br-img' src='uploads/$irow1->filename'>"?>
                                    <?php echo "<span><b><a href='profProfile.php?category=$prow1->username'>$prow1->username</a></b><br><q>$prow1->description</q><br></span>"?>
                                </div>
                            </div>                            
        <?php
                            }
                        }
                    $pro1->free();
                    $img1->free();
                    }
                }
            }
        }
        ?>
    

<div class="w3-main" style="margin-left:340px;margin-right:40px;margin-top:80px">
    <?php
        if($pro=sqlSelect($C, 'SELECT p.username, p.description, p.number, p.address1, p.address2, p.postcode, p.state FROM professionals p INNER JOIN images i ON p.username=i.username'))
        {
            if($img=sqlSelect($C, 'SELECT filename FROM images GROUP BY username'))
            {
                if($count=$pro->num_rows)
                {
                    if($count=$img->num_rows)
                    {
                        while(($prow=$pro->fetch_object()) && ($irow=$img->fetch_object()))
                        {    
    ?>
                            <div class="box">
                                <?php echo "<img class='br-img' src='uploads/$irow->filename'>"?>
                                <?php echo "<span><b><a href='profProfile.php?category=$prow->username'>$prow->username</a></b><br><q>$prow->description</q><br>"?>
                            </div>                            
    <?php
                        }
                    }
                    $pro->free();
                    $img->free();
                }
            }
        }
    ?>
    <div class="w3-container w3-padding-32" style="margin-top:75px;padding-right:18px; width:100%; margin-left:0px;">
        <span class="w3-left">&copy; Copyright 2022 Branzpir</span><span class="w3-right">Powered by <a href="https://eurotechdisplays.com.au/" class="foot-link" title="Eurotech" target="_blank" class="w3-hover-opacity" style='text-decoration:none'>Eurotech</a></span>
    </div>
</div>
<script src='index.js'></script>
</body>

</html>
