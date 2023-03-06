<?php

namespace App\Console\Commands;

use App\Models\Machine;
use App\Models\Reflector;
use App\Models\Rotor;
use App\Service\Rotation;
use Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class Rainbow extends Command
{
    protected $signature = 'enigma:rainbow {input=HELLONETMATTERS}';

    protected $description = 'Generate a rainbow table of all possible encodings for a given message.';

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

        $bar = $this->output->createProgressBar($total);
        $startHrTime = hrtime(true);

        foreach ($this->rotorCombinations() as $rotors) {

            foreach ($this->indexCombinations() as $indices) {

                $encrypted = $this->encrypt($rotors, $indices, $input);

                // Store results as a set in Redis, keyed by the output.
                // Using sets as it's possible for multiple settings to result in the same output.
                $key = $input.'.'.$encrypted;
                $value = $this->encodeSettings($rotors, $indices);

                // Only add if it's not already there.
                if (!Redis::sismember($key, $value)) {
                    Redis::sadd($key, $value);
                }

                $bar->advance();
            }
        }

        // hrtime gives nanoseconds, which we convert to seconds for display.
        $formattedSeconds = number_format((hrtime(true) - $startHrTime) / 1_000_000_000, 3);

        $this->info('');
        $this->info("Complete. Took {$formattedSeconds}s");
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

    protected function encodeSettings(array $rotors, array $indices): string
    {
        return $rotors[0].'.'
            .$indices[0].'.'
            .$rotors[1].'.'
            .$indices[1].'.'
            .$rotors[2].'.'
            .$indices[2];
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
