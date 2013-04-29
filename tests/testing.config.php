<?php
return array_replace_recursive(
    array(
        'modules' => array(
            'BaconUser',
            'DoctrineORMModule',
            'DoctrineModule',
        ),
        'module_listener_options' => array(
            'module_paths' => array(),
        ),
        'doctrine' => array(
            'connection' => array(
                'orm_default' => array(
                    'configuration' => 'orm_default',
                    'eventmanager' => 'orm_default',
                    'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                    'params' => array(
                        'memory' => true,
                    ),
                ),
            ),
        ),
        'service_manager' => array(
            'factories' => array(
                'Doctrine\Common\DataFixtures\Executor\AbstractExecutor' => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
                    $schemaTool->createSchema($em->getMetadataFactory()->getAllMetadata());
                    return new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($em, new \Doctrine\Common\DataFixtures\Purger\ORMPurger($em));
                },
            ),
        ),
    ),
    include __DIR__ . '/../config/module.config.php'
);
