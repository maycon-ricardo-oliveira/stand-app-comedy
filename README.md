## About

Simple project to use for new projects


### Requirements:

- [Docker](https://www.docker.com/) and [Docker-Compose](https://docs.docker.com/compose/);

### Standards:

- [PHP - PSR-12](https://www.php-fig.org/psr/psr-12/);
- [Conventional Commits](https://www.conventionalcommits.org/);

## Let's get started!

After completing all requirements, you can navigate to your application directory and run the following commands on your terminal:

- `git clone git@github.com:PlayKids/base_project.git`

Rename the fold to your preference name:
- `mv base_project your_fold`
- `cd your_fold`
- `cp .env.example .env`

It's recommend renaming container names in the file docker-compose.yml before running this commands.

- `docker-compose up -d`
- `docker exec -it base_project bash` or `docker exec -it your_project bash`
- `composer install`
- `php artisan migrate`

 To check if the application is running, could you gonna to section api documentation. 


## API Documentation

To apply the changes made to the controller notations, run the command in container `composer docs`.
After that can you go to url `http://localhost/api/documentation`

Maybe the error 'Failed to load API definition' appears in the /documentation route. To solve it, you need to grant write permission to the storage/api-docs/ directory.

Run the command: `chmod -R 777 storage`

## Checking Code Patterns
To check code patterns, execute same the follow commands in the bash terminal.
* `composer cs your_fold/your_file`  to show problems 
or
* `composer cbf your_fold/your_file`  to solve problems

## Running Tests
To run tests, execute same the follow commands in the bash terminal.
* `composer test`  or
* `composer testdox`  or
* `vendor/bin/phpunit --testdox`


## Good luck and have fun :)

To do:
- [ ] Criar teste para o api response
- [ ] Criar uma tabela padrão config settings
- [ ] Pesquisar sobre slint para php
- [ ] Criar o sh para os comandos de get start
- [ ] Implementar uma rota completa para o config settings
- [ ] Add configurações de infra

# stand-app-comedy
# stand-app-comedy
