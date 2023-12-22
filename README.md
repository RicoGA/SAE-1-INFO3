# SAE-1-INFO3
Ce dépôt Git héberge le code source de notre SAE

Ce fichier README a pour but d'expliquer comment mettre en place le site sur une machine Linux puis d'expliquer comment utiliser les différents modules de la plateforme.

## Table des Matières
- [Prérequis](#1.-prérequis)
- [Installation de Nginx et de PHP](#1.-prérequis)
- [Instllation des fichiers du site](#)

### 1. Prérequis
- Une machine Linux
- C'est tout

La première étape pour installer la plateforme est de choisir une pile Web, le plus souvent ce sera soit Apache soit Nginx (ou Lighttpd).
Pour ce tutoriel, on utilisera Nginx car nous sommes plus familiarisé avec Nginx, et car les configurations de Nginx sont plus faciles que celles d'Apache.
Le site n'utilise pas de base de données donc il faudra seulement installer Nginx et PHP.

### 2. Instllation de Nginx et PHP
Pour installer Nginx et PHP, utiliser la commande ci-dessous (à noté qu'en fonction de la distribution Linux et de la version utilisée, la commande d'installation peuvent légèrement changer) :

`apt update -y && apt upgrade -y && apt install nginx php-fpm`*

*<sub>Un compte root peut-être nécessaire.</sub>

En fonction de la version de la distribution, la version de Nginx et de Php installée peut différée. Le site est compatible jusqu'à la version 5.1 de PHP et est compatible avec toute les versions de Nginx disponible à ce jour.
La configuration de base de Nginx suffit pour le site.

On peut vérifier que Nginx et PHP fonctionne correctement avec les commandes :
- `systemctl status nginx`
- `systemctl status php-fpm8.2`*

*<sub>Le nom du service de PHP peut changer en fonction des versions, utiliser l'autocomplétion avec tab pour directement écrire le nom du service.</sub>

### 3. Instllation des fichiers du site

Une fois Nginx et PHP installé, il faut télécharger les fichiers source du dépôt git dans le dossier par défaut de travail de nginx qui est `/var/www/html`. Le dossier de travail par défaut de Nginx peut se trouver dans le fichier de configuration qui est accessible via `/etc/nginx/sites-available/default`, à la ligne 36 au paramètre `root` (voir screenshot ci-dessous) :
![gist github com_xameeramir_a5cb675fb6a6a64098365e89a239541d](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/745a6dc7-5539-4068-8bdd-02533aca6067)

Une fois le dossier de travail localisé, il faut cloner ce dépot git, il faut utiliser la commande suivante :
`git clone https://github.com/RicoGA/SAE-1-INFO3.git`*

*<sub>À noter qu'il faut avoir installé git au préalable (`apt install git -y`).</sub>

Une fois le git cloné, Nginx et PHP démarré, on peut se rendre sur `http://localhost/SAE-1-INFO3/`, si tout a correctement fonctionné le site devrait apparaitre :
![image](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/c561c156-ea5d-415f-b63f-f4391cb70d03)

### 4. Tutoriel d'utilisation du site
