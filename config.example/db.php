<?php

return [
    'class'      => 'yii\db\Connection',
    'dsn'        => 'mysql:host=127.0.0.1;dbname=rekmed',
    'username'   => 'root',
    'password'   => '',
    'charset'    => 'utf8',
    'attributes' => [PDO::ATTR_CASE => PDO::CASE_LOWER],
];