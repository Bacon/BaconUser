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
    'service_manager' => array(
        'factories' => array(
            'baconuser_password_handleraggregate' => 'BaconUser\Factory\HandlerAggregateFactory',
            'baconuser_password_handlermanager'   => 'BaconUser\Factory\HandlerManagerFactory',
        )
    ),
);
