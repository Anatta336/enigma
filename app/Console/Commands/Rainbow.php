<?php

namespace App\Console\Commands;

use App\Models\Machine;
use App\Models\Reflector;
use App\Models\Rotor;
use App\Service\Rotation;
use Generator;
use Illuminate\Console\Command;

class Rainbow extends Command
{
    protected $signature = 'enigma:rainbow {input=HELLONETMATTERS}';

    protected $description = 'Generate a "rainbow table" of all possible rotor setting results for a given message.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $input = $this->argument('input');
        $rotorComboCount = iterator_count($this->rotorCombinations());
        $indexComboCount = iterator_count($this->indexCombinations());
        $total = $rotorComboCount * $indexComboCount;

        $this->info("Generating rainbow table of {$total} results for: {$input}");

        $results = [];
        $bar = $this->output->createProgressBar($total);

        foreach ($this->rotorCombinations() as $rotors) {

            foreach ($this->indexCombinations() as $indices) {

                $results[] = [
                    $rotors[0],
                    $indices[0],

                    $rotors[1],
                    $indices[1],

                    $rotors[2],
                    $indices[2],

                    $this->encrypt($rotors, $indices, $input),
                ];

                // @TODO decide how to store these results.

                $bar->advance();
            }
        }

        $this->info('');
        $this->table(['left', '', 'middle', '', 'right', '', 'encrypted'], $results);
    }

    /**
     * Generates every possible combination of rotors, assuming each rotor can only be used once.
     */
    protected function rotorCombinations(): Generator
    {
        $allRotorNames = array_map(function (array $rotor) {
            return $rotor['name'];
        }, config('enigma.rotors'));

        foreach ($allRotorNames as $rightName) {

            foreach ($allRotorNames as $middleName) {

                if ($middleName === $rightName) {
                    // Don't allow the same rotor to be used in two places.
                    continue;
                }

                foreach ($allRotorNames as $leftName) {
                    if ($leftName === $rightName || $leftName === $middleName) {
                        // Don't allow the same rotor to be used in two places.
                        continue;
                    }

                    yield [
                        $leftName,
                        $middleName,
                        $rightName,
                    ];
                }
            }
        }
    }

    protected function indexCombinations(): Generator
    {
        for ($i = 0; $i < Rotation::LOOP_SIZE; $i++) {
            for ($j = 0; $j < Rotation::LOOP_SIZE; $j++) {
                for ($k = 0; $k < Rotation::LOOP_SIZE; $k++) {
                    yield [$k, $j, $i];
                }
            }
        }
    }

    protected function encrypt(array $rotors, array $indices, string $input): string
    {
        $machine = new Machine(
            Reflector::fromConfig('UKW-B'),
            Rotor::fromConfig($rotors[0])
                ->setIndexRingPosition($indices[0]),
            Rotor::fromConfig($rotors[1])
                ->setIndexRingPosition($indices[1]),
            Rotor::fromConfig($rotors[2])
                ->setIndexRingPosition($indices[2]),
        );

        $output = '';

        foreach (mb_str_split($input) as $letter) {
            $output .= $machine->encryptLetter($letter);
        }

        return $output;
    }
}
