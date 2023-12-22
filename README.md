Jeudi 21 Décembre 2023

##### Projet Inscription ####
##exercice pour stage chez PerfLinker, GPBL ####

Ce projet consiste en un formulaire d'inscription sur un site quelconque.

Le projet à été réaliser en languauge PHP, sans aucun Framework (From scratch).


------CONFIGURATION-----

*Assurez-vous d'avoir la dernière version de PHP installé sur votre machine.


------INSTALLATION------

*Cloner le projet via github : 

git clone https://github.com/Vander5921/perflinker.git


-----UTILISATION------

*Utilisez wampserver pour lancer le projet sur votre localhost
*Accedez au formulaire via www.localhost/perflinker/

-----AXE D'AMELIORATION-----

* Corriger le soucis avec les chemins relatifs des fichiers
* Augmenter la sécurité pour les inscription multiple en moins de 24h ( utiliser peut-être uniquement l'adresse IP)



-----STRUCTURE DU PROJET-----

*model: Contient les classes liées à la gestion des données et de la base de données: 
   -Database.php
   -InscriptionModel.php
*view: Contient les fichiers de vue HTML.
   -Formulaire.php
*controller: Contient les classes de contrôleur qui gèrent la logique de l'application.
   -InscriptionController.php
*Index.php



-----AUTEUR-----

Baptiste Vanhuyse
