<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=umka',
//    'username' => 'umkadb',
//    'password' => 'FDHnji532n%$hgf',

    'charset' => 'utf8',
    'enableSchemaCache' => true,

            // Duration of schema cache.
            'schemaCacheDuration' => 3600,

            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',
];
