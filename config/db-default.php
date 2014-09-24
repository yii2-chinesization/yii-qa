<?php
/**
 * 请根据需要自行修改该文件，并重命名为 `db.php`
 * 为了适应不同环境的兼容性，请确保数据库名和表前缀均为半角小写。
 */
return [
    'class' => 'app\components\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii_qa',
    'username' => 'root',
    'password' => '',
    'tablePrefix' => 'pre_',
    'charset' => 'utf8',
];