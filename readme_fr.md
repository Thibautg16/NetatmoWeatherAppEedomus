# NetatmoWeatherAppEedomus
Gestion d'une [station m�t�o Netatmo](https://www.netatmo.com/fr-FR/product/weather/) via la box eedomus

Script cr�� par [@Thibautg16](https://twitter.com/Thibautg16/)

D�pot GIT : [https://github.com/Thibautg16/NetatmoWeatherAppEedomus/](https://github.com/Thibautg16/NetatmoWeatherAppEedomus/)

Cette application est l'adaptation du script existant avec quelques am�liorations (![changelog](https://github.com/Thibautg16/NetatmoWeatherAppEedomus/blob/master/CHANGELOG.md))

## Pr�requis 
Vous devez au pr�alable disposer d'une station m�t�o Netatmo install�e et configur�e sur l'application Netatmo.

## Commen�ons
### Ajout du p�riph�rique 
Cliquez sur "Configuration" / "Ajouter ou supprimer un pr�riph�rique" / "Store eedomus" / "Station m�t�o Netatmo" / "Cr�er"

![creer_peripherique](https://user-images.githubusercontent.com/4451322/37554889-7c1d71e8-29df-11e8-9321-b36d4de12f32.png)

### Configuration du p�riph�rique
![netatmo_config_peripherique](https://user-images.githubusercontent.com/4451322/37554908-a4014f5e-29df-11e8-841b-48a1c63b2dee.png)

#### Code d'autorisation Oauth :
Cliquez sur **Cliquez ici pour obtenir votre code code d'autorisation**. Vous �tes alors redirig�s vers le portail Netatmo : 

![netatmo_oauth](https://user-images.githubusercontent.com/4451322/34654159-e85a8ada-f3f7-11e7-9e18-d275b62f1595.png)

Vous �tes ensuite redirig�s vers le site **Eedomus** : 

![netatmo_oauth_eedomus](https://user-images.githubusercontent.com/4451322/34655047-7a452fac-f404-11e7-91bc-88db549eb881.png)

Copiez le *code d'autorisation Oauth Netatmo* obtenu sur la page eedomus qui est rest�e ouverte dans votre navigateur Internet ainsi que l'adresse *MAC de votre station m�t�o*. 

#### Voici les diff�rents champs � renseigner :

**Configuration :**

* [Optionnel] - Nom personnalis� : personnalisation du nom de votre p�riph�rique
* [Obligatoire] - Pi�ce : vous devez d�finir dans quelle pi�ce se trouve votre thermostat
* [Obligatoire] - Code d'autorisation Oauth Netatmo
* [Obligatoire] - Adresse MAC de votre station Netatmo


**Station M�t�o :**

* [Optionnel] - Station m�t�o - Co2 : choisissez si vous souhaitez cr�er ce module 
* [Optionnel] - Station M�t�o - Humidit� : choisissez si vous souhaitez cr�er ce module
* [Optionnel] - Station M�t�o - Pression : choisissez si vous souhaitez cr�er ce module
* [Optionnel] - Station M�t�o - Niveau Sonore : choisissez si vous souhaitez cr�er ce module
* [Optionnel] - Station M�t�o - Signal wifi : choisissez si vous souhaitez cr�er ce module 
* [Optionnel] - Station M�teo - Tendance Temp�rature : choisissez si vous souhaitez cr�er ce module
* [Optionnel] - Station M�t�o - Tendance Pression : choisissez si vous souhaitez cr�er ce module


**Module Ext�rieur :**

* [Optionnel] - Module ext�rieur - Temp�rature : choisissez si vous souhaitez cr�er ce module
* [Optionnel] - Module ext�rieur - Tendance Temp�rature : choisissez si vous souhaitez cr�er ce module 
* [Optionnel] - Module ext�rieur - Humidit� : choisissez si vous souhaitez cr�er ce module
* [Optionnel] - Module ext�rieur - Signal radio : choisissez si vous souhaitez cr�er ce module
* [Optionnel] - Module ext�rieur - Batterie : choisissez si vous souhaitez cr�er ce module


Plusieurs modules sont cr��s sur votre box eedomus, ainsi que le script Netatmo. 

![canaux](https://user-images.githubusercontent.com/4451322/36350642-13f9cdbc-149c-11e8-8443-b69420efcf8d.png)


## Mise � jour du script
Si vous poss�dez d�j� le p�riph�rique et que vous souhaitez simplement profiter de la mise � jour du script.
Dans un premier temps vous rendre dans la configuration de votre p�riph�rique et cliquer sur "V�rifier les mises � jour de netatmo_oauth.php":

![eedomus_script_verif](https://user-images.githubusercontent.com/4451322/36350665-62a23cc4-149c-11e8-9469-e998a90ff8d3.png)


Cliquez alors sur "Mettre � jour netatmo_oauth.php avec la derni�re version disponible.":

![eedomus_script_maj](https://user-images.githubusercontent.com/4451322/34960084-af7cbb3c-fa39-11e7-8ff1-b31f13cb525d.png)



![release](https://img.shields.io/github/release/Thibautg16/NetatmoWeatherAppEedomus.svg?style=for-the-badge)
![licence](https://img.shields.io/github/license/Thibautg16/NetatmoWeatherAppEedomus.svg?style=for-the-badge)
![status](https://img.shields.io/badge/Status-Prod-green.svg?style=for-the-badge)
![@Thibautg16](https://img.shields.io/badge/twitter-@Thibautg16-blue.svg?style=for-the-badge)