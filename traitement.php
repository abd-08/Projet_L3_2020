<?php
//traitement de manière locale



function blockRecherche($html){
    //fonction qui renvoi un tableau a double dimension avec les blocks de resultat de recherche google
    $regex = "/(<div\sclass=\"r\"(\sstyle=\"white-space:nowrap\")?>)(.*?)class=\"s\"(.*?)<\/span>(.*?)<\/span>/";
    $regex = "/(<div\sclass=\"r\")(.*?)(class=\"r)/";
    preg_match_all($regex,$html,$tableau,PREG_PATTERN_ORDER);
    return $tableau[0];
}

function recupereLien($chaine){
    //on recupère le lien dans une chaine de caractère
     $regex = "/(div\sclass=\"r\">\s*)<a\shref=\"(((https?|ftp):\/\/(w{3}\.)?)(?<!www)(\w+-?)*\.([a-z]{2,4})(\S*?))(\")/" ;
     $regex = "/(div\sclass=\"r\".*?)<a\shref=\"(((https?|ftp):\/\/(w{3}\.)?)(?<!www)(\w+-?)*\.([a-z]{2,4})(\S*?))(\")/" ;
     if ( preg_match($regex,$chaine,$trouve) ){
        return $trouve[2];
     }
     else return "";
}



function preContenu($chaine){
    // Recupère le contenu de chaque block resultat de recherche

    $regex = "/<span class=\"st\">(.*?)(\.\.\.)?<\/span><(\/div|div)/" ;
    if ( preg_match($regex,$chaine,$trouve) ){
            return $trouve[1];
         }
   else return "";
}

function motGras($chaine){
//fonction qui  récupere les mots en gras dans un block de recherche
     $regex = "/<em>(.*?)<\/em>/" ;
     preg_match_all($regex,$chaine,$trouve) ;
     return $trouve[1];
}

function recherchePhraseWeb($phrase){
//fonction qui recherche une phrase sur internet et retourne l'html de la recherche google

    $q = preg_replace("/[.,;:\/\?\!]/", ' ', $phrase); // on nettoi la ponctuation

    preg_match("/\S.*\S/",$q,$trouve); //on supprime les espaces en debut et fin de phrase
    $q = $trouve[0];

    $q = preg_replace("/\s/","+",$q);//on ajoute les '+' aux endroits nécesssaire

    $lien = "https://www.google.com/search?q=".$q;

    return $html;


}


function compareStrings($s1, $s2) {
    //one is empty, so no result
    if (strlen($s1)==0 || strlen($s2)==0) {
        return 0;
    }

    //replace none alphanumeric charactors
    //i left - in case its used to combine words
    $s1clean = preg_replace("/[^A-Za-z0-9-]/", ' ', $s1);
    $s2clean = preg_replace("/[^A-Za-z0-9-]/", ' ', $s2);

    //remove double spaces
    while (strpos($s1clean, "  ")!==false) {
        $s1clean = str_replace("  ", " ", $s1clean);
    }
    while (strpos($s2clean, "  ")!==false) {
        $s2clean = str_replace("  ", " ", $s2clean);
    }

    //create arrays
    $ar1 = explode(" ",$s1clean);
    $ar2 = explode(" ",$s2clean);
    $l1 = count($ar1);
    $l2 = count($ar2);

    //flip the arrays if needed so ar1 is always largest.
    if ($l2>$l1) {
        $t = $ar2;
        $ar2 = $ar1;
        $ar1 = $t;
    }

    //flip array 2, to make the words the keys
    $ar2 = array_flip($ar2);

    $maxwords = max($l1, $l2);
    $matches = 0;

    //find matching words
    foreach($ar1 as $word) {
        if (array_key_exists($word, $ar2))
            $matches++;
    }

    return ($matches / $maxwords) * 100;
}



function comparaison_phrase($phrase, $phrase2){
    $resultat= 0;
    $resultat = similar_text($phrase , $phrase2);
    return $resultat;
}


function comparaison_phrase_texte($phrase,$Liste_phrase){
    $res=0;

    for ($i=0; $i<count($Liste_phrase); $i++) {
        $temp = comparaison_phrase($phrase,$Liste_phrase[$i]);

      if ($res<$temp){
        $res=$temp;
        unset($Liste_phrase[$i]);
        $Liste_phrase = array_values($Liste_phrase);
      }
      if ($temp==1) break;
    }
     echo "$res<br/>";
    return $res;
}

function comparaison_texte_texte($texte1,$texte2){
    $Liste_phrase = preg_split("/[\.]/",$texte1);
    $Liste_phrase_comparer = preg_split("/[\.]/",$texte2);
    $resultat = 0;

     for ($i=0; $i<count($Liste_phrase); $i++) {
        if (count($Liste_phrase) != 0) {
            $resultat =$resultat + comparaison_phrase_texte($Liste_phrase[$i],$Liste_phrase_comparer);
        }
     }

    return $resultat/count($Liste_phrase);
}


function affichetab($tab){

     for ($i=0; $i<count($tab); $i++) {
     $pos= $i+1;
       echo "$pos) $tab[$i]<br/>";
     }
}


function affiche($tab){
       echo "tableau  :".count($tab)."<br/>";
     for ($i=0; $i<count($tab); $i++) {
         for ($j=0; $j<count($tab[$i]); $j++) {

            var_dump( "$i .$j.=> $tab[$i][$j].<br/>");
         }
     }
}

