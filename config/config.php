<?php

/* 
 * Конфигурация приложения
 */

$config = [
    // компоненты которые должны инициилизироваться при загрузке
    'components' => [ 
       'cache' => 'fm\libs\Cache',
//        'mail' => 'fm\libs\Mail',
        'errorHandler' => 'fm\core\ErrorHandler',
        'collector' => 'fm\core\Collector',
    ],
    'settings' => [], // массив настроек
];

return $config;
