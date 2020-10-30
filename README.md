# Framework-php

## Contenu du répertoire

```
framework-php
├── patch
│   └── ...
├── resources
│   └── ...
├── src
│   ├── controller
│   │   └── ...
│   ├── css
│   │   └── ...
│   ├── exception
│   │   └── ...
│   ├── model
│   │   └── ...
│   ├── service
│   │   ├── bo
│   │   │   └── ...
│   │   └── dao
│   │       └── ...
│   ├── view
│   │   └── ...
│   ├── db.php
│   ├── tools.php
│   └── parameters.php
├── test
│   ├── acceptance
│   │   └── ...
│   ├── controller
│   │   └── ...
│   ├── exception
│   │   └── ...
│   ├── model
│   │   └── ...
│   ├── resources
│   │   └── ...
│   └── service
│       ├── bo
│       │   └── ...
│       └── dao
│           └── ...
├── behat.yml
├── composer.json
├── index.php
├── LICENSE
├── phpunit.xml
├── README.md
├── update_bdd.sh
├── update_gherkin.sh
├── watch.bat
├── .env.demo
├── .env.dev
├── .env.pro
├── .gitignore
└── .php_cs
```

- `patch` : contient les différents patch pour la bdd ;
- `resources` : contient les ressources du projet ;
- `src/controller` : contient tous les contrôleurs ;
- `src/css` : contient les styles du projet ;
- `src/exception` : contient les exceptions du projet ;
- `src/model` : contient les models, objet qui transit entre les contrôleurs, les bos et les daos ;
- `src/service/bo` : contient les bos, bo signifie Business Object, elle traite toute la partie métier, elle peut être appelée par un contrôleur ou un autre bo ;
- `src/service/dao` : contient les daos, traite toute la partie bdd, elle est appelée par un bo ;
- `view` : contient toutes les vues ;
- `test` : contient touts les tests suivant la même arborescence que `src` avec en plus les fichier .feature dans le dossier - `test/resources` et leurs tests dans `test/acceptance`.

## Installation de l'environnement de dev :

### Pré requis :

- composer

Une fois composer installé, lancer `composer install`

### Définir le .env pour la bdd

À la racine du projet, il y a un fichier `.env.dev` qui est un exemple de fichier qui définis les différentes variables nécessaires pour la bdd. \
Copier ce fichier et renommer le en `.env`, modifier les variables pour qu'elle corresponde à votre BDD

### Initialiser la bdd

Se connecter à mysql et lancer le patch pour la création de la database comme suivant :\
`source patch/000_creation_of_database.sql;`

Retourner dans le terminal pour lancer la commande suivante :\
`composer update-bdd reset`

### Script composer

- `composer format` : lance php-cs-fixer à chaque changement de fichier ;
- `composer test` : lance les tests avec php unit ;
- `composer coverage` : lance la couverture des tests dans le terminal ;
- `composer coverage-html` : lance la couverture des tests en html dans le dossier `/test/coverage/` ;
- `composer behat` : lance les tests fonctionnels, `composer behat test/resources/x.feature` pour lancer les tests fonctionnels d'une feature ;
- `composer update-bdd` : met à jour la bdd avec les patchs qui ne sont pas encore passés, besoin de passer le patch 001 avant (et le 000 si vous voulez créer une database par défaut) ;
- `composer update-gherkin` : ajoute les features, créer les fichiers de tests avec les tests vide, créer un fichier `error_gherkin.txt` des features qui ne sont pas valide.

# TODO

- finir les fichiers *.feature
- vérifier/faire les tests Behat
