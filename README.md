# 🛒 EazyStore - Plateforme E-Commerce Complète

## 📋 Description

EazyStore est une plateforme e-commerce complète développée avec Laravel, permettant la vente en ligne de produits avec gestion des commandes, paiements et interface d'administration avancée.

## ✨ Fonctionnalités

### 🛍️ Front-Office Client
- **Catalogue de produits** avec filtrage, recherche et pagination
- **Fiche produit** détaillée avec images multiples
- **Gestion du panier** (ajout, suppression, modification des quantités)
- **Passage de commande** avec adresse de livraison
- **Choix de paiement** : en ligne ou à la livraison
- **Compte client** avec historique des commandes
- **Téléchargement de factures PDF**
- **Notifications par email** automatiques

### 🎛️ Back-Office Administrateur
- **Tableau de bord** avec statistiques complètes
- **Gestion des produits** (CRUD avec images et stock)
- **Gestion des catégories** (CRUD)
- **Gestion des commandes** avec modification des statuts
- **Gestion des utilisateurs** (liste, modification, historique)
- **Statistiques avancées** :
  - Chiffre d'affaires total et mensuel
  - Nombre de commandes par période
  - Produits les plus vendus
  - Suivi des paiements
  - Alertes produits en rupture

### 💳 Gestion des Paiements
- **Paiement en ligne** (simulation)
- **Paiement à la livraison** avec marquage manuel
- **Gestion des statuts** de paiement
- **Factures PDF** automatiques

### 📧 Notifications Automatiques
- **Confirmation de commande**
- **Mise à jour des statuts** (expédiée, livrée, annulée)
- **Confirmation de paiement**

## 🚀 Installation

### Prérequis
- PHP 8.1 ou supérieur
- Composer
- MySQL/MariaDB
- Node.js et NPM (pour les assets)

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone https://github.com/parfait1510/EazyStore.git
cd EazyStore
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configuration de la base de données**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eazystore
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migration et seeding**
```bash
php artisan migrate
php artisan db:seed
```

6. **Configuration du stockage**
```bash
php artisan storage:link
```

7. **Compilation des assets**
```bash
npm run dev
```

8. **Démarrer le serveur**
```bash
php artisan serve
```

## 👥 Comptes par défaut

### Administrateur
- **Email** : admin@eazystore.com
- **Mot de passe** : password

### Client de test
- **Email** : client@eazystore.com
- **Mot de passe** : password

## 📊 Fonctionnalités Administrateur

### Tableau de bord
- **Statistiques générales** : CA total, commandes, produits, clients
- **Statistiques mensuelles** : CA du mois, commandes du mois
- **Produits les plus vendus** (top 5)
- **Commandes par statut**
- **Produits en rupture de stock**
- **Commandes récentes** avec actions rapides

### Gestion des produits
- **Création/Modification** avec upload d'images
- **Gestion du stock** automatique
- **Association aux catégories**
- **Validation des données**

### Gestion des commandes
- **Visualisation détaillée** des commandes
- **Modification des statuts** avec emails automatiques
- **Marquage des paiements** à la livraison
- **Génération de factures PDF**

## 🛠️ Technologies utilisées

### Backend
- **Laravel 10** - Framework PHP
- **MySQL** - Base de données
- **DomPDF** - Génération de PDF
- **Laravel Mail** - Envoi d'emails

### Frontend
- **Bootstrap 5** - Framework CSS
- **FontAwesome** - Icônes
- **jQuery** - JavaScript

### Outils de développement
- **PHPUnit** - Tests unitaires
- **Laravel Mix** - Compilation des assets

## 📁 Structure du projet

```
EazyStore/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Contrôleurs admin
│   │   └── ...              # Contrôleurs client
│   ├── Models/              # Modèles Eloquent
│   ├── Services/            # Services métier
│   └── Mail/                # Classes d'emails
├── resources/
│   ├── views/
│   │   ├── admin/           # Vues admin
│   │   ├── emails/          # Templates d'emails
│   │   └── pdfs/            # Templates PDF
│   └── ...
├── database/
│   ├── migrations/          # Migrations
│   └── seeders/             # Seeders
├── tests/                   # Tests unitaires
└── routes/
    ├── web.php              # Routes client
    └── admin.php            # Routes admin
```

## 🧪 Tests

### Exécuter les tests
```bash
php artisan test
```

### Tests disponibles
- **OrderTest** - Tests des commandes
- **CartTest** - Tests du panier
- **AuthenticationTest** - Tests d'authentification

## 📧 Configuration des emails

### Configuration SMTP
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre-email@gmail.com
MAIL_FROM_NAME="EazyStore"
```

## 🔧 Configuration avancée

### Génération de PDF
Le projet utilise DomPDF pour la génération de factures. Assurez-vous que l'extension PHP GD est activée :

```ini
extension=gd
```

### Stockage des fichiers
Les images sont stockées dans `storage/app/public/`. Créez le lien symbolique :

```bash
php artisan storage:link
```

## 📈 Fonctionnalités avancées

### Statistiques en temps réel
- **Chiffre d'affaires** par période
- **Top produits** vendus
- **Alertes** stock faible
- **Suivi** des paiements

### Sécurité
- **Validation** des données
- **Protection CSRF**
- **Authentification** sécurisée
- **Gestion des permissions**

### Performance
- **Pagination** des listes
- **Optimisation** des requêtes
- **Cache** des vues
- **Compression** des assets

### Pages légales
- **Conditions Générales de Vente (CGV)**
- **Mentions légales**
- **Politique de confidentialité**

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👨‍💻 Équipe de développement

- **Front-Office** - [Nom & Prénom]
- **Back-Office** - [Nom & Prénom]
- **Tests & Documentation** - [Nom & Prénom]

## 📞 Support

Pour toute question ou problème :
- **Repository GitHub** : https://github.com/parfait1510/EazyStore.git
- **Documentation** : Voir les fichiers README.md et GUIDE_ACTION_RAPIDE.md

## 🚀 Déploiement

### Production
1. **Configuration** de l'environnement
2. **Optimisation** des assets
3. **Configuration** de la base de données
4. **Mise en place** du serveur web

### Variables d'environnement
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com
```

---

**EazyStore** - Votre boutique en ligne de confiance 🛒✨
