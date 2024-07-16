<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'air-quality-reading' => [
        'title' => 'Air Quality Readings',

        'actions' => [
            'index' => 'Air Quality Readings',
            'create' => 'New Air Quality Reading',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'temperature' => 'Temperature',
            'humidity' => 'Humidity',
            'co2' => 'Co2',
            'pm1_0' => 'Pm1 0',
            'pm2_5' => 'Pm2 5',
            'pm4' => 'Pm4',
            'pm10' => 'Pm10',
            'eco2' => 'Eco2',
            'tvoc' => 'Tvoc',
            
        ],
    ],

    'ccs811-reading' => [
        'title' => 'Ccs811 Readings',

        'actions' => [
            'index' => 'Ccs811 Readings',
            'create' => 'New Ccs811 Reading',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'temperature' => 'Temperature',
            'humidity' => 'Humidity',
            'eco2' => 'Eco2',
            'tvoc' => 'Tvoc',
            
        ],
    ],

    'scd41-reading' => [
        'title' => 'Scd41 Readings',

        'actions' => [
            'index' => 'Scd41 Readings',
            'create' => 'New Scd41 Reading',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'temperature' => 'Temperature',
            'humidity' => 'Humidity',
            'eco2' => 'Eco2',
            
        ],
    ],

    'sps30-reading' => [
        'title' => 'Sps30 Readings',

        'actions' => [
            'index' => 'Sps30 Readings',
            'create' => 'New Sps30 Reading',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'pm1_0' => 'Pm1 0',
            'pm2_5' => 'Pm2 5',
            'pm4' => 'Pm4',
            'pm10' => 'Pm10',
            
        ],
    ],

    'subscriber' => [
        'title' => 'Subscribers',

        'actions' => [
            'index' => 'Subscribers',
            'create' => 'New Subscriber',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'email' => 'Email',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];