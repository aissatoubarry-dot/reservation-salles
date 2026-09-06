# Gestion des réservations de salles universitaires

Application web développée en PHP orienté objet permettant de gérer les salles universitaires et leurs réservations.

## Technologies

- PHP 8.3
- MySQL
- Composer
- Eloquent
- FastRoute
- Respect\Validation
- PHP-DI
- PHP dotenv



## Étape 1 — Composer

### Questions

#### 1. Quel est le rôle de Composer ?

Composer est le gestionnaire de dépendances de PHP. Il permet d'installer les bibliothèques nécessaires au projet, de gérer leurs versions et de générer l'autoloading des classes.

#### 2. Quelle différence existe entre require et require-dev ?

`require` contient les dépendances nécessaires au fonctionnement de l'application.

`require-dev` contient les dépendances nécessaires uniquement pendant le développement, par exemple les outils de test.

#### 3. Pourquoi faut-il versionner composer.lock ?

`composer.lock` contient les versions précises des dépendances qui ont été résolues et installées. Il permet donc de reproduire le même environnement de dépendances sur une autre machine.

#### 4. Pourquoi ne versionne-t-on pas vendor/ ?

Le dossier `vendor/` contient les dépendances installées par Composer. Il peut être recréé avec `composer install` à partir de `composer.json` et `composer.lock`. Il n'est donc pas nécessaire de le versionner.

