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
    ],
    'settings' => [], // массив настроек
];

return $config;
