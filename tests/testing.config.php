<?php
return array(
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
    'bacon_user' => array(
        'password' => array(
            'handler_aggregate' => array(
                'default_hashing_method' => 'simple-sha1',
                'hashing_methods' => array(
                    'simple-sha1',
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
);
