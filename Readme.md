## Démonstration 

[![capture page acceuil](index.JPG)](https://www.youtube.com/watch?v=dF8PEdEpPso&feature=youtu.be)


## Technologie utilisé

    Composer : gestionnaire de dépendances dans ce projet.
    Cloud-vision : API ORC , pour récupérer les charactères d'une image.
    HTML , CSS , JS , BOOSTRAP : front-end.
    PHP : back-end.
    FPDF : librairie php pour la génération d'un fichier pdf.
    Curl : bibliothèque permettant de récupérer une page web.
    
    
Télécharger composer [ici ](https://getcomposer.org/ "lien vers composer").

Télécharger FPDF [ici ](http://www.fpdf.org/ "lien vers fpdf") ,  sinon faire
  
    composer require fpdf/fpdf
    
Ajouter curl à son projet :

    composer require curl/curl

Ajouter cloud-vision à son projet :
 
    composer require google/cloud-vision*
    
En alternative à cloud-vision on pourra utiliser l'API TESSERACT.


IMPORTANT : le ficher key.json contient la clée pour utiliser cloud vision.
Cette clée est accessible grâce à une souscription chez google.






