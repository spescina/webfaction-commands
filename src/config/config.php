<?php

return [

    'environments' => [

        'staging' => [

            'app_folder' => '~/webapps/your_app',
            'composer_folder' => false,
            'artisan_folder' => false,

            'git_repository' => 'git@github.com:spescina/webfaction-commands.git',

            'git_branch' => 'develop'

        ],

        'production' => [

            'app_folder' => '~/webapps/your_app',
            'composer_folder' => false,
            'artisan_folder' => false,

            'git_repository' => 'git@github.com:spescina/webfaction-commands.git',

            'git_branch' => 'master'

        ]

    ]

];