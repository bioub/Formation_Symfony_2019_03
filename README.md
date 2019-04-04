# Exercices

## Routes

Créer un controller ContactController

Créer 5 routes dans ce controller

* list : /contacts
* show : /contacts/123 (123 est paramétrable)
* create : /contacts/add
* update : /contacts/123/update
* delete : /contacts/123/delete

Avec le template et l'appel à render comme dans HomeController::index

Optionnel : forcer 123 à un entier positif avec requirements

## Doctrine

Créer l'entité `Contact` avec `make:entity`

Avec comme propriétés :

* firstName
* lastName
* email
* phone

Générer la table avec `make:migration` + `doctrine:migrations:migrate`

ou `doctrine:schema:update --dump-sql` puis `--force`

Dans un 2e temps

Ajouter une colonne 

* birthdate

Ajouter les getters/setters (`make:entity --regenerate`)

Mettre à jour la table avec migration ou update du schema
