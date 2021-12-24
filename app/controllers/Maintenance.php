<?php

namespace app\controllers;

class Maintenance
{
    public function index(): array
    {
        return [
            'view' => 'maintenance',
            'data' => ['title' => 'Em manutenção']
        ];
    }
}
