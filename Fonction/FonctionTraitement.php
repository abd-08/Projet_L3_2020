<?php

header('content-type: text/html; charset=utf-8');

////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////       traitement caractère         ////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
function est_char_special($char)
{
//fonction qui verifie si un caractère est accentuer
//entre string
//Sortie booleen
    $liste_char = ["é", "è", "ê", "ë", "à", "â", "î", "ï", "ô", "ù", "û", "ü", "ÿ", "æ", "œ", "ç",
        "Â", "Ê", "Î", "Ô", "Û", "Ä", "Ë", "Ï", "Ö", "Ü", "À", "Æ", "æ", "Ç", "É", "È", "Œ", "œ", "Ù"];
    if (strlen($char) == 2) return in_array($char, $liste_char);
    return false;
}

function est_char($char)
{
//fonction qui verifie si un caractère est alphanumerique
//entre string
//Sortie booleen
    if (strlen($char) == 1) return preg_match('/[a-zA-Z0-9]/', $char) == true;
    return false;
}


////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////             traitement mot         ////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

function tronquer($texte, $n)
{
//fonction qui va afficher renvoyer les n premier charactere d'un string
//entrée string
//sortie string
    if (strlen($texte) > $n) {
        $texte = substr($texte, 0, $n);
        $texte = $texte . '...';
        return $texte;
    } else return $texte;
}


function recupere_mot($chaine)
{
//  sans regex
//fonction qui supprime le les caractère non alphanumerique en debut et en fin de chaine
//entre : string
//sortie : string
    $debut = 0;
    $fin = strlen($chaine);
    for ($i = 0; $i < strlen($chaine); $i++) {//on supprime les premiers caractères non alphanumerique
        if (!est_char($chaine[$debut])) {
            $debut++;
            if (est_char_special(substr($chaine, $debut - 1, 2))) {//un caractère avec accent compte pour 2 caractère
                $debut--;
                break;
            }
        } else break;
    }

    if ($debut >= $fin) ;
    else {
        for ($i = 0; $i < strlen($chaine); $i++) {//on supprime les derniers caractères non alphanumerique
            if (!est_char($chaine[$fin - 1])) {
                $fin--;
                if (est_char_special(substr($chaine, $fin - 1, 2))) {
                    $fin++;
                    break;
                }
            } else break;
        }
    }
    return strtolower(substr($chaine, $debut, $fin - $debut));
}


////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////      traitement tableau             ///////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

function est_dans($value, $tableau)
{
    //fonction qui vérifie si un élément est présent dan sun tableau insensible à la casse
    //entrée   value:string  ,tableau:array<string>
    //sortie if true [true , tableau] (tableau = tableau moin value)
    //sortie if false [false]
    for ($i = 0; $i < count($tableau); $i++) {
        if (strcasecmp($value, $tableau[$i]) == 0) {
            unset($tableau[$i]);
            $tableau = array_values($tableau);
            return [true, $tableau, $i];
        }
    }
    return [false];
}


function array_concat($tableau)
{
//fonction qui concatène tout les element string d'un tableau
//entre    $tableau : array<String>
//sortie    string
    $res = "";
    for ($i = 0; $i < count($tableau); $i++) {
        $res = $res . " " . $tableau[$i];
    }
    return $res;
}


function croisement_tableau($tableau, $tableau_2)
{
    //fonction qui nous renvoie l'intersection de 2 tableau insensible à la casse
    //entre :$tableau array<string> , $tableau_2 array<string>
    //sortie : array<string>

    $res = [];
    $tableau_2_anexe = $tableau_2;
    for ($i = 0; $i < count($tableau); $i++) {
        $est_dans = est_dans($tableau[$i], $tableau_2_anexe);
        if ($est_dans[0]) {
            array_push($res, $tableau[$i]);
            $tableau_2_anexe = $est_dans[1];
        }
    }
    return $res;
}


function nombreChar($tableau)
{
//fonction qui renvoie le nombre de char d une phrase
// entre : tableau de string
//sortie nombre
    $res = 0;
    for ($i = 0; $i < count($tableau); $i++) {
        $res = $res + strlen($tableau[$i]);
    }
    return $res;
}


////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////  fonction pour copie et web   ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function compareMot($s1, $s2)
{
    //on compare 2 chaines de caractère et on renvoi le pourcentage de similarite
    //entre S1,S2 string
    //sortie float
    if (strlen($s1) < 3 || strlen($s1) < 3) return 0;
    $s1clean = preg_split("/\s+/", $s1);
    $s2clean = preg_split("/\s+/", $s2);

    $s1clean = recupere_mot_tableau_web($s1clean);
    $s2clean = recupere_mot_tableau_web($s2clean);

    $result = croisement_tableau($s1clean, $s2clean);

    $similarite = (nombreChar(array_values($result)) + count($result) - 2) / (nombreChar($s1clean) + count($result) - 2);
    $phrase = surligner_phrase_w($s1clean, $result);

    return [$similarite, $phrase];
}


function recupere_mot_tableau_web($tableau)
{
    //celle fonction qui est similaire  recupère_mot_tableau est fait pour les plagiat en ligne car on a des fois caratère spéciaux
    //fonction qui récupere un tableau de string et on supprime des caractères spéciaux dans des chaines de caractères
    //entre : tableau de string
    //sortie : tableau de string
    $tableau_res = [];
    for ($i = 0; $i < count($tableau); $i++) {
        preg_match("/[.;:,\"]?([^.;:,\"]*)[.;:,\"]?/", $tableau[$i], $mot);
        array_push($tableau_res, $mot[1]);
    }
    return $tableau_res;
}


function surligner_phrase_w($phrase_tab, $mot_a_souligner)
{
//fonction qui surligne les mots
//entre phrase_tab : tableau de string  ; mot_a_souligner : tableau de string
//sortie string

    $phrase_resultat = "";
    for ($i = 0; $i < count($phrase_tab); $i++) {
        $res = est_dans($phrase_tab[$i], $mot_a_souligner); //on verifie si un mot est à souligner
        if ($res[0]) {///on test si $phrase_tab[$i] est dans $mot_a_souligner
            unset($mot_a_souligner[$res[2]]);//on supprime le mot qu'on va souligner
            $mot_a_souligner = array_values($mot_a_souligner);//on récupère le nouveau tableau
            $phrase_resultat = $phrase_resultat . " <mark>" . $phrase_tab[$i] . "</mark>";//on marque le mot en question
        } else $phrase_resultat = $phrase_resultat . " " . $phrase_tab[$i];
    }
    return $phrase_resultat;
}


function transfere_surligne($tableau_phrase, $tableau_phrase_clean, $phrase_web_surligne)
{
    //fonction qui fait la correlation entre la phrase récupérer dans l'entré d'une recherche google
    // et qui fait la correlation avec la phrase de départ
    //entre        $tableau_phrase:   phrase de départ spliter avec /s
    //entre        $tableau_phrase_clean= $tableau_phrase avec la fonction récupère_mot qui lui est appliqué
    //entre        $tableau_web_surligne = le résultat du traitement de la phrase de recherche web
    //sortie      string


    if ($tableau_phrase[0] == "") {//on supprime le premier element si il est vide
        unset($tableau_phrase[0]);
        $tableau_phrase = array_values($tableau_phrase);
    }
    if ($tableau_phrase_clean[0] == "") {//on supprime le premier element si il est vide
        unset($tableau_phrase_clean[0]);
        $tableau_phrase_clean = array_values($tableau_phrase_clean);
    }

    $tableau_mot_surligne = preg_split("/\s+/", $phrase_web_surligne);
    if ($tableau_mot_surligne[0] == "") {//on supprime le premier element si il est vide
        unset($tableau_mot_surligne[0]);
        $tableau_mot_surligne = array_values($tableau_mot_surligne);
    }
    if ($tableau_mot_surligne[count($tableau_mot_surligne) - 1] == "<mark></mark>") {//on supprime le premier element si il est vide
        unset($tableau_mot_surligne[count($tableau_mot_surligne) - 1]);
        $tableau_mot_surligne = array_values($tableau_mot_surligne);
    }

    $phrase_resultat = "";
    for ($i = 0; $i < count($tableau_phrase); $i++) {
        if (preg_match("/<mark>/", $tableau_mot_surligne[$i])) {
            $phrase_resultat = $phrase_resultat . marquer_mot($tableau_phrase[$i], $tableau_phrase_clean[$i]);
        } else  $phrase_resultat = $phrase_resultat . " " . $tableau_phrase[$i];
    }

    if (preg_match("/\./", $phrase_resultat)) $point = "";
    else $point = ".";
    return $phrase_resultat . $point;
}


////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////  fonction pour copie à copie  ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function recupere_mot_tableau($tableau)
{
    //fonction qui récupere un tableau de string et applique la fonction recupere_mot sur chaque element
    //entre : tableau de string
    //sortie : tableau de string
    $tableau_res = [];
    for ($i = 0; $i < count($tableau); $i++) {
        array_push($tableau_res, recupere_mot($tableau[$i]));
    }
    return $tableau_res;
}


function compareMot2($s1, $s2)
{
    //on compare 2 chaines de caractère et on renvoi le pourcentage de similarite ainsi que le resultat surligner de chaque phrase
    //entre S1,S2 string
    //sortie tab = [float similarite  , string phrase  , string phrase2 ]
    $s1 = str_replace(".", ". ", $s1);
    $s2 = str_replace(".", ". ", $s2);

    $tableau_mot = preg_split("/\s/", $s1);
    $tableau_mot_2 = preg_split("/\s/", $s2);

    $tableau_mot_anexe = recupere_mot_tableau($tableau_mot);
    $tableau_mot_2_anexe = recupere_mot_tableau($tableau_mot_2);

    $result = croisement_tableau($tableau_mot_anexe, $tableau_mot_2_anexe);
    $similarite = nombreChar(array_values($result)) + count($result) - 2;

    return [$similarite, surligner_phrase($tableau_mot, $tableau_mot_anexe, $result),
        surligner_phrase($tableau_mot_2, $tableau_mot_2_anexe, $result)];
}

function marquer_mot($mot_regex, $mot)
{
    //fonction qui va nous permettre de marquer un mot insensible à la casse
    //entre      mot_regex:string   ; mot:string
    //sortie  string

    $regex = "/[a-zA-Z0-9éèêëàâîïôùûüÿæœçÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒÙ]((\S)*([a-zA-Z0-9éèêëàâîïôùûüÿæœçÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒÙ]))?/";
    $point = "";
    if (strlen($mot_regex) > 0) {
        if ($mot_regex[strlen($mot_regex) - 1] == ".") $point = ".";
    }

    if (preg_match($regex, $mot_regex, $mot_anexe)) {

        if (strcasecmp($mot_anexe[0], $mot) == 0) return str_replace($mot_regex, " <mark>" . $mot_anexe[0] . "</mark>" . $point, $mot_regex);
        else return "<mark>" . $mot_regex . "</mark>" . $point;
    } else return $mot_regex . $point;
}


function surligner_phrase($phrase_tab, $phrase_tab_anexe, $mot_a_souligner)
{
//fonction qui surligne les mots
//entre phrase_tab : tableau de string  ; mot_a_souligner : tableau de string
//sortie string

    $phrase_resultat = "";
    for ($i = 0; $i < count($phrase_tab); $i++) {
        $res = est_dans($phrase_tab_anexe[$i], $mot_a_souligner); //on verifie si un mot est à souligner
        if ($res[0]) {///true
            unset($mot_a_souligner[$res[2]]);//on supprime le mot qu'on va souligner
            $mot_a_souligner = array_values($mot_a_souligner);//on récupère le nouveau tableau
            $phrase_resultat = $phrase_resultat . marquer_mot($phrase_tab[$i], $phrase_tab_anexe[$i]);//on marque le mot en question
        } else $phrase_resultat = $phrase_resultat . " " . $phrase_tab[$i];
    }
    return $phrase_resultat;
}


////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////  fonction affichage resultat  ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

function color_pourcentage($res)
{
    if ($res > 50) {
        $vert = (100 - $res) * 0.02 * 255;
        $vert = number_format($vert, 0);
        $res1 = "<p style='color: rgb(255,$vert,0)'>" . "$res" . "%" . "</p>";
    } elseif ($res < 50) {
        $rouge = $res * 0.02 * 255;
        $rouge = number_format($rouge, 0);
        $res1 = "<p style='color: rgb($rouge,255,0)'>" . "$res" . "%" . "</p>";
    } else {
        $res1 = "<p style='color: rgb(255,255,0)'>" . "$res" . "%" . "</p>";
    }
    return $res1;
}


function afficheFormeTab($tres)
{
//procedure qui affiche un tableau à de type i*3 visuelement
// entre : un tableau a deux dimension

    echo "<table>";
    echo " <thead>  <tr> <th> Phrase </th> ";
    echo " <th> Source </th>";
    echo "<th> Plagiat </th> </tr>  </thead> <tbody> ";

    for ($i = 0; $i < count($tres); $i++) {
        $percent = number_format($tres[$i][2], 2);
        echo ' <tr>  <td >' . tronquer($tres[$i][0], 120) . '</td>';
        $lien = '<a href=' . $tres[$i][1] . ' target="_blank" >' . tronquer($tres[$i][1], 30) . '</a>';
        echo '<td>' . $lien . '</td>';
        echo '<td>' . '<b>' . color_pourcentage($percent) . '</b>' . '</td> </tr>';
    }

    echo '</tbody></table>';
}

function afficheResultat($resultat)
{
    //fonction qui affiche un résultat ous forme d'un camenbert
    //entre      resultat:float

    $resultat_sans_virgule = number_format($resultat, 0);


    if ($resultat <= 50) {
        echo "<div class=\"progress-circle p$resultat_sans_virgule\">
       <span>$resultat%</span>
       <div class=\"left-half-clipper\">
          <div class=\"first50-bar\"></div>
          <div class=\"value-bar\"></div>
       </div>
    </div>";
    } elseif ($resultat > 50 && $resultat <= 100) {
        echo "<div class=\"progress-circle over50 p$resultat_sans_virgule\">
           <span>$resultat%</span>
           <div class=\"left-half-clipper\">
              <div class=\"first50-bar\"></div>
              <div class=\"value-bar\"></div>
           </div>
        </div>";
    } else {
        echo "<div class=\"progress-circle over50 p100\">
           <span>100%</span>
           <div class=\"left-half-clipper\">
              <div class=\"first50-bar\"></div>
              <div class=\"value-bar\"></div>
           </div>
        </div>";
    }

}



