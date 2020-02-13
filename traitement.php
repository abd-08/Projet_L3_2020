<?php

function comparaison_phrase($phrase, $phrase2){
    $resultat = similar_text($phrase , $phrase2);
    if (strlen($phrase)==0)return 0;
    return $resultat/strlen($phrase);
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
       echo "$i . $tab[$i]<br/>";
     }
}