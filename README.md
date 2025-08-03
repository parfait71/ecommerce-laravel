# 🛒 EazyStore - Plateforme E-Commerce

Application web e-commerce complète développée avec Laravel, offrant une solution complète pour la vente en ligne avec paiement intégré et gestion administrative.

## ✨ Fonctionnalités

### 🛍️ Front-office
- Catalogue de produits avec catégories
- Panier d'achat interactif
- Passage de commande avec choix de paiement
- Paiement en ligne (Wave/Orange Money)
- Paiement à la livraison
- Suivi des commandes
- Génération automatique de factures PDF
- Emails de confirmation automatiques

### 🔧 Back-office
- Tableau de bord avec métriques avancées
- Gestion des produits avec upload d'images multiples
- Gestion des catégories
- Gestion des commandes et utilisateurs
- Analytics avec graphiques interactifs
- Exports PDF/Excel des données

## 🚀 Installation

### Prérequis
- PHP 8.0+
- Composer
- MySQL/MariaDB

### Installation

1. **Cloner le projet**
```bash
git clone https://github.com/votre-username/EazyStore.git
cd EazyStore
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configuration**
```bash
cp .env.example .env
# Configurer la base de données dans .env
php artisan key:generate
php artisan migrate
php artisan storage:link
```

4. **Créer un compte admin**
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@eazystore.com',
    'password' => Hash::make('password'),
    'is_admin' => true,
    'email_verified_at' => now(),
]);
```

## 🔧 Configuration

### Email (dans .env)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-app
MAIL_ENCRYPTION=tls
```

### Paiement Wave (dans .env)
```env
WAVE_API_URL=https://api.wave.com
WAVE_API_KEY=votre-cle-api-wave
```

## 👥 Accès

- **Front-office** : `http://localhost:8000`
- **Back-office** : `http://localhost:8000/admin`
- **Admin** : `admin@eazystore.com` / `password`

## 🧪 Tests

```bash
php artisan test
```

## 📁 Structure

```
EazyStore/
├── app/
│   ├── Http/Controllers/    # Contrôleurs
│   ├── Models/             # Modèles
│   ├── Services/           # Services métier
│   └── Mail/              # Emails
├── resources/views/        # Vues Blade
├── database/migrations/    # Migrations
├── routes/web.php         # Routes
└── tests/                 # Tests
```

## 🔐 Sécurité

- Authentification Laravel Breeze
- Autorisation basée sur les rôles
- Validation des données
- Protection CSRF
- Hachage sécurisé des mots de passe

## 👨‍💻 Équipe

- **Gnawé Parfait** - Backend & API (Contrôleurs, Modèles, Services, Intégrations de paiement, Analytics, Tests)
- **Sokhna Ndack** - Frontend & UI/UX (Vues Blade, Templates, Interface utilisateur, Design responsive)

## 📞 Support

- 📧 Email : support@eazystore.com
- 🌐 Site web : https://eazystore.com

## 📝 Licence

Ce projet est sous licence MIT.

---

**EazyStore** - Solution e-commerce complète ! 🚀
