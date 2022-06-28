<style>.message{color:red}</style>
<?php
    require_once 'utils.php';
    include 'changePassword.php';
    $alert = '';
    $_SESSION['user'] = $_GET['uname'];
        
?>
<html lang="en">
<head>
    <title>Branzpir</title>
    <link rel='branzpir icon' href='branzpir_favicon.png' type='image/x-icon'>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", san-serif}
    body {font-size:16px;}
    .w3-half img{margin-bottom:-6px;margin-top:16px;opactiy:0.8;cursor:pointer}
    .w3-half img:hover{opacity:1}
    table{margin:0 auto;}
</style>
<body>
<!--header class="w3-container w3-top w3-hide-small w3-highway-red w3-xlarge w3-padding">
    <b><span><a href='index.php' style='color:#ffffff'>branzpir</a></span></b>
</header-->

<div class="container">
    <form class="row g-3" method="POST" style="margin-top:80px">
        <div class="col-12">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name='password' placeholder="Enter new Password">
        </div>
        <div class="col-12">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name='confirm-password' placeholder="Confirm new Password">
        </div>
        <div class="col-12">
            <br>
            <button type="submit" class="btn btn-danger" name='submit'>Submit</button>
            <!--input type="hidden" name="csrf_token" value="<-?php echo $token; ?>"-->
        </div>
    </form>
</div>

</body>
</html>