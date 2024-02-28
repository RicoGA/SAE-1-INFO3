<br />
<div align="center">
  <img src="https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/318d178b-74d2-4aef-87b5-fe6844f59ed4" alt="Logo">

  <p align="center">
	  Dépôt git du projet de la SAE 5 permettant d'installer et d'utiliser la plateforme web.
    <br/>
    <br/>
    <a href="https://github.com/othneildrew/Best-README-Template"><strong>Voir une démonstration »</strong></a>
  </p>
</div>

# SAE-1-INFO3

English version available [here](README_en.md)

Ce dépôt Git héberge le code source de notre SAE.

Ce fichier README a pour but d'expliquer comment mettre en place le site sur une machine Linux utilisant <strong>CentOS 7</strong> et que d'expliquer comment utiliser les différents modules de la plateforme.

<details open>
	<summary>Table des matières</summary>
	<ol>
		<li>
			<a href="#à-propos-de-la-sae">À propos de la SAE</a>
			<ul>
				<li><a href="#logiciels-utilisés">Logiciels utilisés</a></li>
			</ul>
		</li>
		<li>
			<a href="#pour-commencer">Pour commencer</a>
			<ul>
				<li><a href="#prérequis">Prérequis</a></li>
				<li><a href="#installation">Installation</a></li>
				<li><a href="#configuration">Configuration</a></li>
				<li><a href="#installation-des-fichiers">Installation des fichiers du site</a></li>
			</ul>
		</li>
		<li>
			<a href="#tutoriel-dutilisation-de-la-plateforme">Tutoriel d'utilisation du site</a>
			<ul>
				<li><a href="#utiliser-le-module-ping">Utiliser le module Ping</a></li>
				<li><a href="#utiliser-le-module-ipv6">Utiliser le module IPv6</a></li>
				<li><a href="#utiliser-le-module-ipv4">Utiliser le module IPv4</a></li>
			</ul>
		</li>
	</ol>
</details>

## À propos de la SAE

Cette SAE a pour but de mettre en place 3 modules :
- Le premier module est un module qui permet d'afficher des pings envoyer sur une adresse IP.
- Le deuxième module permet d'afficher les différentes formes d'une addresse IPV6.
- Le troisième et dernier module simule et calcule les adresses IPV4 d'un réseau local.

### Logiciels utilisés

Les logiciels/applications que nous avons utilisés pour ce projet sont :
- PHP
- Nginx
- HTML
- PicoCSS
  
## Pour commencer

Cette section concerne la partie technique pour installer la plateforme.

### Prérequis

Ce README se concentrera en particulier sur l'installation de la plateforme sur l'OS CentOS 7.
La plateforme peut également fonctionnait sur d'autre distributions Linux à condition d'installer et de paramétrer les applications de la même manière.
Les commandes pour installer les applications, ou bien les chemins d'accès sont succeptibles de changer sur d'autre distribution ou sur d'autre version de CentOS.

### Installation

<strong>Toutes les commandes utilisées dans ce README sont éxécutées via un utilisateur root. Si le compte n'est pas root, vous pouvez utiliser *sudo* avant chaque commande.</strong>

1. La première étape avant l'insllation des applications nécessaire pour le bon fonctionnement de la plateforme est de mettre à jour l'OS :
```bash
yum -y update && yum -y upgrade
```
---

2. Une fois l'OS mis à jour, nous avons besoin d'un serveur web pour que la plateforme web fonctionne, nous avons choisis Nginx car il est plus moderne que Apache et nous sommes plus à l'aise avec. Nous allons donc installer Nginx ainsi que des packets supplémentaires nécessaires au fonctionnement de la plateforme. 
```bash
yum -y install epel-release && yum -y install nginx
```
---

3.  Ensuite, on démarre nginx, on ajoute le service au démarrage de la machine, et l'on vérifie qu'il fonctionne correctement :
```bash
systemctl start nginx && systemctl enable nginx && systemctl status nginx
```

Pour que Nginx démarre, il ne doit pas y avoir d'autre logiciels qui utilise le port 80 (notament Apache).
Le status de Nginx doit afficher 'active (running)' :
![image](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/8178c75b-1fca-45ce-93e2-c0f1ee95c077)

Sinon, cela signifie que Nginx n'a pas pu démarrer.


---
4. Une fois Nginx fonctionnel, nous allons installer PHP. Plus précisement, nous allons installer la version 8 de PHP qui n'est pas disponible par défaut sur CentOS 7. Nous allons donc le télécharger à partir d'un dépôt externe :
```bash
yum -y install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
yum -y install yum-utils && yum-config-manager --enable remi-php80
```
D'abord on télécharge un manager de dépôt, puis on active PHP8.

---
5. Enfin, on installe PHP :
```bash
yum -y install php php-fpm php-gd php-imagick php-json php-opcache php-mcrypt php-curl php-mbstring php-intl php-dom php-zip
```
---

### Configuration
6. On vérifie que Nginx peut se "connecter" à PHP :
```bash
chown -R root:nginx /var/lib/php
```
---

7. On édite les fichiers de configurations de PHP pour pouvoir se connecter à Nginx :
```bash
nano /etc/php-fpm.d/www.conf
```
On doit mettre à jour les variables de PHP comme ci-dessous, certaines lignes sont à décommenter :
```
user = nginx
group = nginx
listen = /var/run/php-fpm/php-fpm.sock
listen.owner = nginx
listen.group = nginx
listen.mode = 0660
```
---

7B. Sur CentOS 7, par défaut, l'OS n'autorise pas les applications à faire des pings, ce problème est due au sécurité du Kernel, il a était mis à jour sur certaines versions plus récentes de CentOS pour ne plus poser de problème. Si le module de Ping ne fonctionne pas pour une adresse IP fronctionnelle (tel que *www.google.com** ou **www.free.fr**, voici comment régler le problème :
```bash
setenforce 0
```
Cette solution permet de désactiver les sécurités liés au kernel pour que PHP puisse s'éxécuter sans problèmes, certaines méthodes différentes permettenet également de laisser PHP s'éxécuter sans désactiver les sécurités, mais ne permettent pas la même liberté d'éxécution du code via le shell.
---

8. Ensuite, on démarre PHP-FPM et on ajoute PHP-FPM au démarrage de CentOS :
```bash
systemctl start php-fpm && systemctl enable php-fpm && systemctl status php-fpm
```
---

9. Enfin, on créer un VirtualHost pour Nginx :
On créer le fichier de configuration Nginx :
```bash
nano /etc/nginx/conf.d/default.conf
```

Les paramètres par défaut des VirtualHost de Nginx :
```
server {
    listen       80;
    server_name  _;

    root   /usr/share/nginx/html;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ =404;
    }
    error_page 404 /404.html;
    error_page 500 502 503 504 /50x.html;

    location = /50x.html {
        root /usr/share/nginx/html;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```
---

10. Pour finir, on vérifie que la configuration n'a pas de problème et on redémarre Nginx pour appliquer les nouveaux paramètres :
```bash
nginx -t && systemctl restart nginx
```

### Installation des fichiers
11. Une fois tout les logiciels installés et configurés, on peut installer les fichiers du site :
```bash
yum -y install git && cd /usr/share/nginx/html && git clone https://github.com/RicoGA/SAE-1-INFO3.git
```

On clone le répertoire git dans le dossier de travail par défaut de Nginx.

---

Une fois le git cloné, Nginx et PHP démarré, on peut se rendre sur [le lien du site](http://localhost/SAE-1-INFO3/), si tout a
correctement fonctionné le site devrait apparaitre :
![image](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/c561c156-ea5d-415f-b63f-f4391cb70d03)

## Tutoriel d'utilisation de la plateforme
Pour apprendre à utiliser la plateforme, vous pouvez suivre ce [tutoriel intéractif](https://ior.ad/9GtO?iframeHash=trysteps-1).

Ou sinon, vous pouvez suivre le tutoriel ci-dessous :

#### Utiliser le module Ping

Pour utiliser le module de Ping, il faut se rendre sur la page d'accueil du site, puis cliquer sur le premier accordéon.
L'interface proposera alors de rentrer une adresse IP ou un nom de domaine, il faut ainsi rentrer l'adresse IP ou le nom
de domaine de la machine à pinger ensuite cliquer sur le bouton "Faire un ping sur l'adresse IP".
Le résultat du ping s'affichera ainsi dans la zone de texte en dessous du bouton "Ping".
Si l'adresse IP ou le nom de domaine est incorrect, un message d'erreur s'affichera.

---
#### Utiliser le module IPv6

Pour utiliser le module IPv6, il faut se rendre sur la page d'accueil du site, puis cliquer sur le deuxième accordéon.
L'interface proposera alors de rentrer une adresse IPv6, il faut ainsi rentrer l'adresse IPv6 à traiter ensuite cliquer
sur le bouton "Traiter l'adresse IP".
Le résultat du traitement s'affichera ainsi dans la zone de texte en dessous du bouton "Traiter l'adresse IP.
L'adresse IPv6 est affichée compressée et étendue, ainsi que sa classe.
Si l'adresse IPv6 est incorrect, un message d'erreur s'affichera.

---
#### Utiliser le module IPv4

Pour utiliser le module IPv4, il faut se rendre sur la page d'accueil du site, puis cliquer sur le troisième accordéon.
L'interface proposera alors de rentrer une adresse IPv4, il faut ainsi rentrer l'adresse IPv4 du réseau principal, le
masque du réseau, ainsi que le nombre de sous-réseaux à créer, pour chaque sous-réseau, il faut rentrer la taille du
sous-réseau.
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
Si l'adresse IPv4 ou le masque du réseau est incorrect, un message d'erreur s'affichera.

---
Une version fonctionnelle du site est disponible [ici](https://ricoco.ovh/SAE-1-INFO3/).
