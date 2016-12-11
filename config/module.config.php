<?php
return [
    'doctrine' => [
        'driver' => [
            'zfcuser_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/xml/zfcuser',
            ],

            'orm_default' => [
                'drivers' => [
                    'ZfcUser\Entity'  => 'zfcuser_entity',
                ],
            ],
        ],
    ],
];
