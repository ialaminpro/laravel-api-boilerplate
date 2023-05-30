<?php

declare(strict_types=1);

return [

    'create_user' => [
        'description' => 'Create a new user',
        'dialogs'     => [
            'confirm_before_executing' => 'Do you want to proceed?',
        ],
        'alerts' => [
            'confirmation' => 'User created!',
        ],
        'questions' => [
            'first_name'     => 'What is the first name?',
            'last_name'     => 'What is the last name?',
            'email'    => 'What is the email?',
            'password' => 'What is the password?',
        ],
    ],

];
