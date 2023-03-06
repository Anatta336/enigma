# Enigma
This is a program created as part of a learning exercise.

It attempts to simulate the workings of the Enigma I machine. It is intended as a toy project and should not be used for encryption or decryption of sensitive information.

## License
This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).

This project makes uses of the Laravel framework which is open-sourced software also licensed under the [MIT license](https://opensource.org/licenses/MIT).

This project includes some details of the wiring and configuration of certain models of the Enigma machine. The project makes no claims over this information, which is assumed to be in the public domain.

## Usage
This is a basic Laravel-based project, using Sail to package it up in Docker containers.

Assuming you already have a recent version of Docker working, you should just need to clone the repository, navigate into the directory and run:

```
./vendor/bin/sail up -d
./vendor/bin/sail npm install
./vendor/bin/sail npm dev
```

You should then be able to access the simple site running at http://localhost:80

To bring down the containers:
```
./vendor/bin/sail down
```

If you need it to run on another port, that can be adjusted in the `docker-compose.yml` file. Changes to that only take effect after the containers are brought down and then up again. e.g. `sail down`, make changes, `sail up -d`.
