# 🚀 GUIDE DÉPLOIEMENT GRATUIT - EAZYSTORE

## 📋 **Prérequis**
- Compte GitHub avec le projet EazyStore
- Compte Vercel (gratuit)
- Application Laravel fonctionnelle localement

---

## 🌐 **ÉTAPE 1 : Préparation du projet**

### **1.1 Vérifier la configuration Laravel**
```bash
# Dans votre projet EazyStore
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **1.2 Créer le fichier vercel.json**
```json
{
    "version": 2,
    "builds": [
        {
            "src": "public/index.php",
            "use": "@vercel/php"
        }
    ],
    "routes": [
        {
            "src": "/(.*)",
            "dest": "public/index.php"
        }
    ]
}
```

### **1.3 Vérifier le fichier .env**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.vercel.app
```

---

## 🔗 **ÉTAPE 2 : Créer un compte Vercel**

### **2.1 Aller sur Vercel**
- Ouvrir : https://vercel.com
- Cliquer sur **"Sign Up"**
- Choisir **"Continue with GitHub"**

### **2.2 Autoriser Vercel**
- ✅ Autoriser l'accès à vos repositories GitHub
- ✅ Accepter les conditions d'utilisation

---

## 🚀 **ÉTAPE 3 : Déployer depuis GitHub**

### **3.1 Importer le projet**
- Dans Vercel, cliquer sur **"New Project"**
- Sélectionner le repository **"EazyStore"**
- Cliquer sur **"Import"**

### **3.2 Configuration du projet**
```
Project Name: eazystore
Framework Preset: Other
Root Directory: ./
Build Command: composer install --no-dev --optimize-autoloader
Output Directory: public
Install Command: composer install
```

### **3.3 Variables d'environnement**
Ajouter ces variables dans Vercel :
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:votre-clé-générée
APP_URL=https://votre-domaine.vercel.app
DB_CONNECTION=sqlite
DB_DATABASE=/tmp/database.sqlite
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## ⚙️ **ÉTAPE 4 : Configuration de la base de données**

### **4.1 Option 1 : SQLite (Recommandé pour le gratuit)**
```bash
# Créer la base SQLite
touch database/database.sqlite
```

### **4.2 Option 2 : Base de données externe**
- **PlanetScale** (gratuit)
- **Supabase** (gratuit)
- **Railway** (gratuit)

---

## 🔧 **ÉTAPE 5 : Commandes de déploiement**

### **5.1 Ajouter les commandes de build**
Dans Vercel, ajouter ces commandes :
```bash
# Build Command
composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache && php artisan view:cache

# Install Command
composer install
```

### **5.2 Configuration des routes**
Vérifier que `vercel.json` est bien présent à la racine du projet.

---

## 🚀 **ÉTAPE 6 : Déploiement**

### **6.1 Lancer le déploiement**
- Cliquer sur **"Deploy"**
- Attendre 2-3 minutes
- Vercel va automatiquement :
  - Installer les dépendances
  - Construire l'application
  - Déployer en ligne

### **6.2 Vérifier le déploiement**
- ✅ Site accessible
- ✅ Pas d'erreurs 500
- ✅ Base de données fonctionnelle
- ✅ Images et assets chargés

---

## 📊 **ÉTAPE 7 : Configuration post-déploiement**

### **7.1 Variables d'environnement finales**
```env
APP_NAME="EazyStore"
APP_ENV=production
APP_KEY=base64:votre-clé
APP_DEBUG=false
APP_URL=https://votre-domaine.vercel.app

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
DB_DATABASE=/tmp/database.sqlite

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### **7.2 Migration de la base de données**
Dans Vercel, ajouter cette commande de build :
```bash
php artisan migrate --force
```

---

## 🎯 **ÉTAPE 8 : Test et validation**

### **8.1 Tests à effectuer**
- ✅ Page d'accueil se charge
- ✅ Navigation fonctionne
- ✅ Connexion/inscription
- ✅ Catalogue de produits
- ✅ Panier d'achat
- ✅ Passage de commande
- ✅ Interface admin

### **8.2 Corrections courantes**
```bash
# Si erreur 500, vérifier :
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 🔄 **ÉTAPE 9 : Déploiement automatique**

### **9.1 Configuration Git**
- Chaque push sur `main` déclenche un déploiement
- Vercel détecte automatiquement les changements
- Déploiement en quelques minutes

### **9.2 Branches de développement**
- Créer des branches pour les nouvelles fonctionnalités
- Vercel crée automatiquement des previews
- Test avant merge vers main

---

## 📱 **ÉTAPE 10 : Domaine personnalisé (Optionnel)**

### **10.1 Ajouter un domaine**
- Dans Vercel : Settings → Domains
- Ajouter votre domaine
- Configurer les DNS

### **10.2 SSL automatique**
- Vercel génère automatiquement le certificat SSL
- HTTPS activé par défaut

---

## 🎉 **FÉLICITATIONS !**

Votre application EazyStore est maintenant :
- ✅ **En ligne** et accessible
- ✅ **Gratuite** à héberger
- ✅ **Automatiquement** mise à jour
- ✅ **Sécurisée** avec SSL
- ✅ **Performante** et optimisée

---

## 📞 **Support et aide**

### **En cas de problème :**
1. Vérifier les logs dans Vercel
2. Tester localement d'abord
3. Vérifier les variables d'environnement
4. Consulter la documentation Vercel

### **Liens utiles :**
- **Vercel Docs** : https://vercel.com/docs
- **Laravel Deployment** : https://laravel.com/docs/deployment
- **Support Vercel** : https://vercel.com/support

---

## 🔧 **Commandes utiles**

### **Génération de clé APP_KEY**
```bash
php artisan key:generate
```

### **Optimisation pour la production**
```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **Migration de la base de données**
```bash
php artisan migrate --force
```

### **Seed de la base de données**
```bash
php artisan db:seed --force
```

---

## 📋 **Checklist de déploiement**

### **Avant le déploiement :**
- [ ] Application fonctionne localement
- [ ] Fichier `vercel.json` créé
- [ ] Variables d'environnement préparées
- [ ] Base de données configurée
- [ ] Assets compilés

### **Après le déploiement :**
- [ ] Site accessible
- [ ] Pas d'erreurs 500
- [ ] Base de données fonctionnelle
- [ ] Images et assets chargés
- [ ] Fonctionnalités testées
- [ ] SSL activé

---

## 🚨 **Problèmes courants et solutions**

### **Erreur 500**
```bash
# Solution : Vérifier les variables d'environnement
APP_KEY=base64:votre-clé-générée
APP_DEBUG=false
```

### **Base de données non accessible**
```bash
# Solution : Utiliser SQLite pour le gratuit
DB_CONNECTION=sqlite
DB_DATABASE=/tmp/database.sqlite
```

### **Assets non chargés**
```bash
# Solution : Vérifier le stockage
php artisan storage:link
```

---

**🎯 Votre application EazyStore est maintenant déployée gratuitement !**

*Guide créé pour : Gnawé Parfait & Sokhna Ndack*  
*Date : 1 Août 2024* 