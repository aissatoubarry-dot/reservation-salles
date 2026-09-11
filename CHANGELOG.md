# Changelog

## v1.0.0 - Version finale

### Ajouté
- Gestion des salles universitaires
- Création et modification des salles
- Gestion des réservations
- Annulation des réservations
- Validation des données
- DTO et Builders
- Repositories
- Services métier
- Routage avec FastRoute
- Injection de dépendances avec PHP-DI
- Tests unitaires et d'intégration
- Interface web avec CSS responsive
- Messages de succès et d'erreur

### Sécurité et qualité
- Validation des données reçues depuis les formulaires
- Échappement des données affichées dans les vues
- Séparation des responsabilités entre les différentes couches
- Gestion des erreurs HTTP 404 et 405

### Infrastructure
- Configuration Eloquent/MySQL
- Migrations avec Eloquent
- Données initiales avec le seeder
- Dockerisation de l'application

## v0.12.0 - Tests

- Ajout des tests unitaires
- Ajout des tests d'intégration
- Validation des règles métier de réservation
- Tests de validation
- Tests des repositories

## v0.11.0 - Conteneur PHP-DI

- Configuration de PHP-DI
- Injection des dépendances
- Autowiring
- Configuration des interfaces
- Création de `ContainerFactory`
- Ajout du point d'entrée `Application`

## v0.10.0 - Router

- Ajout de FastRoute
- Gestion des routes dynamiques
- Gestion des erreurs 404 et 405

## v0.9.0 - Interface web

- Création des contrôleurs
- Création des vues
- Gestion des formulaires
- Affichage des salles et réservations

## v0.8.0 - Services métier

- Création du service de réservation
- Création du service d'annulation
- Gestion des conflits de réservation
- Ajout des exceptions métier

## v0.7.0 - Repositories

- Création des interfaces Repository
- Implémentation des repositories avec Eloquent

## v0.6.0 - DTO et Builders

- Création des DTO
- Ajout des Builders
- Typage des données transportées

## v0.5.0 - Validation

- Ajout de `ValidatorInterface`
- Ajout des validateurs
- Validation avec Respect\Validation
- Gestion de plusieurs erreurs de validation

## v0.4.0 - Données initiales

- Ajout des données initiales des salles
- Création du script de seed

## v0.3.0 - Modèles

- Création des modèles Eloquent
- Mise en place des relations Salle/Reservation

## v0.2.0 - Eloquent

- Configuration de Capsule
- Connexion MySQL
- Création des migrations

## v0.1.0 - Composer

- Configuration de Composer
- Mise en place de l'autoloading PSR-4
- Installation des dépendances

## v0.0.0 - Initialisation

- Initialisation du dépôt Git
- Création du README.md
- Création du CHANGELOG.md
- Création du .gitignore