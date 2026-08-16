\# Pressing LIC — Plateforme de gestion de pressing



Application de gestion de commandes pour un pressing/laverie : catalogue de services, dépôt de commandes, suivi de statut et notifications automatiques.



\## Stack technique



\- \*\*Backend\*\* : Laravel 12 + Sanctum (API REST + authentification par token) + MySQL

\- \*\*Frontend\*\* : Angular (standalone components, signals) + SCSS

\- \*\*Emails\*\* : Laravel Mail (driver `log` en local) + DomPDF pour les reçus PDF



\## Fonctionnalités



\- Authentification (inscription client, connexion, compte gestionnaire créé en base)

\- Catalogue de services (CRUD gestionnaire, consultation publique)

\- Dépôt de commandes avec panier (client)

\- Cycle de statuts : Reçu → En traitement → Prêt → Récupéré (gestionnaire)

\- Annulation de commande (gestionnaire)

\- Notifications automatiques par email + génération PDF du reçu



> Sections volontairement non traitées (consigne du professeur) : gestion des paiements, statistiques/rapports.



\## Installation



\### Prérequis



\- PHP 8.2+, Composer

\- Node.js 18+, npm

\- MySQL



\### Backend (`pressing-api`)



```bash

cd pressing-api

composer install

cp .env.example .env

php artisan key:generate

```



Configure la base de données dans `.env` :

```env

DB\_CONNECTION=mysql

DB\_DATABASE=pressing\_lic

DB\_USERNAME=root

DB\_PASSWORD=

```



Puis :

```bash

php artisan migrate:fresh --seed

php artisan serve

```



L'API tourne sur `http://127.0.0.1:8000`.



\### Frontend (`pressing-frontend`)



```bash

cd pressing-frontend

npm install

ng serve

```



L'application tourne sur `http://localhost:4200`.



\## Comptes de test



| Rôle | Email | Mot de passe |

|---|---|---|

| Gestionnaire | gestionnaire@pressinglic.com | password123 |

| Client (démo) | client.demo@pressinglic.com | password123 |



\## Structure du projet



```

pressing-api/        Backend Laravel (API REST)

&#x20; app/Http/Controllers/   AuthController, ServiceController, TicketController

&#x20; app/Models/              User, Service, Ticket

&#x20; app/Mail/                Mailables (confirmation, notification, reçu PDF)

&#x20; database/seeders/        Données de démonstration



pressing-frontend/   Frontend Angular

&#x20; src/app/services/        AuthService, TicketService, ServiceApi

&#x20; src/app/guards/          authGuard, gestionnaireGuard

&#x20; src/app/interceptors/    Injection automatique du token JWT

&#x20; src/app/pages/           Login, Register, Catalogue, Mes tickets, Gestion

```

