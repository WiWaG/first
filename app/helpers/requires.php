<?php

if (trim(strtolower($_SERVER['SCRIPT_NAME'])) === '/requires.php') {
    die('No access.');
}

require $_SERVER['DOCUMENT_ROOT'] . '/app/helpers/main-helper.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/libraries/mysql.php';

mysqlConnect();

$data = [
    'first_name' => 'Donald',
    'insertion'  => '',
    'last_name'  => 'Duck',
    'email'      => 'donald.duck@codegorilla.nl',
    'password'   => 'abcdefghijklmnopqrstuvqxyz',
];

mysqlUpdate($data, 'users', 4);

?>