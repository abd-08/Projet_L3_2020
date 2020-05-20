<?php

session_start();
require('WriteTag.php');

$tablo = $_SESSION["tableau"];
$similarite = $_SESSION["resultat"];
$texte = $_SESSION["texte"];


$pdf = new PDF_WriteTag();
$pdf->SetMargins(30, 15, 25);
$pdf->SetFont('courier', '', 12);
$pdf->AddPage();

// Feuille de style
$pdf->SetStyle("p", "times", "N", 10, "0,0,0", 15);
$pdf->SetStyle("h1", "times", "N", 18, "102,0,102", 0);
$pdf->SetStyle("titre", "times", "U", 12, "255,255,255", 0);
$pdf->SetStyle("a", "times", "BU", 9, "0,0,255");
$pdf->SetStyle("pers", "times", "I", 0, "255,0,0");
$pdf->SetStyle("place", "arial", "U", 0, "153,0,0");
$pdf->SetStyle("vb", "times", "B", 0, "102,153,153");
$pdf->SetStyle("mark", "times", "N", 0, "0,0,0", -1, true);


// Titre
$txt = "<h1>Rapport plagiat </h1>";
$pdf->SetLineWidth(0.5);
$pdf->SetFillColor(255, 225, 0);
$pdf->SetDrawColor(102, 0, 102);
$pdf->WriteTag(0, 10, $txt, 1, "C", 0, 5);

$pdf->Ln(20);


$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(102, 0, 102);
$pdf->SetDrawColor(255, 255, 255);
$pdf->resultat($similarite);
$pdf->Ln(20);


$pdf->titre_paragraphe(utf8_decode("Résultat de la recherche:"));
$pdf->Ln(3);

$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(255, 255, 204);
$pdf->SetDrawColor(102, 0, 102);
$pdf->WriteTag(0, 5, utf8_decode($texte), 1, "J", 0, 7);
$pdf->Ln(5);
// Signature
$txt = "<a href='https://www.univ-smb.fr/'>by L3 informatique USMB</a>";
$pdf->WriteTag(0, 10, $txt, 0, "R");


$header = array('Phrase', 'Lien', 'Plagiat');
// Chargement des données
$data = $pdf->LoadData('copie.txt');
$pdf->SetFont('Arial', '', 14);
$pdf->SetMargins(11, 15, 25);
$pdf->AddPage();
$pdf->FancyTable($header, $tablo);


$pdf->Output();

