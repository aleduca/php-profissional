<?php

return [
  'POST' => [
    '/login' => 'Login@store',
    '/contact' => 'Contact@store',
    '/user/[0-9]+' => 'User@update',
    '/user/store' => 'User@store',
    '/user/image/update' => "UserImage@store",
    '/password/user/[0-9]+' => 'Password@update',
  ],
  'GET' => [
    '/' => 'Home@index',
    '/users' => 'Users@index',
    '/contact' => 'Contact@index',
    '/user/create' => 'User@create',
    '/user/edit/profile' => 'User@edit',
    '/user/[0-9]+' => 'User@show',
    '/login' => 'Login@index',
    '/logout' => 'Login@destroy',
  ]
];
