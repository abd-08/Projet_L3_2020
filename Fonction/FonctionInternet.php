<?php

use Google\Cloud\Vision\VisionClient;



function blockRechercheR($html){
//fonction qui renvoi un tableau avec les blocks de resultat de recherche google
//entre string
//sortie string
    $regex = "/\sxpd\sO9g5cc\suUPGi\"><div\sclass=\"kCrYT(.*?)url([\s\S]*?)(ZINbbc|mCljob)/i";
    preg_match_all($regex,$html,$tableau,PREG_PATTERN_ORDER);
    return $tableau[0];
}

function recupereLienR($chaine){
//on recupère le lien dans une chaine de caractère
//entre    chaine:string
//sortie string
    $regex = "/url\?q=(((https?|ftp):\/\/(w{3}\.)?)(?<!www)(\w+-?)*\.([a-z]{2,4})(\S*?))\&amp/" ;
    if ( preg_match($regex,$chaine,$trouve) ){
        return $trouve[1];
    }
    else return "";
}


function preContenuAmeliorer($chaine){
// Recupère le contenu texte de chaque block resultat de recherche
//entre    chaine:string
//sortie string
    preg_match_all("/>([^><]{2,}?)</",$chaine ,$tab);
    $contenu = array_concat($tab[1]);
    return $contenu;
}


function entreAvance($chaine){
//on recupère le texte de recherche de la page recherche de google , car on pourrait avoir une modification de la recherche en cours de route
//entrée    chaine :string
//sortie   string

    $regex = "/<title>(.*?)\-\sRecherche\sGoogle<\/title>/" ;
    if ( preg_match($regex,$chaine,$trouve) ){
        return $trouve[1];
    }
    else return "";
}

function recherchePhraseWebAvance($phrase){
//fonction qui recherche une phrase sur internet et retourne l'html de la recherche google
//entre    phrase:string
//sortie    string(html)

    $q = preg_replace("/[.,;:\/\!]/", ' ', $phrase); // on nettoi la ponctuation

    preg_match("/\S.*\S/",$q,$trouve); //on supprime les espaces en debut et fin de phrase
    $q = $trouve[0];

    $q = preg_replace("/\s/","+",$q);//on ajoute les '+' aux endroits nécesssaire

    $lien = "https://www.google.com/search?q=\"".$q."\""; // on  construit le lien de recherche google
    $html = file_get_contents($lien);//a la place d utiliser curl
//
//    $curl = curl_init();
//    curl_setopt($curl, CURLOPT_URL, $lien);
//    curl_setopt($curl, CURLOPT_COOKIESESSION, true);
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//    $html = curl_exec($curl); //on recupere l html de la recherche
//    curl_close($curl);

    return   utf8_decode( $html);
}




function selectBetterlinkAvance($phrase){
    //on va séléctionner le lien qui a un contenu qui match le plus avec la phrase entrée
    //le résultat est sous forme de tableau avec la phrase en t[0], le lien en t[1] et le pourcentage de similarite en t[2]
    //entre     phrase :string
    //sortie    array [phrase:sting , lien:string , similarite:float]

    $html = recherchePhraseWebAvance($phrase);
    $entre = entreAvance($html);
    $tableau_recheche = blockRechercheR($html);
    $resultat = [$phrase ,"lien",0,$phrase];

    $tableau_split = preg_split("/\s+/",$phrase);
    $tableau_mot = recupere_mot_tableau($tableau_split);

    if(count($tableau_recheche)==1){ // si on a un seul resultat dans la recherche c est notre résultat
        $lien = recupereLienR($tableau_recheche[0]);
        $resultat=[$phrase, $lien , 100];
        $resultat[3]="<mark>".$phrase."</mark>";
        return $resultat;
    }

    for ($i=0; $i<count($tableau_recheche); $i++){
        $contenu = preContenuAmeliorer($tableau_recheche[$i]);
        $similarite = compareMot( $entre , $contenu );
        if ( $similarite[0]*100 > $resultat[2] ){
            $lien = recupereLienR($tableau_recheche[$i]);
            $resultat=[$phrase, $lien , number_format($similarite[0]*100 , 2),$similarite[1]];
        }
    }


    if($resultat[2]<95) $resultat[3]= transfere_surligne($tableau_split,$tableau_mot,$resultat[3]);
    return $resultat;
}


function rechercheTexteWeb($texte){
//on va recuperer un tableau contenant le pourcentage de similarite d'une phrase
    //entre      texte:string
    //sortie   array<>

    //on rajoute une ponctuation a la fin du texte si elle est inexistante
    $der=$texte[strlen($texte)-1];
    if(!array_search($der , ['!','.','?',':'])) $texte=$texte.'.';

    //on decoupe le texte en phrase
    preg_match_all("/[^\.\?\!\:]*?[\.\?\!\:]/",$texte ,$tab);
    $tableau = $tab[0];

    //on construit un tableau a double dimension avec le lien qui se rapproche le plus a la phrase recherché ainsi que sa similarité
    $resultat=[];
    for ($i=0; $i<count($tableau); $i++){
        if (strlen($tableau[$i]) >10 ) array_push($resultat, selectBetterlinkAvance($tableau[$i]));
    }
    return $resultat;
}



function CVTexte($file_name){
//utilisation de l'api CLOUD-VISION de google
//fonction qui prend recupere le texte d'une image
//entrée : un path
//en sortie : un string(le texte de l'image)

    $vision = new VisionClient(['keyFile' => json_decode(file_get_contents("key.json"),true)]);
    $ressource = fopen("images/".$file_name,'r');
    $image = $vision->image($ressource,['TEXT_DETECTION']);
    $result = $vision->annotate($image);
    $text = $result->text();
    $contenu_img = $text[0]->info()['description'];
    return $contenu_img;
}
