<?php

/*
 * This file is part of the EOffice project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [
    'App\User' => [
        'type' => 'entity',
        'table' => 'users',
        'id' => [
            'id' => [
                'type' => 'integer',
                'strategy' => 'identity',
            ],
        ],
        'fields' => [
            'name' => [
                'type' => 'string',
            ],
        ],
    ],
];
