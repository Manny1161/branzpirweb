<?php
require_once 'utils.php';
error_reporting(0);
$selected_category = $_GET['category'];
$_SESSION['cat'] = $_GET['category'];
$pro = $_SESSION['cat'];
$C = connect();
$res = sqlSelect($C, 'SELECT description, category, number, address1, state, postcode, address2 FROM professionals WHERE username=?', 's', $_SESSION['cat']);
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
    .bannerImg{position:relative;}
    .ficon{width:5%}
    .licon{width:5%}
    .wicon{width:5%}
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

<?php if($_SESSION['loggedin'] && $_SESSION['profName'] == $_SESSION['cat']) : ?>
    <button type="button" id="editBtn">Edit Profile</button>
    <form action='' method='POST'>
        <input type="text" name="textBox" id="textBox"/>
        <input type="submit" name="subBtn" value="Save" id="subBtn"/>
    </form>
    <?php if(isset($_POST['subBtn'])){
        sqlUpdate($C, "UPDATE professionals SET category=? WHERE username=?", 'ss', $_POST['textBox'], $_SESSION['cat']);   
    }?>
    <script src="index.js"></script>
<?php endif?>
</h5>

<?php
    if($proImg=sqlSelect($C, 'SELECT filename FROM images WHERE username=?', $_SESSION['cat']))
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
            if($pf=sqlSelect($C, 'SELECT filename FROM images WHERE username=?', 's', $_SESSION['cat']))
            {
                if($count=$pf->num_rows)
                {
                    while($irow=$pf->fetch_object())

                    {
        ?>
                        <div class="profImg">
                            <?php echo "<img style='width:150px; height:150px;'src='uploads/$irow->filename'>" ?>
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
        </div>
    </div>

    <div class="w3-left">
        <div class="w3-container">
            <h5><span style="color:grey"><?php echo $_SESSION['profCat'];?></span></h5>
            <img class="ficon" src="icons/facebookicon.png"/>
            <img class="licon" src="icons/linkedincon.png"/>
            <img class="wicon" src="icons/websiteicon.png"/>
        </div>
    </div>
        


    <div class="w3-left">
        <div class="w3-container" style="width:400px">
            <div class="desc"><?php echo $_SESSION['profDesc'];?></span></div>
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
