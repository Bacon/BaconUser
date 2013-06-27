<?php
return array(
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
