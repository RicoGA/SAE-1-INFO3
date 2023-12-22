# SAE-1-INFO3
Ce dépôt Git héberge le code source de notre SAE

Ce fichier README a pour but d'expliquer comment mettre en place le site sur une machine Linux puis d'expliquer comment utiliser les différents modules de la plateforme.

## Table des Matières
- [Prérequis](#1-prérequis)
- [Installation de Nginx et de PHP](#2-installation-de-nginx-et-php)
- [Installation des fichiers du site](#3-installation-des-fichiers-du-site)
- [Tutoriel d'utilisation du site](#4-tutoriel-dutilisation-du-site)

### 1. Prérequis
- Une machine Linux
- C'est tout

La première étape pour installer la plateforme est de choisir une pile Web, le plus souvent, ce sera soit Apache, soit Nginx (ou Lighttpd).
Pour ce tutoriel, on utilisera Nginx car nous sommes plus familiarisé avec Nginx, et, parce que les configurations de Nginx sont plus faciles que celles d'Apache.
Le site n'utilise pas de base de données donc il faudra seulement installer Nginx et PHP.

### 2. Installation de Nginx et PHP
Pour installer Nginx et PHP, utiliser la commande ci-dessous (à noter qu'en fonction de la distribution Linux et de la version utilisée, la commande d'installation peuvent légèrement changer) :

`apt update -y && apt upgrade -y && apt install nginx php-fpm`*

*<sub>Un compte root peut être nécessaire.</sub>

En fonction de la version de la distribution, la version de Nginx et de Php installée peut différer. Le site est compatible jusqu'à la version 5.1 de PHP et est compatible avec toutes les versions de Nginx disponible à ce jour.
La configuration de base de Nginx suffit pour le site.

On peut vérifier que Nginx et PHP fonctionne correctement avec les commandes :
- `systemctl status nginx`
- `systemctl status php8.2-fpm`*

*<sub>Le nom du service de PHP peut changer en fonction des versions, utiliser l'autocomplétion avec tab pour directement écrire le nom du service.</sub>

### 3. Installation des fichiers du site

Une fois Nginx et PHP installé, il faut télécharger les fichiers source du dépôt git dans le dossier par défaut de travail de nginx qui est `/var/www/html`. Le dossier de travail par défaut de Nginx peut se trouver dans le fichier de configuration qui est accessible via `/etc/nginx/sites-available/default`, à la ligne 36 au paramètre `root` (voir screenshot ci-dessous) :
![gist github com_xameeramir_a5cb675fb6a6a64098365e89a239541d](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/745a6dc7-5539-4068-8bdd-02533aca6067)

Une fois le dossier de travail localisé, il faut cloner ce dépot git, il faut utiliser la commande suivante :
`git clone https://github.com/RicoGA/SAE-1-INFO3.git`*

*<sub>À noter qu'il faut avoir installé git au préalable (`apt install git -y`).</sub>

Une fois le git cloné, Nginx et PHP démarré, on peut se rendre sur `http://localhost/SAE-1-INFO3/`, si tout a correctement fonctionné le site devrait apparaitre :
![image](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/c561c156-ea5d-415f-b63f-f4391cb70d03)

### 4. Tutoriel d'utilisation du site

Pour apprendre à utiliser la plateforme, le lien suivant permet un tutoriel intéractif : https://ior.ad/9GtO?iframeHash=trysteps-1

Ou sinon, vous pouvez suivre le tutoriel ci-dessous :

#### 4.1 Utiliser le module Ping

Pour utiliser le module de Ping, il faut se rendre sur la page d'accueil du site, puis cliquer sur le premier accordéon.
L'interface proposera alors de rentrer une adresse IP ou un nom de domaine, il faut ainsi rentrer l'adresse IP ou le nom de domaine de la machine à pinger ensuite cliquer sur le bouton "Faire un ping sur l'adresse IP".
Le résultat du ping s'affichera ainsi dans la zone de texte en dessous du bouton de validation.
![ricoco ovh_SAE-1-INFO3_ (2)](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/33d20d36-64c6-4070-a2ef-5dbee0b23fec)

Si l'adresse IP ou le nom de domaine est incorrect, un message d'erreur s'affichera.

#### 4.2 Utiliser le module IPv6

Pour utiliser le module IPv6, il faut se rendre sur la page d'accueil du site, puis cliquer sur le deuxième accordéon.
L'interface proposera alors de rentrer une adresse IPv6, il faut ainsi rentrer l'adresse IPv6 à traiter ensuite cliquer sur le bouton "Traiter l'adresse IP".
Le résultat du traitement s'affichera ainsi dans la zone de texte en dessous du bouton "Traiter l'adresse IP.
L'adresse IPv6 est affichée compressée et étendue, ainsi que sa classe.
![ricoco ovh_SAE-1-INFO3_ (1)](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/0b004ff5-dd12-455b-9457-ded04e737b63)
Si l'adresse IPv6 est incorrect, un message d'erreur s'affichera.

#### 4.3 Utiliser le module IPv4

Pour utiliser le module IPv4, il faut se rendre sur la page d'accueil du site, puis cliquer sur le troisième accordéon.
L'interface proposera alors de rentrer une adresse IPv4, il faut ainsi rentrer l'adresse IPv4 du réseau principal, le masque du réseau, ainsi que le nombre de sous-réseaux à créer, pour chaque sous-réseau, il faut rentrer la taille du sous-réseau.

Une fois les informations rentrées, il faut cliquer sur le bouton "Calculer".
Le résultat du calcul s'affichera sous forme de tableau en dessous du bouton "Calculer".
Ce tableau contient les informations suivantes :
- Le numéro du sous-réseau
- La taille désirée du sous-réseau
- Le nombre d'hôtes disponibles dans le sous-réseau
- L'adresse du sous-réseau
- Le masque au format CIDR du sous-réseau
- Le masque au format décimal du sous-réseau
- La plage d'adresses IP du sous-réseau
- L'adresse de broadcast du sous-réseau

![ricoco ovh_SAE-1-INFO3_](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/13c4c9eb-8e97-4508-bb53-823efa2ae951)

Si l'adresse IPv4 ou le masque du réseau est incorrect, un message d'erreur s'affichera.
