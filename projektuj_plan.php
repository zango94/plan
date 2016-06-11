<?php
include("config.php");



$a = trim($_GET['a']);
$id = trim($_GET['id']);
$id_planu=$_GET['id_planu'];
$id_przedmiot = ($_GET['id_przedmiot']);
$id_grupa = ($_GET['id_grupa']);
$id_nauczyciel = ($_GET['id_nauczyciel']);
$dzien = ($_GET['dzien']);
$godzina = ($_GET['godzina']);
$id_sala = ($_GET['id_sala']);
$koniec = ($_GET['koniec']);

$error=$_GET["error"];

if($a == 'del') {
    mysql_query("DELETE FROM plan WHERE id='$id_planu'") or die('Błąd zapytania');
    //echo 'Dane zostały usunięte';
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'projektuj_plan.php?a=zobacz&i=us&id='.$id;
	header("Location: http://$host$uri/$extra");
}
if($a == 'addk') {
	$kon = (isset($_GET['koniec'])) ? 1 : 0;
    mysql_query("UPDATE rocznik SET koniec='$kon' WHERE id='$id'") or die('Błąd zapytania');
	mysql_query("UPDATE rocznik SET data=sysdate() WHERE id='$id'") or die('Błąd zapytania');
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'projektuj_plan.php?a=zobacz&i=zap&id='.$id;
	header("Location: http://$host$uri/$extra");
}
if($a == 'add') {
    if (empty($id_przedmiot) OR empty($id_grupa) OR  empty($id_nauczyciel) OR empty($dzien) or empty($godzina) OR empty($id_sala)) {
      
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'projektuj_plan.php?error=1&id_przedmiot=".$id_przedmiot."&id_grupa=".$id_grupa."&id_nauczyciel=".$id_nauczyciel."&dzien=".$dzien."&godzina=".$godzina."&id_sala=".$id_sala."&id=".$id."&a=zobacz';
		header("Location: http://$host$uri/$extra");
	  
    }
    elseif (mysql_num_rows(mysql_query("SELECT * FROM plan where id_sala=$id_sala and dzien=$dzien and godzina=$godzina")) > 0){
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = "projektuj_plan.php?error=2&id_przedmiot=".$id_przedmiot."&id_grupa=".$id_grupa."&id_nauczyciel=".$id_nauczyciel."&dzien=".$dzien."&godzina=".$godzina."&id_sala=".$id_sala."&id=".$id."&a=zobacz";
		header("Location: http://$host$uri/$extra");
    }
    elseif (mysql_num_rows(mysql_query("SELECT * FROM plan where id_nauczyciel=$id_nauczyciel and dzien=$dzien and godzina=$godzina")) > 0){
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = "projektuj_plan.php?error=3&id_przedmiot=".$id_przedmiot."&id_grupa=".$id_grupa."&id_nauczyciel=".$id_nauczyciel."&dzien=".$dzien."&godzina=".$godzina."&id_sala=".$id_sala."&id=".$id."&a=zobacz";
		header("Location: http://$host$uri/$extra");
    }
    elseif (mysql_num_rows(mysql_query("SELECT * FROM plan where id_grupa=$id_grupa and dzien=$dzien and godzina=$godzina")) > 0){
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = "projektuj_plan.php?error=4&id_przedmiot=".$id_przedmiot."&id_grupa=".$id_grupa."&id_nauczyciel=".$id_nauczyciel."&dzien=".$dzien."&godzina=".$godzina."&id_sala=".$id_sala."&id=".$id."&a=zobacz";
		header("Location: http://$host$uri/$extra");
    }
    else {


    /* uaktualniamy tabelÃª test */
    mysql_query("INSERT INTO plan (id_przedmiot,id_grupa,id_nauczyciel,dzien,godzina,id_sala)
                          VALUES ('$id_przedmiot','$id_grupa','$id_nauczyciel','$dzien','$godzina','$id_sala')") or die('Błąd zapytania');

	mysql_query("UPDATE rocznik SET data=sysdate() WHERE id='$id'") or die('Błąd zapytania');

    //echo 'Dane zostały dodane';
	
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'projektuj_plan.php?a=zobacz&i=dod&id='.$id;
		header("Location: http://$host$uri/$extra");
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>System zarządzania planem zajęć</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

  <div class="container">
	<?php include("head.php");?>
	<div class="row">
  <!--  <div class="col-md-4">
      <?php include("left_menu.php") ?>
    </div>-->
		<div class="col-md-12">
      <a class="btn btn-primary btn-large" href="admin.php">Powrót</a>



      			<h2>
      				Plan zajęć
      			</h2>

            <?php
            if ($error==1) {echo "<p class=\"alert alert-danger\" role=\"alert\">Uzupełnij wszystkie pola !!!</p>";}
            if ($error==2) {echo "<p class=\"alert alert-danger\" role=\"alert\">Wybrana sala jest zajęta !!!</p>";}
            if ($error==3) {echo "<p class=\"alert alert-danger\" role=\"alert\">Wybrany wykładowca w tym czasie ma już inne zajęcia !!!</p>";}
            if ($error==4) {echo "<p class=\"alert alert-danger\" role=\"alert\">Wybrana grupa w tym czasie ma już inne zajęcia !!!</p>";}
            if ($_GET['i']=="akt") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały zaktualizowane.</p>";}
            if ($_GET['i']=="us") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały usunięte.</p>";}
            if ($_GET['i']=="dod") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały dodane.</p>";}
			if ($_GET['i']=="zap") {echo "<p class=\"alert alert-success\" role=\"alert\">Zmiana została zapisana.</p>";}

             ?>

            <h3>
      				Wybierz rok studiów
      			</h3>

      <?php

      $wynik = mysql_query("SELECT * FROM rocznik order by nazwa") or die('Błąd');
      if(mysql_num_rows($wynik) > 0) {

          echo "<form method=\"get\" action=\"projektuj_plan.php\">";
          echo "<table class=\"table\" ><tr><td><input type=\"hidden\" name=\"a\" value=\"zobacz\" />";
          echo "<select id=\"wyb\" class=\"form-control\" name=\"id\"  onchange=\"wybi()\">";
          echo "<option value=\"\">Rok studiów</option>";
          while($r = mysql_fetch_assoc($wynik)) {

      	echo "<option value=\"".$r['id']."\">".$r['nazwa']."</option>";
          }
          echo "</select></td><!--<td>
          <input class=\"btn btn-success btn-sm\" type=\"submit\" value=\"Wybierz\" >
          </td>--></table></form>";
        }
		?>


<?php if($a=='zobacz') {

  $wynik = mysql_query("SELECT * FROM rocznik where id=$id") or die('Błąd');
  $r = mysql_fetch_assoc($wynik);

  $id_op=$r['id_opcje'];

  echo "<center><h2>".$r['nazwa']."</h2></center></br>";

  $wynik = mysql_query("SELECT rocznik.nazwa rn,grupy.nazwa gn,plan.dzien,plan.godzina,przedmioty.nazwa pn, sale.numer, concat(pracownicy.stopien,' ',pracownicy.imie,' ',pracownicy.nazwisko) nauczyciel FROM rocznik
join grupy on grupy.id_rocznika=rocznik.id
join plan on plan.id_grupa=grupy.id
join pracownicy on pracownicy.id=plan.id_nauczyciel
join przedmioty on przedmioty.id=plan.id_przedmiot
join sale on sale.id=plan.id_sala

where rocznik.id=$id
order by plan.dzien,plan.godzina,rn,grupy.nazwa,sale.numer") or die('Błąd');

$op = mysql_query("SELECT * FROM opcje where opcje.id=$id_op") or die('Błąd');
$r = mysql_fetch_assoc($op);

$dl_godz=$r['dl_godz'];
$dl_prz=$r['dl_prz'];
$startg=$r['startg'];
$startm=$r['startm'];


    #--------- Tabela ------------
    echo "<table class=\"table table-bordered table-responsive\" ";
    echo "<tr><th></th><th>Poniedziałek</th><th>Wtorek</th><th>Środa</th><th>Czwartek</th><th>Piątek</th></tr>";
    $i=1;
    While ($i<11){
      $i2=$i+1;
      echo "<tr><th>";

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
        $w = mysql_query("SELECT plan.id,rocznik.nazwa rn,grupy.nazwa gn,plan.dzien,plan.godzina,przedmioty.nazwa pn, sale.numer, concat(pracownicy.stopien,' ',substr(pracownicy.imie,1,1),'. ',pracownicy.nazwisko) nauczyciel
                              FROM rocznik
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
              echo "</br>".$p['numer']."&nbsp;&nbsp;&nbsp;
              <a style=\"color:red;\" class=\"\" href=\"projektuj_plan.php?a=del&amp;id={$id}&amp;id_planu={$p['id']}\">Usuń</a></br>";




            }
        }

        echo "</td>";
        $j=$j+1;
      }
      echo "</tr>";
      $i=$i+1;
    }
    echo "</table>";
    echo "<h3>
      Dodaj nowy wpis do planu zajęć
    </h3>";

    echo "<form method=\"get\" action=\"projektuj_plan.php\">";
    echo "<table class=\"table table-responsive\" ";
    echo "<tr><th>Dzień</th><th>Godzina</th><th>Grupa</th><th>Przedmiot</th><th>Sala</th><th>Nauczyciel</th></tr>";
    echo "<tr><td>";
    echo "<input type=\"hidden\" name=\"a\" value=\"add\" >";
    echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
    echo "<select class=\"form-control\" name=\"dzien\">";
      echo "<option ";
      if ($dzien==1) { echo "selected=\"selected\"";   }
      echo "value=\"1\">Poniedziałek</option>";
      echo "<option ";
      if ($dzien==2) { echo "selected=\"selected\"";   }
      echo "value=\"2\">Wtorek</option>";
      echo "<option ";
      if ($dzien==3) { echo "selected=\"selected\"";   }
      echo "value=\"3\">Środa</option>";
      echo "<option ";
      if ($dzien==4) { echo "selected=\"selected\"";   }
      echo "value=\"4\">Czwartek</option>";
      echo "<option ";
      if ($dzien==5) { echo "selected=\"selected\"";   }
      echo "value=\"5\">Piątek</option>";
    echo "</select></td>";
    echo "<td>";
    echo "<select class=\"form-control\" name=\"godzina\">";
    $i=1;
     while ($i<11){
       echo "<option ";
       if ($godzina==$i) {
         echo "selected=\"selected\"";
       }



       $s=$startg*60+$startm;
       $pocz=$s+($i-1)*$dl_godz+($i-1)*$dl_prz;
      # echo ($pocz/60|0).":".($pocz%60);



       echo "value=\"".$i."\">".($pocz/60|0).":";
       if (($pocz%60)<10) { echo "0";}
       echo ($pocz%60)."</option>";

       $i++;
     }
    echo "</select></td>";
    echo "<td><select class=\"form-control\" name=\"id_grupa\">";
    $w = mysql_query("SELECT * FROM grupy where id_rocznika=$id order by nazwa") or die('Błąd');
     while($g = mysql_fetch_assoc($w)) {
       echo "<option ";
       if ($id_rocznika==$g['id']) {
         echo "selected=\"selected\"";
       }
       echo "value=\"".$g['id']."\">".$g['nazwa']."</option>";
     }
    echo "</select></td>";

    echo "<td><select class=\"form-control\" name=\"id_przedmiot\">";
    $w = mysql_query("SELECT * FROM przedmioty order by nazwa") or die('Błąd');
     while($g = mysql_fetch_assoc($w)) {
       echo "<option ";
       if ($id_przedmiot==$g['id']) {
         echo "selected=\"selected\"";
       }
       echo "value=\"".$g['id']."\">".$g['nazwa']."</option>";
     }
    echo "</select></td>";

    echo "<td><select class=\"form-control\" name=\"id_sala\">";
    $w = mysql_query("SELECT * FROM sale order by numer") or die('Błąd');
     while($g = mysql_fetch_assoc($w)) {
       echo "<option ";
       if ($id_sala==$g['id']) {
         echo "selected=\"selected\"";
       }
       echo "value=\"".$g['id']."\">".$g['numer']."</option>";
     }
    echo "</select></td>";

    echo "<td><select class=\"form-control\" name=\"id_nauczyciel\">";
    $w = mysql_query("SELECT id,concat(pracownicy.stopien,' ',substr(pracownicy.imie,1,1),'. ',pracownicy.nazwisko) nauczyciel FROM pracownicy where wykladowca=1 order by nazwisko") or die('Błąd');
     while($g = mysql_fetch_assoc($w)) {
       echo "<option ";
       if ($id_nauczyciel==$g['id']) {
         echo "selected=\"selected\"";
       }
       echo "value=\"".$g['id']."\">".$g['nauczyciel']."</option>";
     }
    echo "</select></td></tr>";

	echo "</table>

	<input class=\"btn btn-success btn-sm\" type=\"submit\" value=\"Dodaj zajęcia\" ></form><br/>";


	echo "<form method=\"get\" action=\"projektuj_plan.php\">";
	echo "<input type=\"hidden\" name=\"a\" value=\"addk\" >";
	echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
	echo "<label class=\"checkbox\" style=\"margin-left: 27px;\">
        <input type=\"checkbox\" value=\"1\" id=\"koniec\" name=\"koniec\" ";
	if ($r['koniec']==1) {
         echo "checked";
       }
	echo "> Wyświetl plan</label><input class=\"btn btn-success btn-sm\" type=\"submit\" value=\"Zapisz\" ></form>";





  }  ?>


		</div>
	</div>



<?php include("foot.php");?>
</div>
<script>
function wybi() {
    var x = document.getElementById("wyb").value;
    window.location.href = "projektuj_plan.php?a=zobacz&id="+x;
}
</script>
</body>
</html>
