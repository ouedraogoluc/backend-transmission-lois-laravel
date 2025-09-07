<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
-- Création de la base de données
CREATE DATABASE gestion_lois;
\c gestion_lois; -- Se connecter à la base après création (PostgreSQL)

-- Table des sessions législatives
CREATE TABLE sessions (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    nom VARCHAR(255) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL
);

-- Table des lois
CREATE TABLE lois (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    statut VARCHAR(50) CHECK (statut IN ('en_creation', 'transmis', 'cloture')),
    session_id UUID NOT NULL,
    date_creation TIMESTAMP DEFAULT NOW(),
    FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE
);

-- Table des documents liés aux lois (Fichiers PDF, Word, etc.)
CREATE TABLE documents (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    nom_fichier VARCHAR(255) NOT NULL,
    chemin_fichier TEXT NOT NULL,
    type_fichier VARCHAR(50) CHECK (type_fichier IN ('pdf', 'docx', 'txt', 'autre')),
    taille INTEGER,
    loi_id UUID NOT NULL,
    FOREIGN KEY (loi_id) REFERENCES lois(id) ON DELETE CASCADE
);

-- Table des utilisateurs (Employés)
CREATE TABLE utilisateurs (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe TEXT NOT NULL,
    role VARCHAR(50) CHECK (role IN ('redacteur', 'sg_mjdhri', 'dgri_mjdhri', 'drip_mjdhri', 'ministre', 'premier_ministre', 'commissaire_gouvernement', 'alt', 'admin')),
    date_inscription TIMESTAMP DEFAULT NOW()
);

-- Table de transmission des lois entre les utilisateurs
CREATE TABLE transmissions (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    loi_id UUID NOT NULL,
    expediteur_id UUID NOT NULL,
    destinataire_id UUID NOT NULL,
    date_transmission TIMESTAMP DEFAULT NOW(),
    statut VARCHAR(50) CHECK (statut IN ('envoyé', 'reçu')),
    FOREIGN KEY (loi_id) REFERENCES lois(id) ON DELETE CASCADE,
    FOREIGN KEY (expediteur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (destinataire_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

-- Table des rôles (si besoin d’une gestion des permissions avancées)
CREATE TABLE roles (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    nom VARCHAR(255) UNIQUE NOT NULL
);

-- Table des permissions (pour définir ce que chaque rôle peut faire)
CREATE TABLE permissions (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    nom VARCHAR(255) UNIQUE NOT NULL
);

-- Table pivot pour assigner des rôles aux utilisateurs
CREATE TABLE utilisateur_roles (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    utilisateur_id UUID NOT NULL,
    role_id UUID NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- Table pivot pour assigner des permissions aux rôles
CREATE TABLE role_permissions (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    role_id UUID NOT NULL,
    permission_id UUID NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

-- Ajout de la table des rapports liés aux transmissions
CREATE TABLE rapports (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    contenu TEXT NOT NULL, -- Texte du rapport
    date_creation TIMESTAMP DEFAULT NOW(),
    loi_id UUID NOT NULL,
    auteur_id UUID NOT NULL, -- Utilisateur qui a écrit le rapport
    transmission_id UUID NOT NULL, -- Transmission associée
    FOREIGN KEY (loi_id) REFERENCES lois(id) ON DELETE CASCADE,
    FOREIGN KEY (auteur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (transmission_id) REFERENCES transmissions(id) ON DELETE CASCADE
);

-- Ajout de la table des documents liés aux rapports
CREATE TABLE documents_rapports (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    nom_fichier VARCHAR(255) NOT NULL,
    chemin_fichier TEXT NOT NULL,
    type_fichier VARCHAR(50) CHECK (type_fichier IN ('pdf', 'docx', 'txt', 'autre')),
    taille INTEGER,
    rapport_id UUID NOT NULL,
    FOREIGN KEY (rapport_id) REFERENCES rapports(id) ON DELETE CASCADE


-- Création de la table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('ministre_porteur', 'sg_mjdhri', 'structure_interne', 'alt', 'commissaire_gouvernement', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Création de la table des lois
CREATE TABLE lois (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    session_legislative VARCHAR(100) NOT NULL,
    status ENUM('creation', 'transmission_sg', 'transmission_structures', 'transmission_alt_commissaire', 'cloture') NOT NULL DEFAULT 'creation',
    created_by INT NOT NULL, -- ID du Ministre Porteur
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Création de la table des transmissions
CREATE TABLE transmissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    loi_id INT NOT NULL,
    from_user_id INT NOT NULL, -- Expéditeur
    to_user_id INT NOT NULL, -- Destinataire
    status ENUM('en_attente', 'traitee', 'retournee') NOT NULL DEFAULT 'en_attente',
    transmission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loi_id) REFERENCES lois(id) ON DELETE CASCADE,
    FOREIGN KEY (from_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (to_user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Création de la table des rapports
CREATE TABLE rapports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transmission_id INT NOT NULL,
    rapport_text TEXT,
    document_url VARCHAR(255), -- URL du document joint
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (transmission_id) REFERENCES transmissions(id) ON DELETE CASCADE
);

-- Création de la table des affectations
CREATE TABLE affectations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    loi_id INT NOT NULL,
    structure_interne_id INT NOT NULL, -- ID de la structure interne
    assigned_by INT NOT NULL, -- ID du SG du MJDHRI
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loi_id) REFERENCES lois(id) ON DELETE CASCADE,
    FOREIGN KEY (structure_interne_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Création de la table de l'historique des actions
CREATE TABLE historique_actions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    loi_id INT NOT NULL,
    user_id INT NOT NULL, -- Utilisateur ayant effectué l'action
    action_type ENUM('creation', 'transmission', 'affectation', 'rapport', 'cloture') NOT NULL,
    action_details TEXT,
    action_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loi_id) REFERENCES lois(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Création de la table des archives
CREATE TABLE archives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    loi_id INT NOT NULL,
    archived_by INT NOT NULL, -- Utilisateur ayant archivé la loi
    archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loi_id) REFERENCES lois(id) ON DELETE CASCADE,
    FOREIGN KEY (archived_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Index pour optimiser les performances
CREATE INDEX idx_lois_titre ON lois(titre);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_transmissions_loi_id ON transmissions(loi_id);
CREATE INDEX idx_rapports_transmission_id ON rapports(transmission_id);
CREATE INDEX idx_affectations_loi_id ON affectations(loi_id);
CREATE INDEX idx_historique_actions_loi_id ON historique_actions(loi_id);
CREATE INDEX idx_archives_loi_id ON archives(loi_id);



-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des rôles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des permissions
CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table de liaison entre rôles et permissions
CREATE TABLE role_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

-- Table de liaison entre utilisateurs et rôles
CREATE TABLE user_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);