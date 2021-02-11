# Agence de voyages


#### Installation du projet étape par étape

                            Installation avec base de données vide

> composer install
>
> php bin/console doctrine:database:create
>
> php bin/console doctrine:migrations:migrate
>
> symfony server:start
>

                            Installation avec import d'une base de données

> composer install
>
> php bin/console doctrine:database:create
>
> php bin/console doctrine:database:import db/travels.sql
>
> symfony server:start


#### Mettre à jour des éléments dans la base de données.

Après une modification sur une entity il faut effectuer les commandes suivantes :

> php bin/console make:migration
>
> php bin/console doctrine:migrations:migrate
>

S'il n'y a que le schéma de base de données à mettre à jour, il faut faire la commande suivante :

> php bin/console doctrine:schema:update
>

#### Autres informations

> Effectuer ses tests unitaires [tests unitaires](docs/TESTS.md)

> [Mes choix / Améliorations possibles](docs/ENHANCEMENTS.md)

> [Remerciements](docs/THANKS.md)

> Visiblité du projet en ligne  : https://transport.mthaize.fr