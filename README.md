# Agence de voyages


#### Installation du projet étape par étape

> composer install
>
> php bin/console doctrine:database:create
>
> php bin/console doctrine:migrations:migrate
>
> php bin/console doctrine:fixtures:load
>
> symfony server:start
>

#### Mettre à jour des éléments dans la base de données.

Après une modification sur une entity il faut effectuer les commandes suivantes :

> php bin/console make:migration
>
> php bin/console doctrine:migrations:migrate
>

S'il n'y a que le schéma de base de données à mettre à jour, il faut faire la commande suivante :

> php bin/console doctrine:schema:update
>

#### Autres....

> Effectuer ses tests unitaires [tests unitaires](docs/TESTS.md)


> Visiblité du développement en ligne  : https://transport.mthaize.fr