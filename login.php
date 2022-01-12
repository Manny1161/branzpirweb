<?php
    $eml='root';
    $pwd='root';
    if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST[password]) && !empty($_POST['password'])) ){

        $username=$_POST['username'];
        $password=$_POST['password'];
        
         
                    if(($username==$usr) && ($password==$pwd) ){
        
                                        echo '<br>login successfull';
        
                        }else{
        
                                    echo '<br>login unsuccessfull';
                                    }
            }else{
                    echo "<br>Connot be left empty!";
                    }
        ?>
?>