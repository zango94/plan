<?php
include("../../config.php");

$id = trim($_GET['id']);

$wynik = mysql_query("SELECT * FROM rocznik where id=$id") or die('Błąd');
$r = mysql_fetch_assoc($wynik);

$id_op=$r['id_opcje'];

$op = mysql_query("SELECT * FROM opcje where opcje.id=$id_op") or die('Błąd');
$r = mysql_fetch_assoc($op);

$dl_godz=$r['dl_godz'];
$dl_prz=$r['dl_prz'];
$startg=$r['startg'];
$startm=$r['startm'];


$wynik = mysql_query("SELECT rocznik.nazwa rn,grupy.nazwa gn,plan.dzien,plan.godzina,przedmioty.nazwa pn, sale.numer, concat(pracownicy.stopien,' ',pracownicy.imie,' ',pracownicy.nazwisko) nauczyciel FROM rocznik
join grupy on grupy.id_rocznika=rocznik.id
join plan on plan.id_grupa=grupy.id
join pracownicy on pracownicy.id=plan.id_nauczyciel
join przedmioty on przedmioty.id=plan.id_przedmiot
join sale on sale.id=plan.id_sala
                      #where rocznik.id=$id
                      order by plan.dzien, plan.godzina, grupy.nazwa,sale.numer") or die('Błąd');

$wynik = mysql_query("SELECT nazwa FROM rocznik where id=$id") or die('Błąd');
$r = mysql_fetch_assoc($wynik);

ob_start();
echo "<center><h1>".$r['nazwa']."</h1></center></br>";

echo "<table cellspacing=\"0\" cellpadding=\"1\" border=\"1\">";
echo "<tr><th style=\"width:7%;\"></th><th style=\"width:19%;\"><b>Poniedziałek</b></th><th style=\"width:19%;\"><b>Wtorek</b></th><th style=\"width:19%;\"><b>Środa</b></th><th style=\"width:19%;\"><b>Czwartek</b></th><th style=\"width:19%;\"><b>Piątek</b></th></tr>";
$i=1;
While ($i<11){
  $i2=$i+1;
  #echo "<tr><th><b>".$i."-".$i2."</b></th>";
  $s=$startg*60+$startm;
  $pocz=$s+($i-1)*$dl_godz+($i-1)*$dl_prz;
  $kon=$pocz+$dl_godz;


  echo "<tr><th align=\"center\"><b>";
 echo ($pocz/60|0).":";
      if (($pocz%60)<10) { echo "0";}
      echo ($pocz%60);

      echo " - ".($kon/60|0).":";
      if (($kon%60)<10) { echo "0";}
      echo ($kon%60);

  echo "</b></th>";


  $j=1;
  while($j<6){
    echo "<td>";
    $w = mysql_query("SELECT rocznik.nazwa rn,grupy.nazwa gn,plan.dzien,plan.godzina,przedmioty.nazwa pn, sale.numer, concat(pracownicy.stopien,' ',substr(pracownicy.imie,1,1),'. ',pracownicy.nazwisko) nauczyciel FROM rocznik
                              join grupy on grupy.id_rocznika=rocznik.id
                              join plan on plan.id_grupa=grupy.id
                              join pracownicy on pracownicy.id=plan.id_nauczyciel
                              join przedmioty on przedmioty.id=plan.id_przedmiot
                              join sale on sale.id=plan.id_sala
                              where rocznik.id=$id and plan.godzina=$i and plan.dzien=$j
                              order by grupy.nazwa,sale.numer") or die('Błąd');
    if(mysql_num_rows($w) > 0)
    {
        while($p = mysql_fetch_assoc($w)) {
          echo "<b>".$p['gn']."</b>";
          echo "<br />".$p['pn'];
          echo "<br/>".$p['nauczyciel'];
          echo "<br/>".$p['numer']."<br/>";
        }
    }
    echo "</td>";
    $j=$j+1;
  }
  echo "</tr>";
  $i=$i+1;
}
echo "</table>";

$html = ob_get_contents();
ob_end_clean();

#echo $html;




#echo "test".$html."koniec_test";
#break;

//============================================================+
// File name   : example_002.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 002 for TCPDF class
//               Removing Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Removing Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(LANDSCAPE, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 002');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// set font
$pdf->SetFont('freeserif', '', 8);

// add a page
$pdf->AddPage();

// set color for text
//$pdf->SetTextColor(0, 63, 127);

$wypisz= "<center><h2>".$r['nazwa']."</h2></center></br>";

// set some text to print
$txt = <<<EOD
TCPDF Example 002

Default page header and footer are disabled using setPrintHeader() and setPrintFooter() methods.
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td rowspan="3">COL 1 - ROW 1<br />COLSPAN 3</td>
        <td>COL 2 - ROW 1</td>
        <td>COL 3 - ROW 1</td>
    </tr>
    <tr>
        <td rowspan="2">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
        <td>COL 3 - ROW 2</td>
    </tr>
    <tr>
       <td>COL 3 - ROW 3</td>
    </tr>

</table>
EOD;

// print a block of text using Write()
//$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
$pdf->writeHTML($html, true, false, false, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>
