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
            'BaconUser\Config'                             => 'BaconUser\Factory\ConfigFactory',
            'BaconUser\Options\PasswordResetOptions'       => 'BaconUser\Factory\PasswordResetOptionsFactory',
            'BaconUser\Options\UserOptions'                => 'BaconUser\Factory\UserOptionsFactory',
            'BaconUser\Password\HandlerAggregate'          => 'BaconUser\Password\Factory\HandlerAggregateFactory',
            'BaconUser\Password\HandlerManager'            => 'BaconUser\Password\Factory\HandlerManagerFactory',
            'BaconUser\Repository\UserRepository'          => 'BaconUser\Factory\UserRepositoryFactory',
            'BaconUser\Repository\PasswordResetRepository' => 'BaconUser\Factory\PasswordResetRepositoryFactory',
            'BaconUser\Service\RegistrationService'        => 'BaconUser\Service\Factory\RegistrationServiceFactory',
            'BaconUser\Service\PasswordResetService'       => 'BaconUser\Service\Factory\PasswordResetServiceFactory'
        )
    ),

    'form_elements' => array(
        'factories' => array(
            'BaconUser\Form\RegistrationForm' => 'BaconUser\Form\Factory\RegistrationFormFactory'
        )
    ),

    'hydrators' => array(
        'factories' => array(
            'BaconUser\Hydrator\RegistrationHydrator' => 'BaconUser\Hydrator\Factory\RegistrationHydratorFactory'
        )
    ),

    'input_filters' => array(
        'factories' => array(
            'BaconUser\InputFilter\RegistrationFilter' => 'BaconUser\InputFilter\Factory\RegistrationFilterFactory'
        )
    )
);
