<?php


function blockRechercheR($html){
    //fonction qui renvoi un tableau avec les blocks de resultat de recherche google
    $regex = "/\sxpd\sO9g5cc\suUPGi\"><div\sclass=\"kCrYT(.*?)url([\s\S]*?)(ZINbbc|mCljob)/i";
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


function array_concat($tableau){
//fonction qui concatène tout les element string d'un tableau
    $res="";
    for ($i=0;$i<count($tableau);$i++){
        $res=$res." ".$tableau[$i];
    }
return $res;
}

function preContenuAmeliorer($chaine){
// Recupère le contenu texte de chaque block resultat de recherche
    preg_match_all("/>([^><]{2,}?)</",$chaine ,$tab);
    $contenu = array_concat($tab[1]);
    return $contenu;
}


function entreAvance($chaine){
    //on recupère le texte de recherche de la page recherche de google
       $regex = "/<title>(.*?)\-\sRecherche\sGoogle<\/title>/" ;
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

    $html = file_get_contents($lien);//a la place d utiliser curl
    return $html;
}


function recherchePhraseWebAvance($phrase){
//fonction qui recherche une phrase sur internet et retourne l'html de la recherche google

    $q = preg_replace("/[.,;:\/\?\!]/", ' ', $phrase); // on nettoi la ponctuation

    preg_match("/\S.*\S/",$q,$trouve); //on supprime les espaces en debut et fin de phrase
    $q = $trouve[0];

    $q = preg_replace("/\s/","+",$q);//on ajoute les '+' aux endroits nécesssaire

    $lien = "https://www.google.com/search?q=\"".$q."\""; // on  construit le lien de recherche google
    $html = file_get_contents($lien);//a la place d utiliser curl
    return $html;
}



function selectBetterlinkAvance($phrase){
    //on va séléctionner le lien qui a un contenu qui match le plus avec la phrase entrée
    //le résultat est sous forme de tableau avec le lien en t[0] et le pourcentage de similarite en t[1]

    $html = recherchePhraseWebAvance($phrase);
    $entre = entreAvance($html);
    $tableau_recheche = blockRechercheR($html);
    $resultat = ["lien",0];

    if(count($tableau_recheche)==1){ // si on a un seul resultat dans la recherche c est notre résultat
        $lien = recupereLienR($tableau_recheche[0]);
        $resultat=[ $lien , 1];
    }


     for ($i=0; $i<count($tableau_recheche); $i++){
        $contenu = preContenuAmeliorer($tableau_recheche[$i]);
        $similarite = compareMot( $entre , $contenu );
         $lien = recupereLienR($tableau_recheche[$i]);

        if ( $similarite > $resultat[1] ){
            $resultat=[ $lien , $similarite];
        }
     }


if ($resultat[1]<0.15){
    $html = recherchePhraseWebR($phrase);
    $entre = entreAvance($html);
    $tableau_recheche_2 = blockRechercheR($html);

     $contenu2 = preContenuAmeliorer($tableau_recheche_2[0]);
     $similarite2 = compareMot( $entre , $contenu2 );
     if ($similarite2 > $resultat[1]){
          $lien2 = recupereLienR($tableau_recheche_2[0]);
          $resultat=[ $lien2 , $similarite2];
     }
 }

     return $resultat;
}




function compareMot($s1,$s2){
    //on compare 2 chaines de caractère et on renvoi le pourcentage de similarite
    $s1clean = preg_split("/\s?[\.\?\!\:\s]\s?/",$s1);
    $s2clean = preg_split("/\s?[\.\?\!\:\s]\s?/",$s2);
    $result = array_intersect($s1clean, $s2clean);
    if (strlen($s1)<3 | strlen($s1)<3) return 0;
    return nombreChar(array_values($result))/nombreChar($s1clean);

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
        array_push($resultat, selectBetterlinkAvance($tableau[$i]));
     }

     var_dump($resultat);
      return interpretationResultat($resultat ,$tableau);
}



function interpretationResultat($tableau_resultat ,$tableau_phrase){
    $resultat=[];
    $bloc=$tableau_phrase[0]; //contiendra les phrase qui viennent du meme site
    $cmp=1; // compteur pour le nombre de lien identique
    $pourcentage = $tableau_resultat[0][1] ;
    $suiv = $tableau_resultat[0];

    for ($i=0; $i<count($tableau_phrase)-1; $i++){//on regroupe les liens du meme site
        $prec = $tableau_resultat[$i];
        $suiv = $tableau_resultat[$i+1];

        if( $prec[0]==$suiv[0] ){ // on teste si 2 lien sont identique et on les regroupes
            $cmp++;
            $pourcentage = $pourcentage + $suiv[1];
            $bloc=$bloc.$tableau_phrase[$i+1];
        }
        else{
            array_push($resultat, [$bloc,$prec[0],($pourcentage/$cmp)] );
            $cmp=1;
            $bloc=$tableau_phrase[$i+1];
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

function nombreChar($tableau){
    $res=0;
    for ($i=0;$i<count($tableau);$i++){
        $res = $res + strlen($tableau[$i]);
    }
   return $res;
}


?>