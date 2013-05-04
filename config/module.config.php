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
        'aliases' => array(
            'BaconUser\EntityManager'             => 'Doctrine\ORM\EntityManager',
            'BaconUser\Password\HandlerInterface' => 'BaconUser\Password\HandlerAggregate',
        ),
        'factories' => array(
            'BaconUser\Config'                    => 'BaconUser\Factory\ConfigFactory',
            'BaconUser\Form\RegistrationForm'     => 'BaconUser\Form\Factory\RegistrationFormFactory',
            'BaconUser\Options\UserOptions'       => 'BaconUser\Factory\UserOptionsFactory',
            'BaconUser\Password\HandlerAggregate' => 'BaconUser\Password\Factory\HandlerAggregateFactory',
            'BaconUser\Password\HandlerManager'   => 'BaconUser\Password\Factory\HandlerManagerFactory',
        )
    ),
);
