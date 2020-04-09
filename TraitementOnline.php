<?php


function blockRechercheR($html){
    //fonction qui renvoi un tableau avec les blocks de resultat de recherche google
    $regex = "/url\?q(.*?)(\.\.\.\s)?(.*?)href/i";
    preg_match_all($regex,$html,$tableau,PREG_PATTERN_ORDER);
    return $tableau[0];
}



function recupereLienR($chaine){
    //on recupère le lien dans une chaine de caractère
     $regex = "/url\?q=(((https?|ftp):\/\/(w{3}\.)?)(?<!www)(\w+-?)*\.([a-z]{2,4})(\S*?))\&amp/" ;
     if ( preg_match($regex,$chaine,$trouve) ){
        return $trouve[1];
     }
     else return "";
}



function preContenuR($chaine){
    // Recupère le contenu de chaque block resultat de recherche
    $regex = "/>([^<>]{100,})</" ;
    if ( preg_match($regex,$chaine,$trouve) ){
            return $trouve[1];
         }
   else return "";
}


function entreR($chaine){
    //on recupère le texte de recherche de la page recherche de google
       $regex = "/class=\"noHIxc\"\svalue=\"(.*?)\"/i" ;
        if ( preg_match($regex,$chaine,$trouve) ){
                return $trouve[1];
             }
       else return "";
}


function recherchePhraseWebR($phrase){
//fonction qui recherche une phrase sur internet et retourne l'html de la recherche google

    $q = preg_replace("/[.,;:\/\?\!]/", ' ', $phrase); // on nettoi la ponctuation

    preg_match("/\S.*\S/",$q,$trouve); //on supprime les espaces en debut et fin de phrase
    $q = $trouve[0];

    $q = preg_replace("/\s/","+",$q);//on ajoute les '+' aux endroits nécesssaire

    $lien = "https://www.google.com/search?q=".$q; // on  construit le lien de recherche google
/*
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $lien);
    curl_setopt($curl, CURLOPT_COOKIESESSION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($curl); //on recupere l html de la recherche
    curl_close($curl);
*/
    $html = file_get_contents($lien);//a la place d utiliser curl
    return $html;
}

function selectBetterlink($phrase){
    //on va séléctionner le lien qui a un contenu qui match le plus avec la phrase entrée
    //le résultat est sous forme de tableau avec le lien en t[0] et le pourcentage de similarite en t[1]
    $html = recherchePhraseWebR($phrase);
    $entre = entreR($html);
    $tableau_recheche = blockRechercheR($html);
    $resultat = ["lien",0];

     for ($i=0; $i<count($tableau_recheche); $i++){
        $contenu = preContenuR($tableau_recheche[$i]);
        $similarite = compareMot( $entre , $contenu );

        if ( $similarite > $resultat[1] ){
            $resultat=[recupereLienR($tableau_recheche[$i]) , $similarite];
        }
     }
     return $resultat;
}




function compareMot($s1,$s2){
    //on compare 2 chaines de caractère et on renvoi le pourcentage de similarite
    $s1clean = preg_split("/\s?[\.\?\!\:\s]\s?/",$s1);
    $s2clean = preg_split("/\s?[\.\?\!\:\s]\s?/",$s2);
    $s1count = count($s1clean);
    $s2count = count($s2clean);
    $result = array_intersect($s1clean, $s2clean);
    if ($s1count==0 | $s2count==0) return 0;
    return count($result)/min($s1count,$s2count);
}

function rechercheTexteWeb($texte){
//on va recuperer un tableau contenant le pourcentage de similarite d'une phrase

    //on rajoute une ponctuation a la fin du texte si elle est inexistante
    $der=$texte[strlen($texte)-1];
    if(!array_search($der , ['!','.','?',':'])) $texte=$texte.'.';

    //on decoupe le texte en phrase
     preg_match_all("/[^\.\?\!\:]*?[\.\?\!\:]/",$texte ,$tab);
     $tableau = $tab[0];

    affichetab($tableau);

    //on construit un tableau a double dimension avec le lien qui se rapproche le plus a la phrase recherché ainsi que sa similarité
    $resultat=[];
     for ($i=0; $i<count($tableau); $i++){
        array_push($resultat, selectBetterlink($tableau[$i]));
     }

     var_dump($resultat);
      return interpretationResultat($resultat ,$tableau);
}



function interpretationResultat($tableau_resultat ,$tableau_phrase){
    $resultat=[];
    $bloc=""; //contiendra les phrase qui viennent du meme site
    $cmp=0; // compteur pour le nombre de lien identique
    $pourcentage = 0 ;

    for ($i=0; $i<count($tableau_phrase)-1; $i++){//on regroupe les liens du meme site
        $prec = $tableau_resultat[$i];
        $suiv = $tableau_resultat[$i+1];

        if( $prec[0]==$suiv[0] ){ // on teste si 2 lien sont identique et on les regroupes
            $cmp++;
            $pourcentage = $pourcentage + $suiv[1];
            $bloc=$bloc.$tableau_phrase[$i];
        }
        else{
            array_push($resultat, [$bloc,$prec[0],($pourcentage/$cmp)] );
            $cmp=1;
            $bloc=$tableau_phrase[$i];
            $pourcentage=$suiv[1];
        }
    }
    array_push($resultat, [$bloc,$suiv[0],($pourcentage/$cmp)] );
    return $resultat;
}


function rechercheWebavance($tab){
    $bloc= $tab[0] ;
     $lien = $tab[1];
     $site = file_get_contents($lien);
     return similar_text($bloc, $site)/strlen($bloc);
}



function avance($tableau){
    for ($i=0;$i<count($tableau);$i++){
        $tableau[$i][2]= rechercheWebavance($tableau[$i]);
    }
    return $tableau;
}


?>