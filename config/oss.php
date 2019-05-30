<?php
return [
    'ossServer' => env('ALIOSS_SERVER', null),                      // 外网
    'ossServerInternal' => env('ALIOSS_SERVERINTERNAL', null),      // 内网
    'AccessKeyId' => env('ALIOSS_KEYID', null),                     // key
    'AccessKeySecret' => env('ALIOSS_KEYSECRET', null),             // secret
    'BucketName' => env('ALIOSS_BUCKETNAME', null),                 // bucket
    'AccessCity' => env('ALIOSS_CITY', null),                       // city
    'OSSDomain' => env('ALIOSS_DOMAIN', 'www.sanye666.top')         // OSS 域名

];