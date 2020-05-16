/*
$html = recherchePhraseWebR("Alors que certains hommes mentionnaient que leur sexualité était cachée à leurs connaissances ou à leurs collègues de travail");
$t=blockRechercheR($html);

var_dump($html);
var_dump($t);
var_dump(recupereLienR($t[0]));
var_dump(preContenuR($t[0]));


$e=entreR($html);
var_dump(compareStringsR($e, preContenuR($t[0])));
var_dump($e);




echo $html;
//print_r($t);
//affiche($t);




/*
echo "<br/> <br/>";
echo "***************************************************************************";


var_dump(recupereLien($t[8]));
$pre=preContenu($t[8]);
var_dump($pre);
$gras = motGras($pre);
var_dump($gras);


echo strlen($gras[0]);
//echo recherchePhraseWeb($gras[0]) ;
//var_dump (recherchePhraseWeb($gras[0]));

//affiche($t);

 // Init
    $url = "https://stackoverflow.com/feeds/tag?tagnames=php&sort=newest";
    $url = "https://www.google.com/search?sxsrf=ALeKk01mlP6MiI6Jj0aAeMU5iQR9ZMgoBw%3A1585493214621&source=hp&ei=3rSAXrTRI4volwT85bmQBw&q=Ils+consid%C3%A9raient+que+l%E2%80%99action+prot%C3%A9geait+les+membres+de+la+famille+contre+le+sujet+tabou+de+la+sexualit%C3%A9.&oq=Ils+consid%C3%A9raient+que+l%E2%80%99action+prot%C3%A9geait+les+membres+de+la+famille+contre+le+sujet+tabou+de+la+sexualit%C3%A9.&gs_lcp=CgZwc3ktYWIQA1D8xANY_MQDYOjXA2gEcAB4AIABAIgBAJIBAJgBAKABAqABAaoBB2d3cy13aXo&sclient=psy-ab&ved=0ahUKEwi0uOW-9r_oAhUL9IUKHfxyDnIQ4dUDCAo&uact=5";
    $url = "https://www.google.com/search?q=En+r%C3%A9ponse+%C3%A0+cette+stigmatisation,+ils+ont+adapt%C3%A9+leur+expression+personnelle+%C3%A0+la+situation+dans+laquelle+ils+se+trouvaient";
    $curl = curl_init();

    // Options
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, $url);

    // Execut
    $resp = curl_exec($curl);

    // Libération des ressources
    curl_close($curl);

    echo $resp;


echo "<br/> <br/>";
echo "<br/> <br/>";

/*
//313 charactere afficher par google.

$line = "https://www.google.fr/search?q=De+taille+moyenne+et+de+format+carré+,+l+'+Arabe-Barbe+présente+la+morphologie+typique+d+'+un+cheval+de+selle+adapté+à+la+vitesse+,+avec+une+circonférence+de+poitrine+importante.+Employé+notamment+pour+les+fantasias+,+il+l+'+est+aussi+pour+le+travail+agricole+de+traction+dans+les+régions+rurales+du+Maghreb+,+bien+que+cela+concerne+essentiellement+les+chevaux+aux+origines+Barbe+majoritaires.%";
$html = file_get_contents($line);
//echo $html;


$lien = 'https://www.scribbr.fr/le-plagiat/types-de-plagiat/';
$mot = preg_replace("/[[:punct:]]/", "+", $texte1);
$mot = preg_replace("/[[:space:]]/", "+", $mot);
$mot = preg_replace("/[\+\+]/", "+", $mot);
$mot = substr($mot, 0, -1);
//$mot= str_replace(" ", "+", $texte1);
//echo $mot;


$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $line);
curl_setopt($curl, CURLOPT_COOKIESESSION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$return = curl_exec($curl);
curl_close($curl);
//echo $return;

$curl = curl_init();
$texte_lien = $texte1;
$texte_lien = str_replace(" ", "+", $texte_lien);
$texte_lien = str_replace(".", "+.+", $texte_lien);
$texte_lien = str_replace(",", "+,+", $texte_lien);
curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/search?q='.$texte_lien."%");
curl_setopt($curl, CURLOPT_COOKIESESSION, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
curl_close($curl);
//echo $result;



include('simple_html_dom.php');



$domResult = new simple_html_dom();
$domResult->load($result);

foreach($domResult->find('a[href^=/url?]') as $link)
echo $link->plaintext . '<br>';

echo "<br/> <br/> ******************************************************************************************";

/*
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName("Client_Library_Examples");
$client->setDeveloperKey("XXXXXXX");

$service = new Google_Service_Books($client);
$optParams = array('filter' => 'free-ebooks');
$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

foreach ($results as $item) {
  echo $item['volumeInfo']['title'], "<br /> \n";
}


/*

$domResult2 = new simple_html_dom();
$domResult2->load($result);

foreach($domResult2->find('a[href^=/url?]') as $link2)
echo $link2->outertext . '<br>';


echo "<br/> <br/> ******************************************************************************************";
echo "<br/> <br/> ******************************************************************************************";

$domResult3 = new simple_html_dom();
$domResult3->load($result);

foreach($domResult3->find('a[href^=/url?]') as $link3)
echo $link3->innertext . '<br>';

echo "<br/> <br/> ******************************************************************************************";
echo "<br/> <br/> ******************************************************************************************";

$domResult4 = new simple_html_dom();
$domResult4->load($result);

foreach($domResult4->find('a[href^=/url?]') as $link4)
echo $link4->xmltext . '<br>';



    //$regex = "/T\"><a(.*?)(http)(.*?)(class=\"kCrYt\")(.*?)([^<>]{90,})/i";
    //$regex = "/((href=\"http|url\?q=))(.*?)(class=\"kCrYt\")(.*?)(class=\"kCrYt\")/i";

// $regex = "/url\?q(.*?)(\.\.\.\s)?(.*?)href/i";
    //$regex = "/(ved(.*?))?\sxpd\sO9g5cc\suUPGi\"><div\sclass=\"kCrYT(.*?)url(.*?)(ZINbbc|account)/i";

var_dump( urldecode(urldecode("b%25C3%25A9b%25C3%25A9" )) );


function preContenuR($chaine){
    // Recupère le contenu de chaque block resultat de recherche
    $regex = "/>([^<>]{100,})</" ;
    if ( preg_match($regex,$chaine,$trouve) ){
            return $trouve[1];
         }
   else return "";
}


function selectBetterlink($phrase){
    //on va séléctionner le lien qui a un contenu qui match le plus avec la phrase entrée
    //le résultat est sous forme de tableau avec le lien en t[0] et le pourcentage de similarite en t[1]


    $html = recherchePhraseWebR($phrase);
    $entre = entreR($html);
    $tableau_recheche = blockRechercheR($html);
    $resultat = ["lien",0];

    //echo "<br>".$phrase."**************<br>TEXTE ENTRE".$entre."<br><br>";

     for ($i=0; $i<count($tableau_recheche); $i++){
        $contenu = preContenuAmeliorer($tableau_recheche[$i]);
        $similarite = compareMot( $entre , $contenu );
         $lien = recupereLienR($tableau_recheche[$i]);
         $lien = utf8_decode(urldecode(urldecode($lien ))) ;
       //echo $contenu."<br>";
       // echo $lien."<br><br>*********************<br>";


        if ( $similarite > $resultat[1] ){
            $resultat=[ $lien , $similarite];
        }
     }

 if ($resultat[1]<0.3){
    $html = recherchePhraseWebAvance($phrase);
     $entre = entreR($html);
    echo $html;
    $tableau_recheche_2 = blockRechercheR($html);


     $contenu2 = preContenuAmeliorer($tableau_recheche_2[0]);
     $similarite2 = compareMot( $entre , $contenu2 );
     if ($similarite2 > $resultat[1]){
          $lien2 = recupereLienR($tableau_recheche[0]);
          $lien2 = urldecode(urldecode($lien2 )) ;
          $resultat=[ $lien2 , $similarite2];
     }
 }
     return $resultat;
}




if ($resultat[1]<0.2){
    $html = recherchePhraseWebR($phrase);
    $entre = entreAvance($html);
    $tableau_recheche_2 = blockRechercheR($html);
    var_dump($tableau_recheche_2);

     $contenu2 = preContenuAmeliorer($tableau_recheche_2[0]);
     $similarite2 = compareMot( $entre , $contenu2 );
     if ($similarite2 > $resultat[1]){
          $lien2 = recupereLienR($tableau_recheche_2[0]);
          $resultat=[ $lien2 , $similarite2];
     }
 }

function entreR($chaine){
    //on recupère le texte de recherche de la page recherche de google
       $regex = "/class=\"noHIxc\"\svalue=\"(.*?)\"/i" ;
        if ( preg_match($regex,$chaine,$trouve) ){
                return $trouve[1];
             }
       else return "";
}



*/


/*
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $lien);
    curl_setopt($curl, CURLOPT_COOKIESESSION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($curl); //on recupere l html de la recherche
    curl_close($curl);
*/

/*

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
                     $debut++;  break;
            }
        }
        else break;
    }

    if($debut>= $fin) var_dump("erreur");
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
    return  substr($chaine, $debut, $fin-$debut);
}

function tabsurligne($text , $balise_o , $balise_f){
//on creer un tableau qui permet de connaitre le debut ou la fin d'une expression baliser
//tab[0] contient t[debut,fin] ; $debut contient le debut de l expression baliser et $fin sa fin
//entre $text : string ; $balise_o:string (le type de balise ouvrant) ; $balise_f:string(le type de balise fermante)
//sortie : tableau n*2
$tab=[];
$substring=$text;
$length=strlen($substring);
$index=0;
$debut=strpos($substring,$balise_o);
while ($debut!=false){
$fin=strpos($substring, $balise_f);
if ($fin!=false){
array_push($tab,[$index+$debut,$index+$fin+strlen($balise_f)-1]);
$substring = substr($substring, $fin+7 ,$length-$fin);
$index=$index+$fin+strlen($balise_f);
$length=strlen($substring);
$debut=strpos($substring, $balise_o);
}
else{
array_push($tab,[$index+$debut,-1]);
$debut=false;
}
}
return$tab;
}

function lettre($position, $a, $b ,$tbalise  ){
if (($position>=$a && $position<$a+$tbalise) || ($position>=$b-$tbalise && $position<=$b) ) return  "balise";
else if(($position>=$a+$tbalise && $position<$b-$tbalise) || ($position>=$a+$tbalise && $tbalise==-1 )) return  "infecte";
else return "non-infecte";
}

function checkIndex($tab , $index , $tbalise ){
if (count($tab)>0){
for($i=0;$i<count($tab);$i++){
$a = $tab[$i][0];
$b = $tab[$i][1];
if ( $this->lettre($index,$a,$b,$tbalise) =="balise"){
return "balise";
}
if ( $this->lettre($index,$a,$b,$tbalise) =="infecte"){
return "infecte";
}
}
}
return "non-infecte";
}


function MultiCellEffect($w, $h, $txt, $border=0, $align='J', $fill=false)
{
// Output text with automatic or explicit line breaks
if (!isset($this->CurrentFont))
$this->Error('No font has been set');
$cw = &$this->CurrentFont['cw'];
if ($w == 0)
$w = $this->w - $this->rMargin - $this->x;
$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
$s = str_replace("\r", '', $txt);
$nb = strlen($s);
if ($nb > 0 && $s[$nb - 1] == "\n")
$nb--;
$b = 0;
if ($border) {
if ($border == 1) {
$border = 'LTRB';
$b = 'LRT';
$b2 = 'LR';
} else {
$b2 = '';
if (strpos($border, 'L') !== false)
$b2 .= 'L';
if (strpos($border, 'R') !== false)
$b2 .= 'R';
$b = (strpos($border, 'T') !== false) ? $b2 . 'T' : $b2;
}
}
$sep = -1;
$i = 0;
$j = 0;
$l = 0;
$ns = 0;
$nl = 1;
$tab = $this->tabsurligne($s, "<mark>", "</mark>");
while ($i < $nb) {
// Get next character
$c = $s[$i];
if ($c == "\n") {
// Explicit line break
if ($this->ws > 0) {
$this->ws = 0;
$this->_out('0 Tw');
}
$this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
$i++;
$sep = -1;
$j = $i;
$l = 0;
$ns = 0;
$nl++;
if ($border && $nl == 2)
$b = $b2;
continue;
}
if ($c == ' ') {
$sep = $i;
$ls = $l;
$ns++;
}
$l += $cw[$c];
if ($l > $wmax) {
// Automatic line break
if ($sep == -1) {
if ($i == $j)
$i++;
if ($this->ws > 0) {
$this->ws = 0;
$this->_out('0 Tw');
}
$this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
} else {
if ($align == 'J') {

$this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
$this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
}
switch ( $this->checkIndex($tab,$i,6)){

case "balise":
$this->Cell($w, $h, '', $b, 2, $align, true);
break;
case "infecte":
$this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, true);
break;
case "non-infecte":
$this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill);
break;
}

// $this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill);
$i = $sep + 1;
}
$sep = -1;
$j = $i;
$l = 0;
$ns = 0;
$nl++;
if ($border && $nl == 2)
$b = $b2;
} else
$i++;
}
// Last chunk
if ($this->ws > 0) {
$this->ws = 0;
$this->_out('0 Tw');
}
if ($border && strpos($border, 'B') !== false)
$b .= 'B';


$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
$this->x = $this->lMargin;
}


*/
