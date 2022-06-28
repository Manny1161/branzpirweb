<?php 
require_once 'utils.php';
echo $_SESSION['userName'];
$C = connect();
if(isset($_POST['submitpw']))
{
    if(!empty($_POST['password']) || preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $_POST['password'])) {
		if(!empty($_POST['confirm-password']) || $_POST['confirm-password'] == $_POST['password'])
		{
			
			$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
			sqlUpdate($C, 'UPDATE accounts SET password=? WHERE username=?', 'ss', $hash, $_SESSION['userName']);
			header('location:dashboard.php');
		}
	}
}

?>
