# 🎓 EduManager - Système de Gestion des Étudiants

Application web complète de gestion des profils étudiants développée avec Laravel 11 et Firebase Authentication.

## 📋 Table des Matières

- [Aperçu](#aperçu)
- [Fonctionnalités](#fonctionnalités)
- [Technologies Utilisées](#technologies-utilisées)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration Firebase](#configuration-firebase)
- [Utilisation](#utilisation)
- [Architecture](#architecture)
- [Captures d'écran](#captures-décran)
- [Auteur](#auteur)

## 🎯 Aperçu

EduManager est une application CRUD (Create, Read, Update, Delete) moderne permettant la gestion complète des profils étudiants. Le projet implémente une architecture hybride combinant MySQL pour le stockage des données et Firebase Authentication pour la sécurité et la gestion des identifiants.

### Points Forts
- ✅ Authentification sécurisée via Firebase
- ✅ Interface utilisateur moderne et responsive
- ✅ Gestion complète des profils étudiants (CRUD)
- ✅ Upload et gestion de photos de profil
- ✅ Système de rôles (Admin/Étudiant)
- ✅ Réinitialisation de mot de passe via Firebase
- ✅ Migration automatique des anciens comptes

## ⚡ Fonctionnalités

### Pour les Administrateurs
- 📊 Tableau de bord avec statistiques
- 👥 Liste complète des étudiants avec recherche en temps réel
- ➕ Ajout de nouveaux étudiants
- ✏️ Modification des profils existants
- 🗑️ Suppression sécurisée avec confirmation
- 📸 Gestion des photos de profil

### Pour les Étudiants
- 👤 Inscription autonome
- 🔐 Connexion sécurisée
- 📋 Consultation de leur propre profil
- 🔑 Réinitialisation de mot de passe

## 🛠️ Technologies Utilisées

### Backend
- **PHP** 8.2+
- **Laravel** 11
- **MySQL** (via XAMPP)
- **Firebase Admin SDK** pour l'authentification

### Frontend
- **Blade** (moteur de templates Laravel)
- **CSS3** avec variables CSS personnalisées
- **JavaScript** vanilla

### Outils
- **Composer** - Gestionnaire de dépendances PHP
- **Artisan CLI** - Interface en ligne de commande Laravel

## 📦 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- PHP >= 8.2
- Composer
- MySQL
- XAMPP (ou équivalent)
- Un compte Firebase (gratuit)

## 🚀 Installation

### 1. Cloner le Projet

```bash
git clone https://github.com/dev8Zakaria/crud-etudiant-laravel-firebase.git
cd crud-etudiant-laravel-firebase
```

### 2. Installer les Dépendances

```bash
composer install
```

### 3. Configuration de l'Environnement

Copiez le fichier d'exemple et configurez vos variables :

```bash
cp .env.example .env
```

Modifiez le fichier `.env` avec vos paramètres :

```env
APP_NAME="EduManager"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_etudiant
DB_USERNAME=root
DB_PASSWORD=

FIREBASE_CREDENTIALS=storage/app/firebase_credentials.json
```

### 4. Générer la Clé d'Application

```bash
php artisan key:generate
```

### 5. Créer la Base de Données

Dans phpMyAdmin ou via MySQL CLI :

```sql
CREATE DATABASE crud_etudiant CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Exécuter les Migrations et Seeders

```bash
php artisan migrate:fresh --seed
```

Cela créera :
- Les tables nécessaires
- Un compte administrateur par défaut :
  - Email : `zakaria.ask07@gmail.com`
  - Mot de passe : `admin123`

### 7. Créer le Lien Symbolique pour le Stockage

```bash
php artisan storage:link
```

## 🔥 Configuration Firebase

### 1. Créer un Projet Firebase

1. Allez sur [Firebase Console](https://console.firebase.google.com/)
2. Cliquez sur "Ajouter un projet"
3. Nommez votre projet (ex: "EduManager")
4. Suivez les étapes de création

### 2. Activer l'Authentification

1. Dans le menu latéral : **Build** → **Authentication**
2. Cliquez sur **Get Started**
3. Onglet **Sign-in method**
4. Activez **Email/Password**

### 3. Générer la Clé Privée

1. Cliquez sur l'icône **⚙️ Paramètres** → **Paramètres du projet**
2. Onglet **Comptes de service**
3. Section **Firebase Admin SDK**
4. Cliquez sur **Générer une nouvelle clé privée**
5. Un fichier JSON sera téléchargé

### 4. Configurer Laravel

1. Renommez le fichier téléchargé en `firebase_credentials.json`
2. Placez-le dans `storage/app/`
3. Vérifiez que le chemin dans `.env` est correct :
   ```env
   FIREBASE_CREDENTIALS=storage/app/firebase_credentials.json
   ```

### 5. Publier la Configuration

```bash
php artisan vendor:publish --provider="Kreait\Laravel\Firebase\ServiceProvider" --tag=config
```

## 🎮 Utilisation

### Démarrer le Serveur

```bash
php artisan serve
```

L'application sera accessible sur : `http://127.0.0.1:8000`

### Connexion Administrateur

- **Email** : `zakaria.ask07@gmail.com`
- **Mot de passe** : `admin123`

### Inscription Étudiant

1. Cliquez sur "Créer un compte" depuis la page de connexion
2. Remplissez le formulaire avec :
   - Nom d'utilisateur
   - Email
   - Mot de passe
   - Numéro d'Apogée (unique)
   - Nom et Prénom
   - Téléphone
   - Photo (optionnel)

### Réinitialisation de Mot de Passe

1. Cliquez sur "Mot de passe oublié ?" depuis la page de connexion
2. Entrez votre email
3. Un lien de réinitialisation sera généré (Mode Démo : affiché directement)
4. Cliquez sur le lien pour définir un nouveau mot de passe via Firebase

## 🏗️ Architecture

### Modèle de Données

```
┌─────────────┐         ┌──────────────┐
│    users    │ 1     1 │  etudiants   │
├─────────────┤─────────├──────────────┤
│ id          │         │ id           │
│ name        │         │ numero_apogee│
│ email       │         │ nom          │
│ password    │         │ prenom       │
│ role        │         │ email        │
│ timestamps  │         │ telephone    │
└─────────────┘         │ photo        │
                        │ user_id (FK) │
                        │ timestamps   │
                        └──────────────┘
```

### Flux d'Authentification

```
Inscription
├─> Création compte Firebase (email/password)
└─> Création profil MySQL (données étudiant)

Connexion
├─> Validation Firebase (signInWithEmailAndPassword)
├─> Vérification compte local MySQL
└─> Session Laravel

Réinitialisation
├─> Vérification email en MySQL
├─> Synchronisation Firebase si nécessaire
├─> Génération lien sécurisé (getPasswordResetLink)
└─> Affichage lien (Mode Démo)
```

### Structure des Dossiers Clés

```
crud_etudiant/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Auth hybride Firebase+MySQL
│   │   │   ├── FirebaseAuthController.php  # Réinitialisation mot de passe
│   │   │   ├── EtudiantController.php      # CRUD étudiants
│   │   │   └── DashboardController.php     # Tableau de bord
│   │   └── Middleware/
│   │       └── AdminMiddleware.php         # Protection routes admin
│   └── Models/
│       ├── User.php                        # Modèle utilisateur
│       └── Etudiant.php                    # Modèle étudiant
├── resources/
│   └── views/
│       ├── auth/                           # Vues authentification
│       ├── etudiants/                      # Vues CRUD étudiants
│       └── layouts/
│           └── app.blade.php               # Layout principal
├── database/
│   ├── migrations/                         # Schémas de tables
│   └── seeders/
│       └── AdminSeeder.php                 # Création admin par défaut
└── routes/
    └── web.php                             # Définition des routes
```

## 📸 Captures d'écran

### Page de Connexion
Interface moderne avec design épuré et lien "Mot de passe oublié".

### Tableau de Bord Admin
Statistiques en temps réel et actions rapides.

### Liste des Étudiants
Tableau avec recherche dynamique et pagination.

### Profil Étudiant
Affichage détaillé avec photo et informations académiques.

## 🔒 Sécurité

- ✅ Mots de passe hashés (bcrypt)
- ✅ Protection CSRF sur tous les formulaires
- ✅ Validation des données côté serveur
- ✅ Middleware de protection des routes
- ✅ Authentification déléguée à Firebase
- ✅ Gestion sécurisée des fichiers uploadés

## 🐛 Dépannage

### Erreur "ext-sodium is missing"

Activez l'extension dans `php.ini` :
```ini
extension=sodium
```

### Erreur de migration "Table already exists"

Réinitialisez la base :
```bash
php artisan migrate:fresh --seed
```

### Erreur Firebase "Credentials not found"

Vérifiez que :
1. Le fichier JSON est bien dans `storage/app/`
2. Le chemin dans `.env` est correct
3. Vous avez exécuté `php artisan config:clear`



