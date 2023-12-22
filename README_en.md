# SAE-1-INFO3

Version française disponible ici : [README.md](README.md)

This Git repository hosts the source code for our SAE.

This README file aims to explain how to set up the site on a Linux machine and then explain how to use the various modules of the platform.

## Table of Contents
- [Prerequisites](#1-prerequisites)
- [Installation of Nginx and PHP](#2-installation-of-nginx-and-php)
- [Installation of Site Files](#3-installation-of-site-files)
- [Site Usage Tutorial](#4-site-usage-tutorial)

## 1. Prerequisites
- A Linux machine
- That's it

The first step to install the platform is to choose a web stack, most often it will be either Apache or Nginx (or Lighttpd). For this tutorial, we will use Nginx because we are more familiar with Nginx, and because Nginx configurations are easier than Apache's. The site does not use a database, so you will only need to install Nginx and PHP.

## 2. Installation of Nginx and PHP
To install Nginx and PHP, use the following command (note that depending on the Linux distribution and version used, the installation command may vary slightly):

```bash
apt update -y && apt upgrade -y && apt install nginx php-fpm
```

<sub>A root account may be required.</sub>

Depending on the distribution version, the installed version of Nginx and PHP may differ. The site is compatible up to PHP version 5.1 and is compatible with all versions of Nginx available to date. The default Nginx configuration is sufficient for the site.

You can check if Nginx and PHP are functioning correctly with the following commands:

```bash
systemctl status nginx
```

```bash
systemctl status php8.2-fpm
```

<sub>The name of the PHP service may change depending on the versions, use tab auto-completion to directly type the service name.</sub>

### 3. Installation of Site Files

Once Nginx and PHP are installed, you need to download the source files of the Git repository into the default working directory of Nginx, which is `/var/www/html`. The default working directory of Nginx can be found in the configuration file accessible via `/etc/nginx/sites-available/default`, at line 36 in the `root` parameter (see screenshot below):
![gist github com_xameeramir_a5cb675fb6a6a64098365e89a239541d](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/745a6dc7-5539-4068-8bdd-02533aca6067)

Once the working directory is located, you need to clone this Git repository using the following command:
```bash
git clone https://github.com/RicoGA/SAE-1-INFO3.git
```

<sub>Note that you need to have Git installed beforehand :</sub>
```bash
apt install git -y
```


After cloning the Git repository, starting Nginx and PHP, you can go to [the server link](http://localhost/SAE-1-INFO3), and if everything has worked correctly, the site should appear:
![image](https://github.com/RicoGA/SAE-1-INFO3/assets/101187637/c561c156-ea5d-415f-b63f-f4391cb70d03)

### 4. Site Usage Tutorial

To learn how to use the platform, use this [interactive tutorial ](https://ior.ad/9GtO?iframeHash=trysteps-1).

Alternatively, you can follow the tutorial below:

#### 4.1 Using the Ping Module

To use the Ping module, go to the site's homepage and click on the first accordion. The interface will prompt you to enter an IP address or domain name. Enter the IP address or domain name of the machine to ping, then click the "Ping IP Address" button. The ping result will be displayed in the text area below the "Ping" button. If the IP address or domain name is incorrect, an error message will be displayed.

#### 4.2 Using the IPv6 Module

To use the IPv6 module, go to the site's homepage and click on the second accordion. The interface will prompt you to enter an IPv6 address. Enter the IPv6 address to process, then click the "Process IP Address" button. The processing result will be displayed in the text area below the "Process IP Address" button. The IPv6 address is displayed in both compressed and expanded forms, along with its class. If the IPv6 address is incorrect, an error message will be displayed.

#### 4.3 Using the IPv4 Module

To use the IPv4 module, go to the site's homepage and click on the third accordion. The interface will prompt you to enter an IPv4 address, the network mask, and the number of subnetworks to create. For each subnetwork, enter the subnetwork size. Once the information is entered, click the "Calculate" button. The calculation result will be displayed in a table below the "Calculate" button. This table contains the following information:
- Subnetwork number
- Desired subnetwork size
- Number of available hosts in the subnetwork
- Subnetwork address
- Subnetwork mask in CIDR format
- Subnetwork mask in decimal format
- IP address range of the subnetwork
- Subnetwork broadcast address
If the IPv4 address or network mask is incorrect, an error message will be displayed.

A working version of the site is available [here](https://ricoco.ovh/SAE-1-INFO3/).
