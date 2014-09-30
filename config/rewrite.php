<?php
return [
    'signin' => '/user/default/login',
    'signup' => '/user/default/register',
    'signout' => '/user/default/logout',
    'auth' => '/user/default/auth',
    'reset-password' => '/user/default/resetPassword',
    'user/<id>' => '/user/home/index',


    //标签rest
//    'PUT,PATCH tags/<name>' => 'tag/update',
    'GET,HEAD tags/<do:(search)>/<name>' => 'tag/index', //tag 关键字检索
    'DELETE tags/<name>' => 'tag/delete',
    'GET,HEAD tags/<name>' => 'tag/view',
    'POST tags' => 'tags/create',
    'GET,HEAD tags' => 'tag/index',
//    'tags/<name>' => 'tag/options',
//    'tags' => 'tag/options',
];
?>