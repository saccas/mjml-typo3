<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Mjml',
    'description' => 'Mjml view using mjml over npm',
    'category' => 'misc',
    'shy' => 0,
    'version' => '1.0.0',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'author' => '',
    'author_email' => '',
    'author_company' => '',
    'autoload' =>
        [
            'psr-4' => ['Saccas\\Mjml\\' => 'Classes']
        ],
    'constraints' => [
        'depends' => [
            'php' => '7.0.0-0.0.0',
            'typo3' => '8.7.*',
            'extbase' => '',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    '_md5_values_when_last_written' => 'a:0:{}',
    'suggests' => [
    ],
];
