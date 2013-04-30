<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'baconuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/doctrine',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'BaconUser\Entity' => 'baconuser_entity',
                ),
            ),
        ),
    ),
    'bacon_user' => array(
        'password' => array(
            'handler_manager' => array(
                'invokables' => array(
                    'md5'  => 'BaconUser\Password\SimpleMd5',
                    'sha1' => 'BaconUser\Password\SimpleSha1',
                ),
                'factories' => array(
                    'bcrypt' => 'BaconUser\Factory\BcryptFactory',
                ),
            ),
            'handler_aggregate' => array(
                'hashing_methods' => array(
                    'bcrypt',
                    'simple-sha1',
                    'simple-md5',
                ),
                'default_hashing_method' => 'bcrypt',
                'migrate_to_default_hashing_method' => true,
            ),
            'bcrypt' => array(
                'cost' => 14,
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'baconuser_password_handleraggregate' => 'BaconUser\Factory\HandlerAggregateFactory',
            'baconuser_password_handlermanager'   => 'BaconUser\Factory\HandlerManagerFactory',
        )
    ),
);
