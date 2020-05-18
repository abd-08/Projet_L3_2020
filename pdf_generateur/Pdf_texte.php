<?php
session_start();
require('WriteTag.php');

$similarite =$_SESSION['similitude'];
$similarite_2 =$_SESSION['similitude_2'];
$texte =  $_SESSION['texte'] ;
$texte_2 =  $_SESSION['texte_2'] ;

$pdf=new PDF_WriteTag();
$pdf->SetMargins(30,15,25);
$pdf->SetFont('courier','',12);
$pdf->AddPage();

// Feuille de style
$pdf->SetStyle("p","times","N",10,"0,0,0",15);
$pdf->SetStyle("h1","times","N",18,"102,0,102",0);
$pdf->SetStyle("titre","times","U",12,"255,255,255",0);
$pdf->SetStyle("a","times","BU",9,"0,0,255");
$pdf->SetStyle("pers","times","I",0,"255,0,0");
$pdf->SetStyle("place","arial","U",0,"153,0,0");
$pdf->SetStyle("vb","times","B",0,"102,153,153");
$pdf->SetStyle("mark","times","N",0,"0,0,0",-1,true);


// Titre
$txt="<h1>Rapport plagiat </h1>";
$pdf->SetLineWidth(0.5);
$pdf->SetFillColor(255,225,0);
$pdf->SetDrawColor(102,0,102);
$pdf->WriteTag(0,10,$txt,1,"C",0,5);

$pdf->Ln(15);



$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(102,0,102);
$pdf->SetDrawColor(255,255,255);
$pdf->resultat($similarite*100);
$pdf->Ln(10);

$pdf->titre_paragraphe("Rendu du texte 1 :");
$pdf->Ln(3);

$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(255,255,204);
$pdf->SetDrawColor(102,0,102);
$pdf->WriteTag(0,5,utf8_decode( utf8_decode(utf8_encode($texte))),1,"J",0,7);
$pdf->Ln(5);


$pdf->AddPage();
$pdf->resultat($similarite_2);
$pdf->Ln(10);
$pdf->titre_paragraphe("Rendu du texte 2 :");
$pdf->Ln(3);
$pdf->WriteTag(0,5,utf8_decode($texte_2),1,"J",0,7);
$pdf->Ln(5);



// Signature
$txt="<a href='https://www.univ-smb.fr/'>by L3 informatique USMB</a>";
$pdf->WriteTag(0,10,$txt,0,"R");



$pdf->Output();
?>
