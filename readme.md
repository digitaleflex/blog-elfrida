# Blog PHP avec Bootstrap

Un blog moderne et élégant développé en PHP avec une interface utilisateur Bootstrap 5, enrichi d'animations et d'effets visuels modernes.

## 🚀 Fonctionnalités

### Système d'Articles
- Interface utilisateur moderne et responsive
- Mise en page élégante avec Tailwindcss
- Extraits d'articles



### Système de Commentaires
- Commentaires 
- Interface utilisateur 



### Design 
- Design responsive et mobile-first
- Animations fluides et transitions
- Thème de couleur personnalisé
- Icônes Font Awesome intégrées

## 🎨 Caractéristiques Techniques

### Frontend
- **Tailwindcss** pour la mise en page
- **Font Awesome** pour les icônes
- **JavaScript** moderne avec Fetch API
- Design responsive

### Backend
- **PHP 7.4+** avec PDO
- Architecture MVC simplifiée
- Gestion sécurisée des requêtes
- Protection contre les injections SQL
- Validation des données


## 📋 Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache recommandé)
- Extension PDO PHP activée
- mod_rewrite Apache activé

## 🛠️ Installation

1. Clonez le dépôt :
```bash
git clone [https://github.com/fri25/blog.git]
```

2. Importez la base de données :
```sql
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS blog;
USE blog;

-- Structure des tables
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
);

CREATE TABLE inscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR NOT NULL,
    prenom VARCHAR NOT NULL,
    username VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    confirm_password VARCHAR NOT NULL,
);

CREATE TABLE commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    comment VARCHAR NOT NULL,
    FOREIGN KEY (id) REFERENCES inscription(id)
);
```


 Configurez votre serveur web :
   - Assurez-vous que mod_rewrite est activé
   - Le fichier .htaccess est configuré pour la gestion des erreurs et les redirections



## 🔒 Sécurité

- Protection contre les injections SQL (PDO)
- Échappement des données HTML (htmlspecialchars)
- Protection des fichiers sensibles (.htaccess)
- Validation des entrées utilisateur
- Headers de sécurité configurés

## 🎯 Fonctionnalités à Venir

- [ ] Système d'authentification
- [ ] Panel d'administration
- [ ] Éditeur WYSIWYG pour les articles
- [ ] Système de tags et catégories
- [ ] Mode sombre
- [ ] API REST
- [ ] Système de newsletter
- [ ] Cache avancé

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le projet
2. Créez une branche pour votre fonctionnalité
3. Committez vos changements
4. Poussez vers la branche
5. Ouvrez une Pull Request

## 📝 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 📧 Support

Pour toute question ou suggestion :
- Ouvrez une issue
- Contactez-nous via le formulaire sur la page À propos
- Email : support@example.com