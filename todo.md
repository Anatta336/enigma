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
[ ] Store data in redis?
[ ] Estimate time while progressing.

### Data structure
Access speed is way of looking up via the encrypted result is the important part to get right.

## Phase 3 - Decryption without plugboard
So long as we assume the "message code" is always AAA then we'll almost certainly be able to know the full details.

If the message code is not know, we'll very likely not know where the notch is on the middle rotor, and possibly not know where it is on the right.

### Actions

## Phase 4 - Plugboard
We can immediately know what the plugboard settings for letters HELONTMARS and whatever they're connected to. Others we'd have to experiment with to find results that look good.

### Actions
[ ] Model plugboard.
[ ] Frontend for plugboard.
[ ] Allow manually encrypting with plugboard settings.
