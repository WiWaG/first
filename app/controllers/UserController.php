<?php

require '../libraries/mysql.php';

if (isset($_POST) && isset($_POST['token']))
{
    $token = trim(strtolower($_POST['token']));
    if ($token === 'register')
    {
        unset($_POST['token']);
        userStore();
    }
}

function userIndex()
{
    $users = mysqlQuery("SELECT * FROM users");
}

function userStore()
{
    // check if email already has been taken
    $query = "SELECT `id` FROM `users` WHERE `email`='" . $_POST['email'] . "'";
    $result = mysqlQuery($query)->fetch();
    if ($result !== false)
    {
        echo json_encode([
            'error'   => true,
            'message' => "This user(name) has already been taken."
        ]);

        return;
    }

    // check if passwords are equal
    if (comparePasswords($_POST['password'], $_POST['password_2']))
    {
        echo json_encode([
            'error'   => true,
            'message' => "Passwords don't match."
        ]);

        return;
    }
    
    // remove second password from POST
    unset($_POST['password_2']);

    // create password hash and set required fields
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $_POST['role'] = 1;
    $_POST['created_by'] = 1;
    $_POST['created'] = date('Y-m-d H:i:s');

    mysqlInsert($_POST, 'users');

    echo json_encode([
        'error'   => false,
        'message' => 'Ok :-)'
    ]);
}

function comparePasswords($pass1, $pass2)
{
    return $pass1 != $pass2;
}

?>