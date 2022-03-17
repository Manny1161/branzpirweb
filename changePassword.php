<?php 
    require_once 'utils.php';

    $errors = [];

    if(empty($_POST['id']))
    {
        // CHECK FOR NO ID
        $errors[] = 1;
    }
    if(empty($_POST['hash']))
    {
        // CHECK FOR NO HASH
        $errors[] = 2;
    }
    if(!isset($_POST['password']) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $_POST['password']))
    {
        // PASSWORD MUST HAVE UPPER & LOWER LETTERS, ONE NUMBER AND ATLEAST ONE SPECIAL SYMBOL AND BE 8 OR MORE CHARS LONG
        $errors[] = 3;
    }
    else if(!isset($_POST['confirm-password']) || $_POST['confirm-password'] != $_POST['password'])
    {
        $errors[] = 4;
    }

    if(count($errors==0))
    {
        if(isset($_POST['csrf-token']))
        {
            $C = connect();
            if($C)
            {
                $res = sqlSelect($C, 'SELECT user, hash, timestamp FROM requests WHERE id=? LIMIT 1', 'i', $_POST['id']);
                if($res && $res->num_rows == 1)
                {
                    $request = $res->fetch_assoc();
                    // VERIFY PASSWORD
                    if(password_verify(urlSafeDecode($_POST['hash']), $request['hash']))
                    {
                        if($request['timestamp'] >= time() - PASSWORD_RESET_REQUEST_EXPIRY_TIME)
                        {
                            // UPDATE PASSWORD
                            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            if(sqlUpdate($C, 'UPDATE user SET password=? WHERE id=?', 'si', $hash, $request['user']))
                            {
                                // DELETE ALL PASSWORD REQUESTS FROM USER
                                sqlUpdate($C, 'DELETE FROM requests WHERE user=? AND type=1', 'i', $request['user']);
                                $errors[] = 0;
                            }
                            else
                            {
                                // FAILED TO UPDATE PASSWORD
                                $errors[] = 5;
                            }
                        }
                        else
                        {
                            // RESET REQUEST EXPIRED
                            $errors[] = 6;
                        }
                    }
                    else
                    {
                        // INVALID PASSWORD RESET REQUEST
                        $errors[] = 7;
                    }
                    $res->free_result();
                }
                else
                {
                    // INVALID PASSWORD RESET REQUEST
                    $errors[] = 7;
                }
                $C->close();
            }
            else
            {
                // FAILED TO CONNECT TO DATABASE
                $errors[] = 8;
            }
        }
        else
        {
            // INVALID CSRF TOKEN
            $errors[] = 9;
        }
    }
    echo json_encode($errors);

?>
