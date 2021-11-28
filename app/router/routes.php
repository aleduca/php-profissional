<?php

return [
  'POST' => [
    '/login' => 'Login@store',
    '/contact' => 'Contact@store',
    '/user/[0-9]+' => 'user@update',
    '/user/store' => 'user@store',
    '/user/image/update' => "UserImage@store"
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
