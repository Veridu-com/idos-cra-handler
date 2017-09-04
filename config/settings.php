<?php
/*
 * Copyright (c) 2012-2016 Veridu Ltd <https://veridu.com>
 * All rights reserved.
 */

declare(strict_types = 1);

use Cli\Utils\Env;

if (! defined('__VERSION__')) {
    define('__VERSION__', Env::asString('IDOS_VERSION', '1.0'));
}

$appSettings = [
    'debug'                             => Env::asBool('IDOS_DEBUG', false),
    'displayErrorDetails'               => Env::asBool('IDOS_DEBUG', false),
    'determineRouteBeforeAppMiddleware' => true,
    'log'                               => [
        'path' => Env::asString(
            'IDOS_LOG_FILE',
            sprintf(
                '%s/../log/cra.log',
                __DIR__
            )
        ),
        'level' => Monolog\Logger::DEBUG
    ],
    'tracesmart' => [
       'wsdl'   => Env::asString('IDOS_CRA_TRACESMART_ENDPOINT', 'https://iduws.tracesmart.co.uk/v3.3/?wsdl'),
       'auth' => [
            'veridu' => [
                'user' => Env::asString('IDOS_CRA_TRACESMART_USER', ''),
                'pass' => Env::asString('IDOS_CRA_TRACESMART_PASS', ''),
                'equifax' => Env::asString('IDOS_CRA_TRACESMART_EQUIFAX', '')
            ]
        ],
        'fields' => [
            'address' => [
                'firstname',
                'lastname',
                'address1',
                'postcode'
            ],
            'deathscreen' => [
                'firstname',
                'lastname',
                'birthyear',
                'birthmonth',
                'birthday',
                'address1',
                'postcode'
            ],
            'dob' => [
                'firstname',
                'lastname',
                'birthyear',
                'birthmonth',
                'birthday',
                'address1',
                'postcode'
            ],
            'telephone' => [
                'telephone'
            ],
            'passport' => [
                'birthyear',
                'birthmonth',
                'birthday',
                'gender',
                'passport1',
                'passport2'
            ],
            'driving' => [
                'firstname',
                'middlename',
                'lastname',
                'birthyear',
                'birthmonth',
                'birthday',
                'gender',
                'drivinglicence'
            ],
            'birth' => [
                'birthfname',
                'birthlname',
                'mothermname'
            ],
            'smartlink' => [
                'firstname',
                'lastname',
                'gender',
                'birthyear',
                'birthmonth',
                'birthday',
                'address1',
                'postcode'
            ],
            'ni' => [
                'ninumber'
            ],
            'nhs' => [
                'nhsnumber'
            ],
            'card-avs' => [
                'card-type',
                'card-holdername',
                'card-number',
                'card-expiredate',
                'card-cv2',
                'card-address1',
                'card-address2',
                'card-address3',
                'card-postcode'
            ],
            'card-number' => [
                'cardnumber'
            ],
            'sanction' => [
                'firstname',
                'lastname'
            ],
            'insolvency' => [
                'firstname',
                'lastname',
                'birthyear',
                'birthmonth',
                'birthday',
                'gender'
            ],
            'mpan' => [
                'address1',
                'postcode',
                'mpanumber1',
                'mpanumber2',
                'mpanumber3',
                'mpanumber4'
            ],
            'bankmatch' => [
                'sortcode',
                'accountnumber'
            ],
            'crediva' => [
                'firstname',
                'lastname',
                'birthyear',
                'birthmonth',
                'birthday',
                'address1',
                'postcode'
            ],
            'ccj-dob' => [
                'firstname',
                'lastname',
                'birthyear',
                'birthmonth',
                'birthday',
            ],
            'ccj-address' => [
                'firstname',
                'lastname',
                'address1',
                'postcode'
            ],
            'mobile' => [
                'phone'
            ],
            'credit-active' => [
                'firstname',
                'lastname',
                'birthyear',
                'birthmonth',
                'birthday',
                'address1',
                'postcode'
            ],
            'travel-visa' => [
                'birthyear',
                'birthmonth',
                'birthday',
                'gender',
                'travelvisa1',
                'travelvisa2',
                'travelvisa3',
                'travelvisa4',
                'travelvisa5',
                'travelvisa6',
                'travelvisa7',
                'travelvisa8'
            ],
            'id-card' => [
                'birthyear',
                'birthmonth',
                'birthday',
                'gender',
                'idcard1',
                'idcard2',
                'idcard3',
                'idcard5',
                'idcard6',
                'idcard7',
                'idcard8',
                'idcard10'
            ],
            'bankmatch-live' => [
                'firstname',
                'lastname',
                'birthyear',
                'birthmonth',
                'birthday',
                'address1',
                'postcode',
                'sortcode',
                'accountnumber'
            ],
            'company-director' => [
                'firstname',
                'lastname',
                'address1',
                'postcode'
            ],
            'search-activity' => [
                'firstname',
                'lastname',
                'birthyear',
                'birthmonth',
                'birthday',
                'address1',
                'postcode'
            ]
        ]
    ],
    'gearman' => [
        'timeout' => 1000,
        'servers' => Env::asString('IDOS_GEARMAN_SERVERS', 'localhost:4730')
    ]
];
