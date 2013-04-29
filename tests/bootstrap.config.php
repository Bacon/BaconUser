<?php
return array(
    'modules' => array(
        'BaconUser',
        'DoctrineORMModule',
        'DoctrineModule',
    ),
    'module_listener_options' => array(
        'module_paths' => array(),
        'config_glob_paths' => array(
            __DIR__ . '/testing.config.php',
        ),
    ),
);
