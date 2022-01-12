<?php
$err = NULL;

if(isset($_POST['submit']))
{
    //GET FORM DATA
    $usr = $_POST['usr'];
    $pwd = $_POST['pwd'];
    $rpwd = $_POST['rpwd'];
    $eml = $_POST['eml'];

    if(strlen($usr) < 5)
    {
        $err = 'Your username must be atleast 5 characters long';
    }
    elseif($rpwd != $pwd)
    {
        $err .= 'Your passwords do not match';
    }
    else
    {
        //FORM IS VALID

        //CONNECT TO DATABASE
        $mysqli = NEW MySQLi('localhost','root','','branzpir');

        //SANITISE FORM DATA
        $usr = $mysqli->real_escape_string($usr);
        $pwd = $mysqli->real_escape_string($pwd);
        $rpwd = $mysqli->real_escape_string($rpwd);
        $eml = $mysqli->real_escape_string($eml);

        //GENERATE VKEY
        $vkey = password_hash(time().$usr, PASSWORD_DEFAULT);
        
        //INSERT ACCOUNT INTO DATABASE
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $insert = $mysqli->query("INSERT INTO accounts(username, password, email, vkey)
        VALUES('$usr', '$pwd', '$eml', '$vkey')");

        if ($insert)
        {
            //SEND EMAIL
            $to = $eml;
            $subject = 'Email Verification';
            $message = "<a href='http://localhost/registration/verify.php?vkey=$vkey'>Register Account</a>";
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8 \r\n";
            $headers .= 'From: emmanuel.k@eurotech.com.au' . "\r\n";

            mail($to,$subject,$message,$headers);
            //header('location:thankyou.php');
        }
        else
        {
            echo $mysqli->error;
        }

    }
}

?>

<html>
<head>
<body>
<form method='POST' action=''>
    <table border='0' align='center' cellpadding='5'>
        <tr>
            <td align='right'>Username:</td>
            <td><input type='text' name='usr' required/></td>
        </tr>
        <tr>    
            <td align='right'>Password:</td>
            <td><input type='text' name='pwd' required/></td>
        </tr>
        <tr>    
            <td align='right'>Repeat Password:</td>
            <td><input type='text' name='rpwd' required/></td>
        </tr>
        <tr>
            <td align='right'>Email Address:</td>
            <td><input type='text' name='eml' required/></td>
        </tr>
        <tr>
            <td colspan='2' align='center'><input type='SUBMIT' name='submit' value='Register' required/></td>
        </tr>
    </table>
</form>
<center>
<?php
$err = NULL;
?>
</center>
</body>
</head>
</html>