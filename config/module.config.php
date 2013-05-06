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
            'BaconUser\ObjectManager'             => 'Doctrine\ORM\EntityManager',
            'BaconUser\Password\HandlerInterface' => 'BaconUser\Password\HandlerAggregate',
        ),
        'invokables' => array(
            'BaconUser\Entity\UserPrototype' => 'BaconUser\Entity\User',
        ),
        'factories' => array(
            'BaconUser\Config'                           => 'BaconUser\Factory\ConfigFactory',
            'BaconUser\Form\RegistrationFilter'          => 'BaconUser\Form\Factory\RegistrationFilterFactory',
            'BaconUser\Form\RegistrationForm'            => 'BaconUser\Form\Factory\RegistrationFormFactory',
            'BaconUser\Form\RegistrationHydrator'        => 'BaconUser\Form\Factory\RegistrationHydratorFactory',
            'BaconUser\Options\UserOptions'              => 'BaconUser\Factory\UserOptionsFactory',
            'BaconUser\Password\HandlerAggregate'        => 'BaconUser\Password\Factory\HandlerAggregateFactory',
            'BaconUser\Password\HandlerManager'          => 'BaconUser\Password\Factory\HandlerManagerFactory',
            'BaconUser\Repository\UserRepositoryFactory' => 'BaconUser\Factory\UserRepositoryFactory',
        )
    ),
);
