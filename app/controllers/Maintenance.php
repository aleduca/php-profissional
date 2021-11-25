<?php

namespace app\controllers;

class Maintenance
{
    public function index()
    {
        return [
            'view' => 'maintenance',
            'data' => ['title' => 'Em manutenção']
        ];
    }
}
