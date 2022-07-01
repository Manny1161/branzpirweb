<style>
  .message{color:red}
</style>

<?php
require_once 'utils.php';
$C = connect();
error_reporting(0);
?>

<html lang="en">
<head>
<title>branzpir</title>
    <link rel='branzpir icon' href='branzpir_favicon.png' type='image/x-icon'>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    body {font-size:16px;}
    .logIn{float:right; margin-top:-5px; border-radius:20px; margin-right:5px; border:none; color:black; background-color:white;}
    .profReg{float:right; margin-top:11px; border-radius:20px; margin-right:5px; border:none; color:black; background-color:white;}
    .nlog{width:3%;float:right; margin-top:-5px; cursor:pointer;}
    .nprof{width:3%;float:right;margin-top:-5px;;cursor:pointer;}
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

    .vertical-scrollable {
            position: relative;
            width:300px;
            height:140px;
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
    @media all and (min-width:992px){
    .dropdown-menu-sw {
        left:75%;
    }
    .dropdown-menu {
        position:absolute;
        top:30px;
        right:10;
        width:160px;
    }}
    @media all and (max-width:992px){
    .dropdown-menu-sw {
        left:60%;
    }
    .dropdown-menu {
        position:absolute;
        top:100px;
        right:10;
        width:160px;

    }}
    @media all and (min-width:992px){
    .dropdown-menu-uw {
        left:65%;
    }
    .dropdown-menu {
        position:absolute;
        top:30px;
        right:10;
        width:160px;
    }}
    @media all and (max-width:992px){
    .dropdown-menu-uw {
        /*right: -10;*/
        left:50%;
    }
    .dropdown-menu {
        position:absolute;
        right:10;
        top:15px;
        width:160px;

    }}
</style>
<body>
<!--- PAGE CONTENT -->
<div class="container">
<div class="w3-container" style="margin-top:14px">
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) : ?>
<form method='POST' action=''><input class='profReg' type='button' value='PROVIDERS'/></form>
    <div class="dropdown">
        <a href="#" id="imageDropdown" data-toggle="dropdown">
        <img class="nprof" src="pros.png">
        </a>
        <div class="dropdown-menu pull-right my-2">
            <li><a href="professionalsLogin.php">Log In</a></li>
            <li><a href="professionalsRegistration.php">Join As a Provider</a></li>
            <?php if(isset($_SESSION['profID'])) : ?>
            <li><a href="logout.php">Log Out</a></li>
            <li><?php echo "<a href='newUserProfile?category=$pro'>Edit Profile</a>"?></li>
            <?php endif ?>
        </div>
    </div>
    <form method='POST' action=''><input class='logIn' type='button' value='USERS'/></form>
    <div class="dropdown">
        <a href="#" id="imageDropdown" data-toggle="dropdown">
        <img class="nlog" src="users.png">
        </a>
        <div class="dropdown-menu dropdown-menu-sw">
            <li><a href="login.php">Log In</a></li>
            <li><a href="registration.php">Register</a></li>
            <?php if(isset($_SESSION['userID'])) : ?>
            <li><a href="logout.php">Log Out</a></li>
            <?php endif ?>
        </div>
    </div>
    <?php endif ?>
    <!-- IF USER IS LOGGED IN DISPLAY THIS -->
    <?php if(isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true) : ?>
        <!-- IF USER IS PROVIDER DISPLAY THIS -->
        <?php if(isset($_SESSION['profID'])) : ?>
            <form method='POST' action=''><input class='profReg' type='button' value='<?php echo $_SESSION['profName']?>'/></form>
            <div class="dropdown">
                <a href="#" id="imageDropdown" data-toggle="dropdown">
                <img class="nprof" src="pros.png">
                </a>
                <div class="dropdown-menu pull-right my-2">
                    <?php if(!isset($_SESSION['profID'])) : ?>
                        <li><a href="professionalsLogin.php">Log In</a></li>
                        <li><a href="professionalsRegistration.php">Join As a Provider</a></li>
                    <?php endif ?>
                    <?php if(isset($_SESSION['profID'])) : ?>
                        <li><a href="dashboard.php">My Dashboard</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                    <?php endif ?>
                </div>
            </div>
        <?php endif ?>
        <!-- IF USER IS PRIVATE USER DISPLAY THIS -->
        <?php if(isset($_SESSION['userID'])) : ?>
            <form method='POST' action=''><input class='logIn' type='button' value='<?php echo $_SESSION['userName']?>'/></form>
            <div class="dropdown">
                <a href="#" id="imageDropdown" data-toggle="dropdown">
                <img class="nlog" src="users.png">
                </a>
                <div class="dropdown-menu pull-right my-2">
                    <?php if(!isset($_SESSION['userID'])) : ?>
                        <li><a href="login.php">Log In</a></li>
                        <li><a href="registration.php">Register</a></li>
                    <?php endif ?>
                    <?php if(isset($_SESSION['userID'])) : ?>
                        <li><a href="dashboard.php?uname=<?php echo $_SESSION['userName']?>">My Dashboard</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                    <?php endif ?>
                </div>
            </div>
        <?php endif ?>
    <?php endif ?>
        <form action='showcase.php' method='GET'>
            <img src='branzpir logo idea 3 with text (002).png' style='width:25%; cursor:pointer' onclick="window.location.href='index.php';">  
            <div class="input-group"> 
            <input class="search form-control rounded" style="width:70%" type="text" name="index" placeholder="Search for inspiration..." />  
            </div>
        </form>
    
</div>        
</div>
<div class="w3-bar w3-highway-red w3-card mb-2" style="margin-top:-1px">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i>☰</a>    
    <div class="container">
    <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Home</a>
    <a href='showcase.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Showcase</a>
    <a href='findProfessionals.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Find Providers</a> 
    <a href='contact.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Contact</a>
    </div>
</div>
        
<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium" style="margin-top:46px">
    <a href="index.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Home</a>
    <a href="showcase.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Showcase</a>
    <a href="findProfessionals.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Find Providers</a>
    <a href="contact.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Contact</a>
    <a href="youandbranzpir.html" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">You and Branzpir</a>
</div>
<div class="container" style="margin-top:10px">
    <h4 style="text-align:left">Find Your Local Providers</h4>
    <div class="input-group">
        <form action='' method='POST'>
            <div class="input-group">
            <input class="search form-control rounded" style="width:20%" type="text" name="search" placeholder="Enter suburb or postcode"/>
            <input class="submit btn btn-outline-danger" type="submit" name="submit" value="Search"/>
            </div>
        </form>
    </div>

    <div class="row">
    <?php
        if(isset($_POST['submit']))
        {
            
            $search = $_POST['search'];
            if($pro1=sqlSelect($C, "SELECT p.username, p.number, p.address1, p.address2, p.suburb, p.postcode, p.state FROM professionals p INNER JOIN profileavatar i ON p.username=i.username WHERE p.postcode LIKE '%$search%' OR p.suburb LIKE '%$search%'"));
            {
                if($img1=sqlSelect($C, "SELECT i.filename FROM profileavatar i INNER JOIN professionals p ON i.username=p.username WHERE p.postcode LIKE '%$search%' OR p.suburb LIKE '%$search%'"))
                {
                    if($count1=$pro1->num_rows)
                    {
                        if($count1=$img1->num_rows)
                        {
                            while(($prow1=$pro1->fetch_object()) && ($irow1=$img1->fetch_object()))
                            {
        ?>
                            
                            <div class="col-3">
                                <?php echo "<div class='profile mr-3'><img class='profImg rounded mb-2 img-thumbnail' src='profileavatars/$irow1->filename'></div>"?>
                                <?php echo "<span style='font-size:14px'><b><a href='newUserProfile.php?category=$prow1->username' style='color:#000000;'>$prow1->username</a></b></span>"?>
                            </div>                            
        <?php
                            }
                        }
                        
                    $pro1->free();
                    $img1->free();
                    }
                    else
                    {
                        echo "<p class='message'>No results for this search entered</p>";
                    }
                }
            }
        }
        ?>
    </div>

    <h4 style="text-align:left;margin-top:20px">All Providers</h4>
    <div class="row">
    <?php
            if($pro=sqlSelect($C, 'SELECT p.username, p.description, p.number, p.address1, p.address2, p.suburb, p.postcode, p.state FROM professionals p INNER JOIN profileavatar i ON p.username=i.username'))
            {
                if($img=sqlSelect($C, 'SELECT filename FROM profileavatar i INNER JOIN professionals p ON i.username=p.username'))
                {
                    if($count=$pro->num_rows)
                    {
                        if($count=$img->num_rows)
                        {
                            while(($prow=$pro->fetch_object()) && ($irow=$img->fetch_object()))
                            {    
        ?>                           
                                <div class="col-3">
                                    <?php echo "<div class='profile mr-3'><img class='profImg rounded mb-2 img-thumbnail' src='profileavatars/$irow->filename'></div>"?>
                                    <?php echo "<span style='font-size:14px'><strong><a href='newUserProfile.php?category=$prow->username' style='color: #000000;'>$prow->username</a></strong></span>"?>
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
    </div>
    
</div>
    
<footer class="w3-container w3-highway-red w3-padding-48" style="margin-top:75px">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <div class="w3-left"><img src='branzpir logo idea 3 with text (002).png' style='width:50%'></div>
            <a href="https://www.facebook.com/eurotechaustralia/"><img src='facebookicon1.png' style='width:10%'></a>&nbsp;
            <a href="https://www.linkedin.com/company/eurotech-australia/"><img src='linkedin1.png' style='width:10%'></a>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
            <h4>WHO WE ARE</h4>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="#" class="text-muted">About us</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Copyright</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Conditions of use</a></li>
                <li class="mb-2"><a href="#" class="text-muted">How does it work</a></li>
            </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
            <h4>CONTACT</h4>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="#" class="text-muted">Contact us</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Terms & privacy</a></li>
            </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
            <h4>YOU & BRANZPIR</h4>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="#" class="text-muted">For Brands</a></li>
                <li class="mb-2"><a href="#" class="text-muted">For Providers</a></li>
                <li class="mb-2"><a href="#" class="text-muted">For You in Business</a></li>
            </ul>
            </div>
        </div>
        <span class="w3-left my-5">&copy; Copyright 2022 Branzpir</span><span class="w3-right my-5">Powered by <a href="https://eurotechdisplays.com.au/" title="Eurotech" target="_blank" class="w3-hover-opacity" style='color: #ffffff;'>Eurotech</a></span>
    </div>
</footer>
<script src="index.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$('.message').delay(3000).fadeOut('slow', function() { $(this).remove(); });
if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>
