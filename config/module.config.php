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
        'password_manager' => array(
            'default_hashing_method' => 'bcrypt',
            'upgrade_hashes' => true,
            'plugins' => array(
                'invokables' => array(
                    'bcrypt' => 'BaconUser\PasswordManager\Plugin\Bcrypt',
                    'md5'    => 'BaconUser\PasswordManager\Plugin\Md5',
                    'sha1'   => 'BaconUser\PasswordManager\Plugin\Sha1',
                ),
            ),
        ),
    ),
);
