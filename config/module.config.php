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
);
