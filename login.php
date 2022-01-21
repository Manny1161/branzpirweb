<?php
    require_once 'utils.php';
    if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
         $C = connect();
         if($C)
         {
            $hourAgo = time() - 60*60;
            $res = sqlSelect($C, 'SELECT accounts.id,accounts.password,COUNT(loginattempts.id) FROM accounts LEFT JOIN loginattempts ON accounts.id = user AND timestamp>? WHERE email=? GROUP BY accounts.id', 'is', $hourAgo, $email);
            if($res && $res->num_rows == 1)
            {
                $user = $res->fetch_assoc();
                //if($user['verified'])
                if($user['COUNT(loginattempts.id)'] <= MAX_LOGIN_ATTEMPTS_PER_HOUR)
                {
                    if($user && password_verify($hash, $user['password']))
                    {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['userID'] = $user['id'];
                        sqlUpdate($C, 'DELETE FROM loginattempts WHERE user = ?', 'i', $user['id']);
                    }
                    else
                    {
                        $id = sqlInsert($C, 'INSERT INTO loginattempts VALUES (NULL, ?, ?, ?)', 'isi', $user['id'], $_SERVER['REMOTE_ADDR'], time());
                        if($id != -1)
                        {
                            echo 1;
                        }
                        else
                        {
                            echo 2;
                        }
                    }

                }
                else
                {
                    echo 3;
                }
            }
            else
            {
                echo 4;
            }
            $res->free_result();
         }
         else
         {
             echo 1;
         }
         $C->close();
    }
    else
    {
        echo 2;
    }
        
?>
<html>
<head>
</head>
<body>
<form id="loginForm" method='POST' action=''>
    <table border='0' align='center' cellpadding='5'>
        <tr>
            <td align='right'>Email:</td>
            <td><input type='text' name='email' required/></td>
        </tr>
        <tr>    
            <td align='right'>Password:</td>
            <td><input type='text' name='password' required/></td>
        </tr>
        <tr>
            <td colspan='2' align='center'><input type='SUBMIT' name='submit' value='Login' required/></td>
        </tr>
    </table>    
</body>
</html>
