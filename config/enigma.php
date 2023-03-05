<?php

return [
    'rotors' => [
        // Mappings are given for ring setting 0, with the first letter what an 'A' would map to, then 'B', etc.,
        [
            'name' => 'Rotor I',
            'mapping' => [
                'E', 'K', 'M', 'F', 'L', 'G', 'D', 'Q', 'V', 'Z', 'N', 'T', 'O', 'W', 'Y', 'H', 'X', 'U', 'S', 'P', 'A', 'I', 'B', 'R', 'C', 'J'
            ],
            'notch' => 'Q',
        ],
        [
            'name' => 'Rotor II',
            'mapping' => [
                'A', 'J', 'D', 'K', 'S', 'I', 'R', 'U', 'X', 'B', 'L', 'H', 'W', 'T', 'M', 'C', 'Q', 'G', 'Z', 'N', 'P', 'Y', 'F', 'V', 'O', 'E'
            ],
            'notch' => 'E',
        ],
        [
            'name' => 'Rotor III',
            'mapping' => [
                'B', 'D', 'F', 'H', 'J', 'L', 'C', 'P', 'R', 'T', 'X', 'V', 'Z', 'N', 'Y', 'E', 'I', 'W', 'G', 'A', 'K', 'M', 'U', 'S', 'Q', 'O'
            ],
            'notch' => 'V',
        ],
        [
            'name' => 'Rotor IV',
            'mapping' => [
                'E', 'S', 'O', 'V', 'P', 'Z', 'J', 'A', 'Y', 'Q', 'U', 'I', 'R', 'H', 'X', 'L', 'N', 'F', 'T', 'G', 'K', 'D', 'C', 'M', 'W', 'B'
            ],
            'notch' => 'J',
        ],
        [
            'name' => 'Rotor V',
            'mapping' => [
                'V', 'Z', 'B', 'R', 'G', 'I', 'T', 'Y', 'U', 'P', 'S', 'D', 'N', 'H', 'L', 'X', 'A', 'W', 'M', 'J', 'Q', 'O', 'F', 'E', 'C', 'K'
            ],
            'notch' => 'Z',
        ],
    ],
    'reflectors' => [
        // Unlike rotors, reflectors are symmetric. If A maps to E then E maps to A.
        [
            'name' => 'UKW-A',
            'mapping' => [
                'E', 'J', 'M', 'Z', 'A', 'L', 'Y', 'X', 'V', 'B', 'W', 'F', 'C', 'R', 'Q', 'U', 'O', 'N', 'T', 'S', 'P', 'I', 'K', 'H', 'G', 'D'
            ],
        ],
        [
            'name' => 'UKW-B',
            'mapping' => [
                'Y', 'R', 'U', 'H', 'Q', 'S', 'L', 'D', 'P', 'X', 'N', 'G', 'O', 'K', 'M', 'I', 'E', 'B', 'F', 'Z', 'C', 'W', 'V', 'J', 'A', 'T'
            ],
        ],
        [
            'name' => 'UKW-C',
            'mapping' => [
                'F', 'V', 'P', 'J', 'I', 'A', 'O', 'Y', 'E', 'D', 'R', 'Z', 'X', 'W', 'G', 'C', 'T', 'K', 'U', 'Q', 'S', 'B', 'N', 'M', 'H', 'L'
            ],
        ],
    ],
];
