# NetatmoWeatherAppEedomus
Gestion d'une [station météo Netatmo](https://www.netatmo.com/fr-FR/product/weather/) via la box eedomus

Script créé par [@Thibautg16](https://twitter.com/Thibautg16/)

Dépot GIT : [https://github.com/Thibautg16/NetatmoWeatherAppEedomus/](https://github.com/Thibautg16/NetatmoWeatherAppEedomus/)

Cette application est l'adaptation du script existant avec quelques améliorations (![changelog](https://github.com/Thibautg16/NetatmoWeatherAppEedomus/blob/master/CHANGELOG.md))

## Prérequis 
Vous devez au préalable disposer d'une station météo Netatmo installée et configurée sur l'application Netatmo.

## Commençons
### Ajout du périphérique 
Cliquez sur "Configuration" / "Ajouter ou supprimer un prériphérique" / "Store eedomus" / "Station météo Netatmo" / "Créer"

![creer_peripherique](https://user-images.githubusercontent.com/4451322/37554889-7c1d71e8-29df-11e8-9321-b36d4de12f32.png)

### Configuration du périphérique
![netatmo_config_peripherique](https://user-images.githubusercontent.com/4451322/37554908-a4014f5e-29df-11e8-841b-48a1c63b2dee.png)

#### Code d'autorisation Oauth :
Cliquez sur **Cliquez ici pour obtenir votre code code d'autorisation**. Vous êtes alors redirigés vers le portail Netatmo : 

![netatmo_oauth](https://user-images.githubusercontent.com/4451322/34654159-e85a8ada-f3f7-11e7-9e18-d275b62f1595.png)

Vous êtes ensuite redirigés vers le site **Eedomus** : 

![netatmo_oauth_eedomus](https://user-images.githubusercontent.com/4451322/34655047-7a452fac-f404-11e7-91bc-88db549eb881.png)

Copiez le *code d'autorisation Oauth Netatmo* obtenu sur la page eedomus qui est restée ouverte dans votre navigateur Internet ainsi que l'adresse *MAC de votre station météo*. 

#### Voici les différents champs à renseigner :

**Configuration :**

* [Optionnel] - Nom personnalisé : personnalisation du nom de votre périphérique
* [Obligatoire] - Pièce : vous devez définir dans quelle pièce se trouve votre thermostat
* [Obligatoire] - Code d'autorisation Oauth Netatmo
* [Obligatoire] - Adresse MAC de votre station Netatmo


**Station Météo :**

* [Optionnel] - Station météo - Co2 : choisissez si vous souhaitez créer ce module 
* [Optionnel] - Station Météo - Humidité : choisissez si vous souhaitez créer ce module
* [Optionnel] - Station Météo - Pression : choisissez si vous souhaitez créer ce module
* [Optionnel] - Station Météo - Niveau Sonore : choisissez si vous souhaitez créer ce module
* [Optionnel] - Station Météo - Signal wifi : choisissez si vous souhaitez créer ce module 
* [Optionnel] - Station Méteo - Tendance Température : choisissez si vous souhaitez créer ce module
* [Optionnel] - Station Météo - Tendance Pression : choisissez si vous souhaitez créer ce module


**Module Extérieur :**

* [Optionnel] - Module extérieur - Température : choisissez si vous souhaitez créer ce module
* [Optionnel] - Module extérieur - Tendance Température : choisissez si vous souhaitez créer ce module 
* [Optionnel] - Module extérieur - Humidité : choisissez si vous souhaitez créer ce module
* [Optionnel] - Module extérieur - Signal radio : choisissez si vous souhaitez créer ce module
* [Optionnel] - Module extérieur - Batterie : choisissez si vous souhaitez créer ce module


Plusieurs modules sont créés sur votre box eedomus, ainsi que le script Netatmo. 

![canaux](https://user-images.githubusercontent.com/4451322/36350642-13f9cdbc-149c-11e8-8443-b69420efcf8d.png)


## Mise à jour du script
Si vous possédez déjà le périphérique et que vous souhaitez simplement profiter de la mise à jour du script.
Dans un premier temps vous rendre dans la configuration de votre périphérique et cliquer sur "Vérifier les mises à jour de netatmo_oauth.php":

![eedomus_script_verif](https://user-images.githubusercontent.com/4451322/36350665-62a23cc4-149c-11e8-9469-e998a90ff8d3.png)


Cliquez alors sur "Mettre à jour netatmo_oauth.php avec la dernière version disponible.":

![eedomus_script_maj](https://user-images.githubusercontent.com/4451322/34960084-af7cbb3c-fa39-11e7-8ff1-b31f13cb525d.png)



![release](https://img.shields.io/github/release/Thibautg16/NetatmoWeatherAppEedomus.svg?style=for-the-badge)
![licence](https://img.shields.io/github/license/Thibautg16/NetatmoWeatherAppEedomus.svg?style=for-the-badge)
![status](https://img.shields.io/badge/Status-Prod-green.svg?style=for-the-badge)
![@Thibautg16](https://img.shields.io/badge/twitter-@Thibautg16-blue.svg?style=for-the-badge)