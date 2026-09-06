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



## Étape 2 — Configurer Eloquent

### 1. Quel rôle joue Capsule\Manager ?

`Capsule\Manager` permet de configurer et d'utiliser Eloquent en dehors de Laravel.
Il permet notamment de configurer la connexion à la base de données et de démarrer Eloquent.

### 2. Pourquoi Eloquent peut-il fonctionner sans Laravel ?

Eloquent est fourni séparément par le composant `illuminate/database`.
Il peut donc être utilisé sans installer le framework Laravel.
`Capsule\Manager` permet notamment cette utilisation autonome.

### 3. Où doit se trouver le démarrage de l'ORM ?

Le démarrage et la configuration de l'ORM doivent être centralisés dans la configuration technique de l'application, ici `config/database.php`.
Les classes métier ne doivent pas configurer elles-mêmes la connexion.

### 4. Quelle différence existe entre ORM et SQL écrit à la main ?

Avec SQL écrit à la main, le développeur écrit directement les requêtes SQL.

Avec un ORM comme Eloquent, on manipule des objets et des modèles PHP qui représentent les données de la base.
L'ORM génère ensuite les requêtes SQL nécessaires.




## Étape 3 — Créer les modèles

### 1. Quel type de relation Eloquent avez-vous utilisé ?

Nous avons utilisé :

- `HasMany` : une salle possède plusieurs réservations.
- `BelongsTo` : une réservation appartient à une salle.

### 2. Pourquoi déclarer `$fillable` ou `$guarded` ?

Pour contrôler les champs qui peuvent être remplis automatiquement par Eloquent et éviter les modifications de champs non autorisés.

### 3. Pourquoi convertir `active` en booléen ?

Parce que `active` représente un état vrai ou faux. Le cast permet donc d'utiliser `true` et `false` en PHP.

### 4. Pourquoi convertir les dates en objets ?

Pour pouvoir facilement comparer et manipuler les dates en PHP.




## Étape 4 — Données initiales

### 1. Quelle différence existe entre migration et seeder ?

La migration sert à créer et modifier la structure de la base de données, par exemple les tables, les colonnes et les contraintes.

Le seeder sert à insérer des données initiales dans les tables.

### 2. Pourquoi les données initiales doivent-elles être reproductibles ?

Parce qu'on peut avoir besoin de relancer le seeder plusieurs fois, par exemple lors de l'installation ou des tests du projet.

Le résultat doit rester cohérent et ne pas créer inutilement plusieurs fois les mêmes données.

### 3. Comment empêcher les doublons ?

On peut utiliser `firstOrCreate()`.

Cette méthode recherche d'abord si la salle existe déjà. Si elle existe, elle ne la recrée pas. Sinon, elle l'insère dans la base de données.




