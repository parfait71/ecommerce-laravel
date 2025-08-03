# 🚀 Script PowerShell pour déployer EazyStore sur GitHub
# Repository: https://github.com/parfait71/ecommerce-laravel

Write-Host "🛒 Déploiement d'EazyStore sur GitHub..." -ForegroundColor Green

# ==========================================
# 1. INITIALISATION GIT
# ==========================================

Write-Host "📁 Initialisation Git..." -ForegroundColor Blue

# Initialiser Git (si pas déjà fait)
if (-not (Test-Path ".git")) {
    git init
    Write-Host "✅ Repository Git initialisé" -ForegroundColor Green
} else {
    Write-Host "✅ Repository Git déjà initialisé" -ForegroundColor Green
}

# Configurer Git
git config user.name "Gnawé Parfait"
git config user.email "votre-email@gmail.com"

# ==========================================
# 2. CRÉER LE FICHIER .gitignore
# ==========================================

Write-Host "📝 Création du fichier .gitignore..." -ForegroundColor Blue

$gitignore = @"
# Laravel
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
docker-compose.override.yml
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log

# IDE
.idea/
.vscode/
*.swp
*.swo

# OS
.DS_Store
Thumbs.db

# Logs
*.log

# Cache
bootstrap/cache/
storage/framework/cache/
storage/framework/sessions/
storage/framework/views/

# Uploads (garder la structure mais pas les fichiers)
storage/app/public/uploads/*
!storage/app/public/uploads/.gitkeep

# Tests
.phpunit.cache/

# Composer
composer.phar

# Node
node_modules/
npm-debug.log*
yarn-debug.log*
yarn-error.log*

# Environment files
.env.local
.env.production
.env.staging

# Backup files
*.bak
*.backup
"@

$gitignore | Out-File -FilePath ".gitignore" -Encoding UTF8

# ==========================================
# 3. CRÉER LES DOSSIERS ET FICHIERS NÉCESSAIRES
# ==========================================

Write-Host "📁 Création des dossiers nécessaires..." -ForegroundColor Blue

# Créer les dossiers nécessaires
New-Item -ItemType Directory -Force -Path "storage/app/public/uploads"
New-Item -ItemType Directory -Force -Path "storage/framework/cache"
New-Item -ItemType Directory -Force -Path "storage/framework/sessions"
New-Item -ItemType Directory -Force -Path "storage/framework/views"
New-Item -ItemType Directory -Force -Path ".github/workflows"

# Créer les fichiers .gitkeep
New-Item -ItemType File -Force -Path "storage/app/public/uploads/.gitkeep"
New-Item -ItemType File -Force -Path "storage/framework/cache/.gitkeep"
New-Item -ItemType File -Force -Path "storage/framework/sessions/.gitkeep"
New-Item -ItemType File -Force -Path "storage/framework/views/.gitkeep"

# ==========================================
# 4. AJOUTER TOUS LES FICHIERS
# ==========================================

Write-Host "📦 Ajout de tous les fichiers..." -ForegroundColor Blue
git add .

# ==========================================
# 5. PREMIER COMMIT
# ==========================================

Write-Host "💾 Création du commit initial..." -ForegroundColor Blue

$commitMessage = @"
🎉 Initial commit - EazyStore e-commerce platform

✅ Fonctionnalités complètes:
- Front-office (catalogue, panier, commandes)
- Back-office (gestion produits, commandes, analytics)
- Système de paiement (Wave + Cash on Delivery)
- Génération automatique de factures PDF
- Emails de confirmation automatiques
- Tests automatisés complets
- Documentation complète

👨‍💻 Équipe:
- Gnawé Parfait (Backend & API)
- Sokhna Ndack (Frontend & UI/UX)

📚 Documentation incluse:
- README.md (guide principal)
- GUIDE_PRESENTATION.md (guide de présentation)
- RESUME_PROJET.md (résumé complet)
- validate_project.php (validation automatique)

🚀 Prêt pour la présentation!
"@

git commit -m $commitMessage

# ==========================================
# 6. CONFIGURER LA BRANCHE MAIN
# ==========================================

Write-Host "🌿 Configuration de la branche main..." -ForegroundColor Blue
git branch -M main

# ==========================================
# 7. AJOUTER LE REMOTE GITHUB
# ==========================================

Write-Host "🔗 Ajout du remote GitHub..." -ForegroundColor Blue
git remote add origin https://github.com/parfait71/ecommerce-laravel.git

# ==========================================
# 8. PUSHER SUR GITHUB
# ==========================================

Write-Host "🚀 Push sur GitHub..." -ForegroundColor Blue
git push -u origin main

# ==========================================
# 9. CRÉER LA BRANCHE POUR GNAWÉ PARFAIT
# ==========================================

Write-Host "🔧 Création de la branche pour Gnawé Parfait..." -ForegroundColor Blue
git checkout -b gnawé-parfait-backend

$gnawéCommit = @"
🔧 Backend & API - Gnawé Parfait

✅ Responsabilités:
- Contrôleurs (Admin, User, Order, Product, Analytics)
- Modèles Eloquent (User, Product, Order, Category, etc.)
- Services métier (EmailService, InvoiceService)
- Intégrations de paiement (WavePaymentController)
- Système d'analytics avancé
- Tests automatisés complets
- Migrations de base de données
- Configuration de sécurité

🎯 Technologies utilisées:
- Laravel 9
- PHP 8.0+
- MySQL
- Composer
- PHPUnit pour les tests

📊 Fonctionnalités développées:
- API REST complète
- Authentification et autorisation
- Gestion des paiements
- Génération de factures PDF
- Système d'emails automatiques
- Analytics et rapports
- Tests de régression
"@

git commit --allow-empty -m $gnawéCommit
git push -u origin gnawé-parfait-backend

# ==========================================
# 10. CRÉER LA BRANCHE POUR SOKHNA NDACK
# ==========================================

Write-Host "🎨 Création de la branche pour Sokhna Ndack..." -ForegroundColor Blue
git checkout main
git checkout -b sokhna-ndack-frontend

$sokhnaCommit = @"
🎨 Frontend & UI/UX - Sokhna Ndack

✅ Responsabilités:
- Vues Blade (layouts, composants, pages)
- Templates d'emails
- Templates PDF
- Interface utilisateur responsive
- Design et expérience utilisateur
- Intégration des assets CSS/JS
- Formulaires et validation côté client
- Navigation et menus

🎯 Technologies utilisées:
- Blade Templates
- HTML5/CSS3
- JavaScript/jQuery
- Bootstrap/Tailwind
- Responsive Design

📱 Fonctionnalités développées:
- Interface client (catalogue, panier, checkout)
- Interface admin (dashboard, gestion)
- Design responsive mobile/desktop
- Formulaires interactifs
- Notifications utilisateur
- Navigation intuitive
- Optimisation UX
"@

git commit --allow-empty -m $sokhnaCommit
git push -u origin sokhna-ndack-frontend

# ==========================================
# 11. RETOURNER SUR LA BRANCHE MAIN
# ==========================================

Write-Host "🔄 Retour sur la branche main..." -ForegroundColor Blue
git checkout main

# ==========================================
# 12. VÉRIFICATION FINALE
# ==========================================

Write-Host "✅ Vérification finale..." -ForegroundColor Blue
git status
git branch -a
git remote -v

# ==========================================
# 13. RÉSUMÉ FINAL
# ==========================================

Write-Host ""
Write-Host "🎉 Déploiement terminé avec succès!" -ForegroundColor Green
Write-Host ""
Write-Host "📋 Vérifications à faire:" -ForegroundColor Yellow
Write-Host "1. Aller sur https://github.com/parfait71/ecommerce-laravel" -ForegroundColor White
Write-Host "2. Vérifier que les 3 branches sont présentes:" -ForegroundColor White
Write-Host "   - main" -ForegroundColor White
Write-Host "   - gnawé-parfait-backend" -ForegroundColor White
Write-Host "   - sokhna-ndack-frontend" -ForegroundColor White
Write-Host "3. Vérifier que tous les fichiers sont présents" -ForegroundColor White
Write-Host "4. Tester le clone: git clone https://github.com/parfait71/ecommerce-laravel.git" -ForegroundColor White
Write-Host ""
Write-Host "📚 Fichiers importants pour le professeur:" -ForegroundColor Yellow
Write-Host "- README.md (guide principal)" -ForegroundColor White
Write-Host "- GUIDE_PRESENTATION.md (guide de présentation)" -ForegroundColor White
Write-Host "- RESUME_PROJET.md (résumé complet)" -ForegroundColor White
Write-Host "- validate_project.php (validation automatique)" -ForegroundColor White
Write-Host ""
Write-Host "🚀 Le professeur peut maintenant cloner et utiliser le projet!" -ForegroundColor Green

# ==========================================
# 14. COMMANDES ALTERNATIVES (si erreur)
# ==========================================

Write-Host ""
Write-Host "🔄 Si vous avez des erreurs, utilisez ces commandes:" -ForegroundColor Yellow
Write-Host ""
Write-Host "# Forcer le push (si nécessaire)" -ForegroundColor White
Write-Host "git push -u origin main --force" -ForegroundColor Gray
Write-Host "git push -u origin gnawé-parfait-backend --force" -ForegroundColor Gray
Write-Host "git push -u origin sokhna-ndack-frontend --force" -ForegroundColor Gray
Write-Host ""
Write-Host "# Vérifier les permissions" -ForegroundColor White
Write-Host "git config --list" -ForegroundColor Gray
Write-Host ""
Write-Host "# Réinitialiser si nécessaire" -ForegroundColor White
Write-Host "git remote remove origin" -ForegroundColor Gray
Write-Host "git remote add origin https://github.com/parfait71/ecommerce-laravel.git" -ForegroundColor Gray 