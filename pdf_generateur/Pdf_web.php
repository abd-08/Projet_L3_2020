<?php
session_start();
require 'fpdf182/fpdf.php';

$tablo=[
    [
        'Alors que certains hommes mentionnaient que leur sexualité était cachée à leurs connaissances ou à leurs collègues de travail .',
        'https://www.scribbr.fr/le-plagiat/types-de-plagiat/' ,
        1],
    [
        'Après avoir discuté avec vos élèves de master mon impression positive déjà positif s’est confirmer.' ,
        'https://dumas.ccsd.cnrs.fr/dumas-01698792/document',
        0.3695652173913 ],

    [ 'En tant que tel, la compartimentation de l’identité homosexuelle dans le contexte familial était commune. Cependant, les personnes interrogées ne considéraient pas que leur identité sexuelle était comparée à leur identité ethnique pour se «fermer» elles-mêmes.',
        'https://www.scribbr.fr/le-plagiat/types-de-plagiat/' ,
        0.88805970149254]
];

$tablo = $_SESSION["tableau"];



class myPDF extends FPDF{


    var $widths;
    var $aligns;
    var $tablo;

    function  setTableau($tab){
        $this->tablo = $tab;
    }

    function  resultat(){
        $res=0;
        for ($i=0;$i<count($this->tablo);$i++){
            $res = $res + $this->tablo[$i][2];
        }
        if (count($this->tablo)==0) return 0;
        $res = $res/count($this->tablo);
        return number_format($res, 2);
       // return number_format($res, 2);
    }


    function SetWidths($w)
    {
        //Tableau des largeurs de colonnes
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Tableau des alignements de colonnes
        $this->aligns=$a;
    }

    function Row($data)
    {
        //Calcule la hauteur de la ligne
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Effectue un saut de page si nécessaire
        // $this->CheckPageBreak($h);
        //Dessine les cellules
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Sauve la position courante
            $x=$this->GetX();
            $y=$this->GetY();
            //Dessine le cadre
            $this->Rect($x,$y,$w,$h);
            //Imprime le texte
            $this->MultiCell($w,5, $data[$i],0,$a);
            //Repositionne à droite
            $this->SetXY($x+$w,$y);
        }
        //Va à la ligne
        $this->Ln($h);
    }


    function NbLines($w,$txt)
    {
        //Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    function header(){
        $this->SetFont('Arial','B',14);
        $this->Cell(276,10,'Rapport de plagiat',0,0,'C');
        $this->Ln();
        $this->SetFont('Times','B',30);
        $this->SetTextColor(255,0,0);
        $this->Cell(276,10,$this->resultat()."%",0,0,'C');
        $this->SetTextColor(0,0,0);
        $this->Ln(20);


    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(276,10,'@copyright Groupe 7',0,0,'C');
        //$this->Cell(0,10,'Page '.$this->PageNo.'/{nb}',0,0,'C');

    }
    function headerTable(){
        $this->Image('logo.png',0,0,0,0,'',"https://www.univ-smb.fr/");
        $this->SetFont('Times','B',12);
        $this->ln();

        $this->SetFillColor(255,255,50);
        $this->Cell(140,10,'Phrase',1,0,'C' ,true);
        $this->Cell(90,10,'Site internet',1,0,'C' , true);
        $this->Cell(30,10,'Plagiat',1,0,'C' , true);


        $this->Ln();
    }

    function viewTable($tablo){
        $this->SetFont('Times','',12);


        foreach($tablo as $value){

            $this->Cell(140,10,$value[0],1,0,'C');
            $this->Cell(60,10,$value[1],1,0,'C');
            $this->Cell(60,10,$value[2],1,0,'C');
            $this->Ln();

        }


    }



}
$pdf = new mypdf;
$pdf->setTableau($tablo);
$pdf->AddPage('L','A4',0);

$pdf->SetWidths(array(140,90,30));


$pdf->headerTable();
$pdf->SetFont('Times','',12);
foreach($tablo as $value){
    $pdf->Row(array(
        $value[0],
        $value[1],
        number_format($value[2] , 1),

    ));




}
$pdf->Output();



?>