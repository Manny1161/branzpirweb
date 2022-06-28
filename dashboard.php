<?php
require_once 'utils.php';
//include 'changePassword.php';
$C = connect();
$_SESSION['user'] = $_GET['uname'];
if(isset($_POST['submit'])){
    if(!empty($_POST['username'])) {
        sqlUpdate($C, "UPDATE accounts SET username=? WHERE username=?", 'ss', $_POST['username'], $_SESSION['user']);
    }
    if(!empty($_POST['email'])) {
        sqlUpdate($C, "UPDATE accounts SET email=? WHERE username=?", 'ss', $_POST['email'], $_SESSION['user']);
    }
}

?>

<!DOCTYPE html>
<html>    
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>   
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
</style>
<body>
    <div class="container">
        <img src='branzpir logo idea 3 with text (002).png' style='width:25%;margin-top:10px;cursor:pointer' onclick="window.location.href='index.php';">
    </div>
    <div class="w3-bar w3-highway-red w3-card my-1">
        <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i>☰</a>    
        <div class="container">
        <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Home</a>
        <a href='showcase.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Showcase</a>
        <a href='findProfessionals.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Find Providers</a> 
        <a href='contact.php' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">Contact</a>
        <a href='youandbranzpir.html' class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white">You and Branzpir</a>
        </div>
    </div>
            
    <!-- Navbar on small screens (remove the onclick attribute if you want the navbar to always show on top of the content when clicking on the links) -->
    <div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium" style="margin-top:46px">
        <a href="index.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Home</a>
        <a href="showcase.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Showcase</a>
        <a href="findProfessionals.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Find Providers</a>
        <a href="contact.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Contact</a>
        <a href="youandbranzpir.html" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">You and Branzpir</a>
    </div>

    <div class="container" style="margin-top:80px;width:50%">
        <h2>Account Information</h2>
        
        <form class="row g-3" method="POST" style="margin-top:80px">
        <div class="col-2"><a href='dashboard.php' style='color:#000000'>Profile Info</a><br><a href='userlogin.php?uname=<?php echo $_SESSION['userName']?>' style='color:#000000'>Password</a></div>
        
            <div class="col-10">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name='username'>
            
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name='email'>

                <br>
                <button type="submit" class="btn btn-danger" name='submit'>Update</button>
            </div>
        </form>
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
</body>
</html>