
<?php
//Change this so it is optimised for banner images!!!
$target_dir = "profileavatars/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["upload"])) {
  $check = getimagesize($_FILES["image"]["tmp_name"]);
  $imagedetails = getimagesize($_FILES["image"]["tmp_name"]);
  $width = $imagedetails[0];
  $height = $imagedetails[1];
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo '<p class="message">File is not an image</p>';
    $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo '<p class="message">Sorry, only JPG, JPEG & PNG files are allowed.</p>';
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo '<p class="message">Sorry, your file was not uploaded</p>';
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $fname = $_FILES['image']['name'];
      $user = $_SESSION['cat'];
      $res = sqlInsert($C, "INSERT INTO profileavatar (filename, username) VALUES ('$fname', '$user')");
      
    } else {
      echo '<p class="message">Sorry, there was an error uploading your file.';
    }
  }
}
?>

<?php
        if($bp=sqlSelect($C, 'SELECT p1.filename FROM profilebanner p1 INNER JOIN profilebanner p2 ON p1.username=p2.username AND p1.id > p2.id WHERE p2.username=?', 's', $_SESSION['cat']))
            {
                if($count=$pf->num_rows)
                {
                    while($irow=$pf->fetch_object())

                    {
        ?>
                        <div class="bannerImg">
                            <?php if($_SESSION['loggedin'] && $_SESSION['profName'] == $_SESSION['cat']) : ?>
                            <img src="camera.png" class="camera2" onclick="openProfilePicture()">
                            <div id="openProfilePictureForm" class="w3-modal">
                                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                                    <div class="w3-center"><br>
                                        <span onclick="closeProfilePicture()" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Form">&times;</span>
                                    </div>
                                    <form method='POST' action='' enctype='multipart/form-data' style='margin-top:80px'>
                                        <table border='0' align='center' cellpadding='8'>
                                            <tr>
                                                <td align='right'>Choose File:</td>
                                                <td><input type='file' name='image' value='' accept='image/*'/></td>
                                            </tr>
                                            <tr>
                                                <td colspan='2' align='center'><input type='submit' name='Upload' value='Upload' required/></td> 
                                            </tr>
                                        </table>
                                    </form>
                                    <div class="w3-container w3-border-top w3-padding-16">
                                        <button onclick="closeProfilePicture()" type="button" class="w3-button w3-red">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <?php endif?>
                            <?php echo "<img style='width:150px; height:150px;'src='profilebanners/$irow->filename'>" ?>
                        </div>
<?php
                    }
                }
                $bp->free();
            }    

?>


