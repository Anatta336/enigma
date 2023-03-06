# Enigma

## Phase 1 - Model a Virtual Enigma
### Objective
User should be able to specify the start conditions and message to be put through the system.

In response they will receive a properly encoded result.

### Actions
[x] Model a static rotor.
[x] Model a reflector (as a rotor?)
[x] Input data for the 5 rotors and reflector.
[x] Model series of rotors and reflector.
[x] Model index ring position on rotors.
[x] Model rotor's current rotation.
[x] Model rotors moving, with notch.
[x] Give initial settings.
[x] Receive series of input and give output.

### Example code for Tinker
```
$machine = new App\Models\Machine(App\Models\Reflector::fromConfig('UKW-B'), App\Models\Rotor::fromConfig('III'), App\Models\Rotor::fromConfig('II'), App\Models\Rotor::fromConfig('I'));
```

```
$rotor = App\Models\Rotor::fromConfig('I');
```

## Phase 2 - Rainbow tables
### Objective
Generate how "HELLONETMATTERS" gets encrypted for each of the approx 1 million starting conditions for the 3 rotors.

### Actions
[x] Basic command structure.
[x] Store data in redis.

### Performance
Generating rainbow table on my local machine for the 5 rotors and all 26 index ring positions:

```
Generating rainbow table of 1054560 results for: HELLONETMATTERS
Complete. Took 689.721s
```

Doesn't look to be using resources very effectively. Actual machine's CPU cores (6 physical, 12 logical) are only 25% busy. The Sail container's around 86% CPU usage while it's generating.

Storage space taken up by Redis database with that one rainbow table is 66.6MB.

### Data structure
Set of rotor settings stored in Redis, keyed by the pairing of plaintext and encrypted text.

## Phase 3 - Decryption without plugboard
So long as we assume the "message code" is always AAA then we'll almost certainly be able to know the full details by looking up in the rainbow table.

### Actions
[x] Endpoint to lookup in rainbow table.
[x] Frontend to show possible settings.
[ ] Click a setting combination to set up the virtual Enigma with that.
[ ] Partial lookup. If we have a rainbow table of HELLONETMATTERS, should be able to look up all settings where "HELLO" encrypts in a certain way (without needing to generate a new table).

## Phase 4 - Simulate Plugboard

### Actions
[ ] Model plugboard.
[ ] Frontend for plugboard.
[ ] Allow manually encrypting with plugboard settings.

## Phase 5 - Decryption with Plugboard
We don't know what that message looks like as it enters the rotor system until we have the plugboard correct.

If we know what it looks like when entering the rotor system, we can look it up on the rainbow table to find rotor settings. But we don't know that yet.

On assumption that some letters are not swapped, could we find the rotor settings from those? We don't know which are not swapped of course. But possibly something there?
