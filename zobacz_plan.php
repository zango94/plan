<?php
include("config.php");

$a = trim($_GET['a']);
$id = trim($_GET['id']);
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>System zarządzania planem zajęć</title>
	<link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

  <div class="container">
	<?php include("head.php");?>
	<div class="row">

		<div class="col-md-12">
      <a class="btn btn-primary btn-large" href="index.php">Powrót</a>


      			<h2>
      				Plan zajęć
      			</h2>

            <h3>
      				Wybierz rok studiów
      			</h3>

      <?php

      $wynik = mysql_query("SELECT * FROM rocznik Where koniec=1  order by nazwa") or die('Błąd'); // zapytanie do tabeli rocznik gdzie plan jest skończony
		$i=1;
	if(mysql_num_rows($wynik) > 0) {// jeżeli wynik zapytania > 0 tworzymy tabele z polami do wpisania
		echo "<table class=\"table table-striped table-responsive\" ";
		echo "<tr><th>Lp.</th><th>Nazwa</th><th></th></tr>";
    while($r = mysql_fetch_assoc($wynik)) {
        echo "<tr>";
        echo "<td style=\"vertical-align: middle;\">".$i;
        $i=$i+1;
        echo "<td style=\"vertical-align: middle;\">
		<form action=\"zobacz_plan.php\" method=\"get\"><input type=\"hidden\" name=\"a\" value=\"zobacz\" />
        <input type=\"hidden\" name=\"id\" value=\"".$r['id']."\" />
        <input  class=\"tabela\" type=\"text\" name=\"nazwa\" value=\"".$r['nazwa']."\" /></td>";
		echo "<td style=\"vertical-align: middle;\" class=\"text-right\">
        <input class=\"btn btn-success btn-sm\" type=\"submit\" value=\"Zobacz plan\" /></form>
		</td>";
		   echo "</tr>";
    }
	 echo "</table>";




} ?>


<?php if($a=='zobacz') {

  $wynik = mysql_query("SELECT nazwa,data,id_opcje FROM rocznik where id=$id") or die('Błąd');
  $r = mysql_fetch_assoc($wynik);

  $data=$r['data'];
  $id_op=$r['id_opcje'];

  echo "<center><h2>".$r['nazwa']."</h2></center></br>";

  $wynik = mysql_query("SELECT rocznik.nazwa rn,grupy.nazwa gn,plan.dzien,plan.godzina,przedmioty.nazwa pn, sale.numer, concat(pracownicy.stopien,' ',pracownicy.imie,' ',pracownicy.nazwisko) nauczyciel FROM rocznik
join grupy on grupy.id_rocznika=rocznik.id
join plan on plan.id_grupa=grupy.id
join pracownicy on pracownicy.id=plan.id_nauczyciel
join przedmioty on przedmioty.id=plan.id_przedmiot
join sale on sale.id=plan.id_sala

where rocznik.id=$id and rocznik.koniec=1
order by plan.dzien,plan.godzina,rn,grupy.nazwa,sale.numer") or die('Błąd');



  if(mysql_num_rows($wynik) > 0) {
    /* Wyświetlanie tabeli z planem zajęć */
    echo "<table class=\"table table-bordered table-responsive\" ";
    echo "<tr><th></th><th>Poniedziałek</th><th>Wtorek</th><th>Środa</th><th>Czwartek</th><th>Piątek</th></tr>";
    $i=1;
    While ($i<11){
      $i2=$i+1;
      echo "<tr><th>";

      $op = mysql_query("SELECT * FROM opcje where opcje.id=$id_op") or die('Błąd');
      $r = mysql_fetch_assoc($op);
      $dl_godz=$r['dl_godz'];
      $dl_prz=$r['dl_prz'];
      $startg=$r['startg'];
      $startm=$r['startm'];

      $s=$startg*60+$startm;
      $pocz=$s+($i-1)*$dl_godz+($i-1)*$dl_prz;
      $kon=$pocz+$dl_godz;
      echo ($pocz/60|0).":";
      if (($pocz%60)<10) { echo "0";}
      echo ($pocz%60);

      echo " - ".($kon/60|0).":";
      if (($kon%60)<10) { echo "0";}
      echo ($kon%60);


      echo "</th>";
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
              echo "</br>".$p['pn'];
              echo "</br>".$p['nauczyciel'];
              echo "</br>".$p['numer']."</br>";




            }
        }

        echo "</td>";
        $j=$j+1;
      }
      echo "</tr>";
      $i=$i+1;
    }




    echo "</table>";
 	/* wyświetlanie przycisków do eksportu danych */
      echo "Aktualizacja planu: ".$data;
	  echo "<br/><br/><a class=\"btn btn-primary btn-large\" href=\"csv.php?id=".$id."\">Eksport do CSV</a>&nbsp;";
      echo "<a class=\"btn btn-primary btn-large\" href=\"tcpdf/examples/pdf.php?id=".$id."\">Eksport do PDF</a>";
}
else {
  echo "Plan nie został jeszcze dodany...";
}

  }  ?>

		</div>
	</div>

<?php include("foot.php");?>
</div>

</body>
</html>
