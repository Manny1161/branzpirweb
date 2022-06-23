<style>
  .message{color:red}
</style>

<?php
require_once 'utils.php';
error_reporting(0);
$C = connect();
$_SESSION['home'] = $_GET['search'];


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
    /*.smallSearch @media all and (max-width:992px){input[type=text]{width:250px;position:absolute;left:210px;top:5px;box-sizing:border-box;border:2px solid #ccc;border-radius:30px;font: size 12px;
    background-color:white;background-position:10px 10px;background-repeat:no-repeat;padding:5px 10px 12px 30px;
    -webkit-transition: width:0.4s ease-in-out;}}
    input[type=text]:focus{width:50%}*/

    /*CHECK IF SCREEN IS LESS THAN 601 PIXELS FOR LARGER SCREENS
    @media all and (max-width:601px){input[type=text]{width:250px;position:absolute;left:200px;top:5px;box-sizing:border-box;border:2px solid #ccc;border-radius:30px;font: size 12px;
    background-color:white;background-position:10px 10px;background-repeat:no-repeat;padding:5px 10px 12px 30px;
    -webkit-transition: width:0.4s ease-in-out;}}
    input[type=text]:focus{width:50%}*/
    .search{width:300px; height:40px}
    .profUpld{float:right; margin-top:-50px; border-radius:20px; margin-right:5px; border:none; color:black; background-color:white;}
    .uploadbtn{float:right; margin-top:-30px;}
    .button{float:right; margin-top:-30px;}
    .fileinpt{float:right; margin-top:-30px;}
    .nfile{float:right; margin-top:-25px; border-radius:20px; border:none; color:black; background-color:white; cursor:pointer}
    .fileUpld{width:4%;float:right; margin-top:-25px; cursor:pointer}
    .submit{height:40px}
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
        <a href="findProfessionals.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Find Providers</a> 
        <a href="contact.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Contact</a>
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
<div class="w3-main" style="margin-left:340px;margin-right:40px;">
    <div class="w3-container" style="margin-top:80px" id="showcase">
        <div class="main-container">
            <div class="fixer-container input-group" >
                <form action='' method='POST'>
                    <img src='branzpir logo idea 3 with text (002).png' style='width:25%; cursor:pointer;' onclick="window.location.href='index.php';">
                    <div class="input-group">
                        <input class="search form-control rounded" type="text" name="search" placeholder="Search" />
                        <input class="submit btn btn-outline-danger" name="submit" type="submit" value="Search"/>
                        
                    </div>
                </form>
                    
                    
            </div>
        </div>
    </div>

<div class="row">
<?php

if(isset($_POST['submit']) || isset($_SESSION['home']))
{
    $search = $_POST['search'];
    $search1 = $_SESSION['home'];
    if($pro1=sqlSelect($C, "SELECT filename, username, description FROM images WHERE description LIKE '%$search%' OR description LIKE '%$search1%'"));
    {
        if($count1=$pro1->num_rows)
        {
            while(($prow1=$pro1->fetch_object()))
            {                                   
                ?>
                    <div class="col-md-4">
                    <?php echo "<img src='uploads/$prow1->filename' class='img-fluid rounded shadow-sm' style='height:300px; width:550px; object-fit:cover;' onclick='onClick(this)' alt='$prow1->username<br><q>$prow1->description</q>'>
                    <span><a class='small' style='color:black'; href='newUserProfile.php?category=$prow1->username'>$prow1->username</a>"?>
                </div><?php
            } 
        }
        else
        {
            echo "<p class='message'>No results for this search entered</p>";
        }
    $pro1->free();  
    }
}
    
?>
</div>
    <div class="row">
        <?php
        if($res=sqlSelect($C, 'SELECT filename, description, username from images'))
        {
            if($count=$res->num_rows)
            {
                while($row=$res->fetch_object())
                {
        ?>      
                    <div class="col-md-4">
                        <?php echo "<img src='uploads/$row->filename' class='img-fluid rounded shadow-sm' style='height:300px; width:550px; object-fit:cover;' onclick='onClick(this)' alt='$row->username<br><q>$row->description</q>'>
                        <span><a class='small' style='color:black'; href='newUserProfile.php?category=$row->username'>$row->username</a>"?>
                    </div>
        <?php
                }
            $res->free();
            }
        }
        ?>
    </div>
    <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
        <span class="w3-button w3-black w3-xxlarge w3-display-topright">x</span>
        <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
            <img id="img01" class="w3-image">
            <p id="caption"></p>    
        </div>
    </div>
    <div class="w3-container w3-padding-32" style="margin-top:75px;padding-right:18px; width:100%; margin-left:0px;">
        <span class="w3-left">&copy; Copyright 2022 Branzpir</span><span class="w3-right">Powered by <a href="https://eurotechdisplays.com.au/" class="foot-link" title="Eurotech" target="_blank" class="w3-hover-opacity" style='color: #000000;'>Eurotech</a></span>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src='index.js'></script>
<script>
$('.message').delay(3000).fadeOut('slow', function() { $(this).remove(); });
</script>
</body>
</html>
