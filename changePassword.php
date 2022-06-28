<?php 
    require_once 'utils.php';
    echo $_SESSION['userName'];
if($_POST['submit'])
{
    if(!isset($_POST['password']) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $_POST['password'])) {
		$errors[] = 4;
	}
	else if(!isset($_POST['confirm-password']) || $_POST['confirm-password'] !== $_POST['password']) {
		$errors[] = 5;
	}
	/*$token = md5(uniqid(rand(), true));
	$_SESSION['csrf_token'] = $token;
	$_SESSION['csrf_token_time'] = time();
	if(isset($_POST) & !empty($_POST))
	{
		if(isset($_POST['csrf_token']))
		{
			if($_POST['csrf_token'] == $_SESSION['csrf_token'])
			{
				$errors[] = "9";
			}
		}
		$max_time = 60*60*24;
		if(isset($_SESSION['csrf_token_time']))
		{
			$token_time = $_SESSION['csrf_token_time'];
			if($token_time + $max_time >= time())
			{}
			else
			{
				unset($_SESSION['csrf_token']);
				unset($_SESSION['csrf_token_time']);
				$errors[] = "11";
			}
		}
	}*/

    if(count($errors)==0)
    {
        $C = connect();
        if($C)
        {
            $res = sqlSelect($C, 'SELECT username FROM accounts WHERE username=?', 's', $_SESSION['userName']);
            if($res && $res->num_rows == 1)
            {
                $request = $res->fetch_assoc();
                // UPDATE PASSWORD
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                if(sqlUpdate($C, 'UPDATE accounts SET password=? WHERE username=?', 'ss', $hash, $_SESSION['userName']))
                {
                    /* DELETE ALL PASSWORD REQUESTS FROM USER
                    sqlUpdate($C, 'DELETE FROM requests WHERE user=? AND type=1', 'i', $request['user']);
                    $errors[] = 0;*/
                    header('location:dashboard.php');
                }
                else
                {
                    // FAILED TO UPDATE PASSWORD
                    $errors[] = 5;
                    echo 5;
                }
                $res->free_result();
            }
            else
            {
                // INVALID PASSWORD RESET REQUEST
                $errors[] = 7;
                echo 5;
            }
            $C->close();
        }
        else
        {
            // FAILED TO CONNECT TO DATABASE
            $errors[] = 8;
            echo 5;
        }
    }
    echo json_encode($errors);
}
?>
