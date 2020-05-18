<?php
header( 'content-type: text/html; charset=utf-8' );
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


function array_concat($tableau){
//fonction qui concatène tout les element string d'un tableau
//entre    $tableau : array<String>
//sortie    string
    $res="";
    for ($i=0;$i<count($tableau);$i++){
        $res=$res." ".$tableau[$i];
    }
    return $res;
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

    $q = preg_replace("/[.,;:\/\?\!]/", ' ', $phrase); // on nettoi la ponctuation

    preg_match("/\S.*\S/",$q,$trouve); //on supprime les espaces en debut et fin de phrase
    $q = $trouve[0];

    $q = preg_replace("/\s/","+",$q);//on ajoute les '+' aux endroits nécesssaire

    $lien = "https://www.google.com/search?q=\"".$q."\""; // on  construit le lien de recherche google
    $html = file_get_contents($lien);//a la place d utiliser curl
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
    $resultat = ["phrase" ,"lien",0];

    if(count($tableau_recheche)==1){ // si on a un seul resultat dans la recherche c est notre résultat
        $lien = recupereLienR($tableau_recheche[0]);
        $resultat=[$phrase, $lien , 100];
        return $resultat;
    }


    for ($i=0; $i<count($tableau_recheche); $i++){
        $contenu = preContenuAmeliorer($tableau_recheche[$i]);
        $similarite = compareMot( $entre , $contenu )*100;
        if ( $similarite > $resultat[2] ){
            $lien = recupereLienR($tableau_recheche[$i]);
            $resultat=[$phrase, $lien , $similarite ];
        }
    }
    return $resultat;
}




function compareMot($s1,$s2){
    //on compare 2 chaines de caractère et on renvoi le pourcentage de similarite
    //entre S1,S2 string
    //sortie float
    if (strlen($s1)<3 || strlen($s1)<3) return 0;
    $s1clean = preg_split("/\s?[\.\?\!\:\s]\s?/",$s1);
    $s2clean = preg_split("/\s?[\.\?\!\:\s]\s?/",$s2);
    $tabm = recupere_mot_tableau($s1clean);
    $tabm2 = recupere_mot_tableau($s2clean);
    $result = croisement_tableau($tabm, $tabm2);
    return nombreChar(array_values($result)) /nombreChar($s1clean);
}



function compareMot2($s1,$s2){
    //on compare 2 chaines de caractère et on renvoi le pourcentage de similarite ainsi que le resultat surligner de chaque phrase
    //entre S1,S2 string
    //sortie tab = [float similarite  , string phrase  , string phrase2 ]
    $s1=str_replace(".",". ",$s1);
    $s2=str_replace(".",". ",$s2);

    $tableau_mot= preg_split("/\s/",$s1);
    $tableau_mot_2 = preg_split("/\s/",$s2);

    $tableau_mot_anexe = recupere_mot_tableau($tableau_mot);
    $tableau_mot_2_anexe = recupere_mot_tableau($tableau_mot_2);

    $result = croisement_tableau($tableau_mot_anexe, $tableau_mot_2_anexe);
    $similarite =nombreChar(array_values($result))+count($result)-2;

    return [ $similarite , surligner_phrase($tableau_mot,$tableau_mot_anexe,$result),
        surligner_phrase($tableau_mot_2,$tableau_mot_2_anexe,$result)];
}


function est_char_special($char){
//fonction qui verifie si un caractère est accentuer
//entre string
//Sortie booleen
    $liste_char=["é", "è", "ê", "ë", "à", "â", "î", "ï", "ô", "ù", "û", "ü", "ÿ", "æ", "œ" ,"ç",
        "Â", "Ê", "Î", "Ô", "Û", "Ä", "Ë", "Ï", "Ö", "Ü", "À", "Æ", "æ", "Ç", "É", "È", "Œ","œ", "Ù"];
    if (strlen($char)==2)  return in_array($char,$liste_char);
    return false;
}

function est_char($char){
//fonction qui verifie si un caractère est alphanumerique
//entre string
//Sortie booleen
    if (strlen($char)==1 ) return preg_match('/[a-zA-Z0-9]/',$char)==true;
    return false;
}


function recupere_mot($chaine){
//  sans regex
//fonction qui supprime le les caractère non alphanumerique en debut et en fin de chaine
//entre : string
//sortie : string
    $debut=0;
    $fin = strlen($chaine);
    for ($i=0;$i<strlen($chaine);$i++){//on supprime les premiers caractères non alphanumerique
        if (!est_char($chaine[$debut]) ) {
            $debut++;
            if (est_char_special(substr($chaine, $debut-1, 2))){//un caractère avec accent compte pour 2 caractère
                $debut--;  break;
            }
        }
        else break;
    }

    if($debut>= $fin) ;
    else{
        for ($i=0;$i<strlen($chaine);$i++){//on supprime les derniers caractères non alphanumerique
            if (!est_char($chaine[$fin-1]) ) {
                $fin--;
                if (est_char_special(substr($chaine, $fin-1, 2))){
                    $fin++; break;}
            }
            else break;
        }
    }
    return  strtolower(substr($chaine, $debut, $fin-$debut));
}


function est_dans($value , $tableau){
    //fonction qui vérifie si un élément est présent dan sun tableau insensible à la casse
    //entrée   value:string  ,tableau:array<string>
    //sortie if true [true , tableau] (tableau = tableau moin value)
    //sortie if false [false]
    for ($i=0;$i<count($tableau);$i++){
        if ( strcasecmp( $value ,$tableau[$i])==0 ) {
            unset($tableau[$i]);
            $tableau = array_values($tableau);
            return [true,$tableau,$i];
        }
    }
    return [false];
}


function croisement_tableau($tableau , $tableau_2){
    //fonction qui nous renvoie l'intersection de 2 tableau insensible à la casse
    //entre :$tableau array<string> , $tableau_2 array<string>
    //sortie : array<string>

    $res=[""];
    $tableau_2_anexe = $tableau_2;
    for ($i=0;$i<count($tableau);$i++){
        $est_dans = est_dans($tableau[$i], $tableau_2_anexe);
        if ( $est_dans[0]){
            array_push($res,$tableau[$i]);
            $tableau_2_anexe = $est_dans[1];
        }
    }
    return $res;
}


function recupere_mot_tableau($tableau){
    //fonction qui récupere un tableau de string et applique la fonction recupere_mot sur chaque element
    //entre : tableau de string
    //sortie : tableau de string
    $tableau_res=[];
    for ($i=0;$i<count($tableau);$i++){
        array_push($tableau_res , recupere_mot($tableau[$i]));
    }
    return $tableau_res;
}



function marquer_mot($mot_regex , $mot ){
    //fonction qui va nous permettre de marquer un mot insensible à la casse
    //entre      mot_regex:string   ; mot:string
    //sortie  string

    $regex = "/[a-zA-Z0-9éèêëàâîïôùûüÿæœçÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒÙ]((\S)*([a-zA-Z0-9éèêëàâîïôùûüÿæœçÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒÙ]))?/";
   if ( preg_match($regex , $mot_regex , $mot_anexe) ){
       if (strcasecmp($mot_anexe[0],$mot) == 0)  return str_replace($mot_regex," <mark>".$mot_anexe[0]."</mark>",$mot_regex);
   }
    else return $mot_regex;
}



function surligner_phrase($phrase_tab ,$phrase_tab_anexe, $mot_a_souligner){
//fonction qui surligne les mots
//entre phrase_tab : tableau de string  ; mot_a_souligner : tableau de string
//sortie string

    $phrase_resultat="";
    for ($i=0;$i<count($phrase_tab);$i++){
        $res = est_dans($phrase_tab_anexe[$i],$mot_a_souligner ); //on verifie si un mot est à souligner
        if ($res[0]){///true
            unset($mot_a_souligner[$res[2]]);//on supprime le mot qu'on va souligner
            $mot_a_souligner  = array_values($mot_a_souligner );//on récupère le nouveau tableau
            $phrase_resultat = $phrase_resultat.marquer_mot($phrase_tab[$i] , $phrase_tab_anexe[$i] );//on marque le mot en question
        }
        else $phrase_resultat = $phrase_resultat." ".$phrase_tab[$i];
    }
    return $phrase_resultat;
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
            //$pourcentage = $pourcentage + $suiv[1];
            $pourcentage = $pourcentage + 1;
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


function nombreChar($tableau){
//fonction qui renvoie le nombre de char d une phrase
// entre : tableau de string
//sortie nombre
    $res=0;
    for ($i=0;$i<count($tableau);$i++){
        $res = $res + strlen($tableau[$i]);
    }
    return $res;
}


function tronquer($texte,$n){
//fonction qui va afficher renvoyer les n premier charactere d'un string
//entrée string
//sortie string
    if (strlen($texte) > $n)  {
        $texte = substr($texte, 0, $n);
        $texte =$texte.'...';
        return $texte;
    }
    else return $texte;
}


function color_pourcentage($res)
{
        if ($res <= 35) {
            $res1 =  "<p style='color: lime'>" . "$res" . "%" . "</p>";
        } elseif ($res > 35 && $res <= 65) {
            $res1 =  "<p style='color: darkorange'>" . "$res" . "%" . "</p>";
        } else {
            $res1 = "<p style='color: red'>" . "$res" . "%" . "</p>";
        }
    return $res1;
}


function afficheFormeTab($tres){
//procedure qui affiche un tableau à de type i*3 visuelement
// entre : un tableau a deux dimension

    echo "<table>";
    echo  " <thead>  <tr> <th> Phrase </th> ";
    echo " <th> Source </th>";
    echo "<th> Plagiat </th> </tr>  </thead> <tbody> ";

    for ( $i=0 ; $i<count($tres) ; $i++){
        $percent = number_format($tres[$i][2], 2);
        echo ' <tr>  <td >'.tronquer($tres[$i][0],120).'</td>';
        $lien = '<a href='.$tres[$i][1].' target="_blank" >'.tronquer($tres[$i][1],30).'</a>';
        echo  '<td>'.$lien.'</td>';
        echo '<td>'.'<b>'.color_pourcentage($percent).'</b>'.'</td> </tr>';
    }

    echo '</tbody></table>';
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


?>