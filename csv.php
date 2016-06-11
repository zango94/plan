<?php include("config.php");

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



$w = mysql_query("SELECT rocznik.nazwa rn,grupy.nazwa gn,plan.dzien,plan.godzina,przedmioty.nazwa pn, sale.numer, concat(pracownicy.stopien,' ',substr(pracownicy.imie,1,1),'. ',pracownicy.nazwisko) nauczyciel FROM rocznik
                      join grupy on grupy.id_rocznika=rocznik.id
                      join plan on plan.id_grupa=grupy.id
                      join pracownicy on pracownicy.id=plan.id_nauczyciel
                      join przedmioty on przedmioty.id=plan.id_przedmiot
                      join sale on sale.id=plan.id_sala
                      where rocznik.id=$id
                      order by plan.dzien, plan.godzina, grupy.nazwa,sale.numer") or die('Błąd');

$file = fopen('plan.csv', 'w');





if(mysql_num_rows($w) > 0)
{
    while($p = mysql_fetch_assoc($w)) {
      switch ($p['dzien']) {
        case 1:
            $d= "Poniedziałek";
            break;
        case 2:
            $d= "Wtorek";
            break;
        case 3:
            $d= "Środa";
            break;
        case 4:
            $d= "Czwartek";
            break;
        case 5:
            $d= "Piątek";
            break;
        }
	  $rocznik=$p['rn'];

    $s=$startg*60+$startm;
    $pocz=$s+($p['godzina']-1)*$dl_godz+($p['godzina']-1)*$dl_prz;
    ob_start();
      echo ($pocz/60|0).":";
      if (($pocz%60)<10) { echo "0";}
      echo ($pocz%60);
    $godz=ob_get_contents();
    ob_end_clean();

      fwrite($file, $d.",".$godz.",".$p['rn'].",".$p['gn'].",".$p['pn'].",".$p['numer'].",".$p['nauczyciel']."\n");
    }
}

	fclose($file);

//$rocznik=$rocznik.".csv";
//echo $rocznik;

$filename = 'plan.csv';//wybieramy plik do �ci�gni�cia
header('Content-Type:application/force-download');//ustawiamy mu uniwersalny typ mime (mo�na bawi� si� w nadawanie mu application/msword, image/gif, itd...  case "pdf": $ctype="application/pdf"; break;
header('Content-Disposition: attachment; filename="'.basename($filename).'";');//tutaj podajemy nazw� pliku - domy�lnie ustawi�em, aby plik nazywa� si� tak jak orygina�
header('Content-Length:'.@filesize($filename));//dodajemy wielko�� pliku
@readfile($filename)or die('File not found.');//czytamy plik




?>
