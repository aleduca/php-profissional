<?php

return [
  'POST' => [
    '/login' => 'Login@store',
    '/contact' => 'Contact@store',
    '/user/store' => 'user@store',
  ],
  'GET' => [
    '/' => 'Home@index',
    '/users' => 'Users@index',
    '/contact' => 'Contact@index',
    '/user/create' => 'User@create',
    '/user/[0-9]+' => 'User@show',
    '/login' => 'Login@index',
    '/logout' => 'Login@destroy',
  ]
];
