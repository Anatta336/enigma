<?php

namespace Tests\Feature;

use Tests\TestCase;

class EncodeTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideExampleEncoding
     */
    public function encodes_as_expected($settings, $encoded): void
    {
        $parameters = [
            'rotors' => [
                'leftRotor' => [
                    'name' => $settings['leftRotorName'],
                ],
                'leftIndex' => $settings['leftIndex'],

                'middleRotor' => [
                    'name' => $settings['middleRotorName'],
                ],
                'middleIndex' => $settings['middleIndex'],

                'rightRotor' => [
                    'name' => $settings['rightRotorName'],
                ],
                'rightIndex' => $settings['rightIndex'],
            ],
            'input' => $settings['input'],
        ];

        $queryString = http_build_query($parameters);

        $response = $this->get('/api/v1/encode?'.$queryString);

        $response->assertStatus(200);
        $response->assertContent($encoded);
    }

    public function provideExampleEncoding(): array
    {
        // Following have been checked against: https://piotte13.github.io/enigma-cipher/
        // with identity plugboard, and message code always left at A A A.
        // (Ideally would check against a real machine of course.)
        return [
            [
                // settings
                [
                    'leftRotorName' => 'III',
                    'leftIndex' => 0,
                    'middleRotorName' => 'II',
                    'middleIndex' => 0,
                    'rightRotorName' => 'I',
                    'rightIndex' => 0,
                    'input' => 'HELLONETMATTERS'
                ],
                // expected response
                'MFNCZPHPTPWDSQR'
            ],
            [
                [
                    'leftRotorName' => 'I',
                    'leftIndex' => 3,
                    'middleRotorName' => 'III',
                    'middleIndex' => 4,
                    'rightRotorName' => 'V',
                    'rightIndex' => 21,
                    'input' => 'HELLONETMATTERS'
                ],
                'CXJZZXAZNICFNQX'
            ],
            [
                // This setup triggers the middle rotor to advance on the 'O'
                // Just for fun, the route to the reflector for 'H' is a "straight through".
                [
                    'leftRotorName' => 'III',
                    'leftIndex' => 20,
                    'middleRotorName' => 'I',
                    'middleIndex' => 15,
                    'rightRotorName' => 'II',
                    'rightIndex' => 8,
                    'input' => 'HELLONETMATTERS'
                ],
                'SQIZLBRXQQPQGQY'
            ],
        ];
    }
}
